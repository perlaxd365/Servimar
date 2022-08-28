<?php

namespace App\Http\Livewire\Reporte;

use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ventasExport;
use Maatwebsite\Excel\Facades\Excel;


class ReporteIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $show;
    public $search;
    //operario
    public $name_operario, $id_operario;
    //criterios de busqueda
    public $fecha_inicio, $fecha_fin;
    //lista de busqueda
    public $listaBusqueda = [];
    //venta
    public $id_venta;

    public function mount()
    {

        date_default_timezone_set('America/Lima');
        $date = Carbon::now();
        $this->fecha_inicio = $date->format('Y-m-d');
        $this->fecha_fin = $date->addDay()->format('Y-m-d');
        $this->show = 5;
    }

    public function render()
    {
        $operarios = User::select('*')
            ->where(function ($query) {
                return $query
                    ->orwhere('name', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('dni', 'LIKE', '%' . $this->search . '%');
            })
            ->join('sedes', 'sedes.id_sede', '=', 'users.id_sede')
            ->paginate($this->show);

        //DETALLE DE VENTAS
        $detalleVenta = Venta::select('*')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->where('id_venta', '=', $this->id_venta)
            ->where('ventas.estado_venta', '=', 'Activo')
            ->paginate($this->show);

        return view('livewire.reporte.reporte-index', compact('operarios', 'detalleVenta'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function seleccionarOperario($id, $nombre)
    {
        $this->id_operario = $id;
        $this->name_operario = $nombre;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetPage();
        $this->listaBusqueda=[];
    }
    public function quitarPersona()
    {

        $this->id_operario = '';
        $this->name_operario = '';
    }

    public function listVentas()
    {
        $rules = [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ];
        $this->validate($rules);
        $fecha_inicio = Carbon::parse($this->fecha_inicio)->format('d/m/Y H:i:s A');
        $fecha_fin = Carbon::parse($this->fecha_fin)->format('d/m/Y H:i:s A');

        $this->listaBusqueda = Venta::select('*')
            ->where(function ($query) {
                return $query
                    ->orwhere('user_create_venta', 'LIKE', '%' . $this->name_operario . '%');
            })
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])
            ->where('ventas.estado_venta', '=', 'Activo')
            ->orderby('fecha_venta', 'desc')
            ->get();
    }
    public function default()
    {

        $date = Carbon::now();
        $this->id_operario = '';
        $this->name_operario = '';
        $this->listaBusqueda=[];
    }
    public function modalDetalle($id_venta)
    {
        $this->id_venta = $id_venta;
    }
    public function exportar()
    {
        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró alguna búsqueda']);
        } else {

            $fecha_inicio = Carbon::parse($this->fecha_inicio)->format('d/m/Y H:i:s A');
            $fecha_fin = Carbon::parse($this->fecha_fin)->format('d/m/Y H:i:s A');
    
            $listaBusqueda = Venta::select('*')
                ->where(function ($query) {
                    return $query
                        ->orwhere('user_create_venta', 'LIKE', '%' . $this->name_operario . '%');
                })
                ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
                ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
                ->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])
                ->where('ventas.estado_venta', '=', 'Activo')
                ->orderby('fecha_venta', 'desc')
                ->get();
                $this->listaBusqueda=[];
            
            return Excel::download(new ventasExport($listaBusqueda), 'users.xlsx');
        }
    }
}

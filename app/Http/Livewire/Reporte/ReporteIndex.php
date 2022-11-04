<?php

namespace App\Http\Livewire\Reporte;

use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ventasExport;
use App\Models\Cliente;
use App\Models\Sede;
use App\Models\TipoPago;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF as PDF;



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
    //sede
    public $id_sede;
    //tipo de pago
    public $id_tipo_pago;

    //id cliente
    public $id_cliente;

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
            ->join('contometros', 'contometros.id_venta', '=', 'ventas.id_venta')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->where('ventas.id_venta', '=', $this->id_venta)
            ->where('ventas.estado_venta', '=', 'Activo')
            ->paginate($this->show);

        $sedes = Sede::all();
        $tipoPagos = TipoPago::All();

        $clientes = Cliente::select(
            'clientes.id_cliente',
            'duenio_cli',
            'razon_cli',
            'ruc_cli',
        )
            ->join('embarcacions', 'embarcacions.id_cliente', '=', 'clientes.id_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('duenio_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('ruc_cli', 'LIKE', '%' . $this->search . '%');
            })
            ->where('estado_cli', '=', true)
            ->groupby('clientes.id_cliente')
            ->paginate($this->show);

        return view('livewire.reporte.reporte-index', compact('operarios', 'detalleVenta', 'sedes', 'tipoPagos', 'clientes'));
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
        $this->listaBusqueda = [];
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
                    ->where('clientes.id_cliente', 'LIKE', '%' . $this->id_cliente . '%')
                    ->where('ventas.user_sede', 'LIKE', '%' . $this->id_sede . '%')
                    ->where('ventas.user_sede', 'LIKE', '%' . $this->id_sede . '%')
                    ->where('user_create_venta', 'LIKE', '%' . $this->name_operario . '%')
                    ->where('ventas.id_tipo_pago', 'LIKE', '%' . $this->id_tipo_pago . '%');
            })
            ->join('contometros', 'contometros.id_venta', '=', 'ventas.id_venta')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('clientes', 'clientes.id_cliente', '=', 'embarcacions.id_cliente')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])
            ->where('ventas.estado_venta', '=', 'Activo')
            ->orderby('fecha_venta', 'desc')
            ->get();
    }
    public function default()
    {

        $date = Carbon::now();
        $this->id_operario = null;
        $this->id_sede = null;
        $this->id_tipo_pago = null;
        $this->name_operario = null;
        $this->listaBusqueda = [];
        $this->defaultCliente();
    }
    public function modalDetalle($id_venta)
    {
        $this->listVentas();
        $this->id_venta = $id_venta;
    }
    public function exportarExcel()
    {
        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró alguna búsqueda']);
        } else {
            $this->listVentas();

            //fecha y hora 

            date_default_timezone_set('America/Lima');
            $date = Carbon::now();
            $date = $date->format('Y_m_d_H_s_A');
            return Excel::download(new ventasExport($this->listaBusqueda), 'reporte_' . $date . '.xlsx');
        }
    }
    public function exportarPdf()
    {


        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró alguna búsqueda']);
        } else {

            $this->listVentas();
            $viewData = [
                'title'         => 'REPORTE DE VENTAS',
                'date'          => date('m/d/Y'),
                'user'          => auth()->user()->name,
                'listaBusqueda' => $this->listaBusqueda
            ];

            //perfil de pdf
            $pdfContent = PDF::loadView('livewire.reporte.pdf.template-view', $viewData)
                ->setPaper('A4', 'landscape')
                ->output();

            //fecha y hora 

            date_default_timezone_set('America/Lima');
            $date = Carbon::now();
            $date = $date->format('Y_m_d_H_s_A');

            //respuesta
            return response()->streamDownload(
                fn () => print($pdfContent),
                "reporte_venta_" . $date . ".pdf"
            );
        }
    }

    public function seleccionarCliente($id_cliente, $razon_cli, $ruc_cli)
    {
        $this->id_cliente = $id_cliente;
        $this->razon_cli = $razon_cli;
        $this->ruc_cli = $ruc_cli;
        $this->dispatchBrowserEvent('close-modal-cliente');
        $this->resetPage();
    }
    public function defaultCliente()
    {
        $this->id_cliente = '';
        $this->razon_cli = '';
        $this->monto_pago = '';
        $this->resetPage();
    }
}

<?php

namespace App\Http\Livewire\ReporteJornada;

use App\Models\Contometro;
use App\Models\Jornada;
use App\Models\Sede;
use App\Models\User;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteJornadaIndex extends Component
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
    //ventas por jornada
    public $detalleVentaJornada = [];
    public $searchVentaJornada, $paginasVentasJornada, $usuarioJornada;
    //contometro
    public $contometro_1, $contometro_a, $contometro_b,$salida_jonada = false;


    public function mount()
    {

        date_default_timezone_set('America/Lima');
        $date = Carbon::now();
        $this->fecha_inicio = $date->format('Y-m-d');
        $this->fecha_fin = $date->addDay()->format('Y-m-d');
        $this->show = 8;
        $this->paginasVentasJornada = 8;
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
        $usuarios = User::select('*')
            ->join('jornadas', 'jornadas.id_user', '=', 'users.id')
            ->join('sedes', 'sedes.id_sede', DB::raw('users.id_sede and id_jornada = (SELECT MAX(id_jornada) from jornadas WHERE jornadas.id_user=users.id)'))

            ->paginate($this->show);



        //SEDES
        $sedes = Sede::all();


        return view('livewire.reporte-jornada.reporte-jornada-index', compact('operarios', 'usuarios', 'sedes'));
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

    public function list_jornadas()
    {
        $rules = [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ];
        $this->validate($rules);
        $fecha_inicio = Carbon::parse($this->fecha_inicio)->format('d/m/Y H:i:s A');
        $fecha_fin = Carbon::parse($this->fecha_fin)->format('d/m/Y H:i:s A');

        $this->listaBusqueda = User::select('*')
            ->join('jornadas', 'jornadas.id_user', '=', 'users.id')
            ->join('sedes', 'sedes.id_sede', DB::raw('users.id_sede and id_jornada = (SELECT MAX(id_jornada) from jornadas WHERE jornadas.id_user=users.id)'))

            ->where(function ($query) {
                return $query
                    ->where('users.id_sede', 'LIKE', $this->id_sede)
                    ->where('users.id', 'LIKE', $this->id_operario);
            })
            ->whereBetween('entrada_jornada', [$fecha_inicio, $fecha_fin])
            ->where('users.estado', true)
            ->get();
    }
    public function default()
    {

        $date = Carbon::now();
        $this->id_operario = null;
        $this->id_sede = null;
        $this->listaBusqueda = [];
    }
    public function modalDetalle($id_venta)
    {
        $this->list_jornadas();
        $this->id_venta = $id_venta;
    }
    public function exportarExcel()
    {
        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró alguna búsqueda']);
        } else {
            $this->list_jornadas();

            //fecha y hora 

            date_default_timezone_set('America/Lima');
            $date = Carbon::now();
            $date = $date->format('Y_m_d_H_s_A');
            //return Excel::download(new ventasExport($this->listaBusqueda), 'reporte_' . $date . '.xlsx');
        }
    }
    public function exportarPdf()
    {


        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró alguna búsqueda']);
        } else {

            $this->list_jornadas();
            $viewData = [
                'title'         => 'REPORTE DE VENTAS',
                'date'          => date('m/d/Y'),
                'user'          => auth()->user()->name,
                'listaBusqueda' => $this->listaBusqueda
            ];

            //perfil de pdf
            $pdfContent = Pdf::loadView('livewire.reporte.pdf.template-view', $viewData)
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

    public function verVentasJornada($user, $entrada, $salida, $id_jornada)
    {
        $this->usuarioJornada = $user;
        $contometro = Contometro::where('id_jornada', $id_jornada)->orderBy('id_contometro', 'asc')->limit(1)->get();
        foreach ($contometro as $key => $value) {
            $this->contometro_1 = $value->contometro_1;
            $this->contometro_a = $value->contometro_a;
            $this->contometro_b = $value->contometro_b;
        }
        if($salida!= null)
        {
            $this->salida_jonada=true;
        }

        //modal ventas por jornada
        $this->detalleVentaJornada = Venta::select('*')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('clientes', 'clientes.id_cliente', '=', 'embarcacions.id_cliente')
            ->join('contometros', 'contometros.id_venta', '=', 'ventas.id_venta')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->where('fecha_venta', '>',  $entrada)
            ->where('ventas.estado_venta', '=', 'Activo')
            ->where('ventas.user_create_venta', '=', $user)
            ->orderby('fecha_venta', 'ASC')
            ->get();
        $this->list_jornadas();
    }
}

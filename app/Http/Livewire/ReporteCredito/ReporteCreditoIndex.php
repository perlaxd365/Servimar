<?php

namespace App\Http\Livewire\ReporteCredito;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sede;
use PDF as PDF;
use Carbon\Carbon;

class ReporteCreditoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $id_sede;
    //buscar cliente
    public $search_cliente, $id_cliente, $razon_cli;
    //numero de vista
    public $show;
    //busqueda principal
    public $listaBusqueda = [];

    public function mount()
    {
        $this->show = 10;
    }
    public function render()
    {
        //buscar cliente
        $clientes = Cliente::select(
            'clientes.id_cliente',
            'duenio_cli',
            'razon_cli',
            'ruc_cli',
        )
            ->join('embarcacions', 'embarcacions.id_cliente', '=', 'clientes.id_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search_cliente . '%')
                    ->orwhere('duenio_cli', 'LIKE', '%' . $this->search_cliente . '%')
                    ->orwhere('ruc_cli', 'LIKE', '%' . $this->search_cliente . '%');
            })
            ->where('estado_cli', '=', true)
            ->groupby('clientes.id_cliente')
            ->paginate($this->show);
        //SEDES
        $sedes = Sede::all();
        return view(
            'livewire.reporte-credito.reporte-credito-index',
            compact(
                'sedes',
                'clientes'
            )
        );
    }
    public function seleccionarCliente($id_cliente, $razon_cli)
    {
        $this->id_cliente = $id_cliente;
        $this->razon_cli = $razon_cli;
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

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function list_creditos()
    {
        $this->listaBusqueda = Cliente::select('*')
            ->join('embarcacions', 'embarcacions.id_cliente', 'clientes.id_cliente')
            ->join('creditos', 'creditos.id_embarcacion', 'embarcacions.id')
            ->where(function ($query) {
                return $query
                    ->where('clientes.id_cliente', 'LIKE', '%' . $this->id_cliente . '%');
            })
            ->where('clientes.estado_cli', true)
            ->where('creditos.estado_Credito', true)
            ->groupby('clientes.id_cliente')
            ->get();
    }


    public function exportarPdf()
    {


        $lista = (array)$this->listaBusqueda;
        if (!$lista) {

            $this->dispatchBrowserEvent('error', ['res' => 'No se encontró búsqueda']);
        } else {

            //fecha y hora 

            date_default_timezone_set('America/Lima');
            $this->list_creditos();
            $viewData = [
                'title'         => 'REPORTE DE CRÉDITO',
                'date'          => date('m/d/Y'),
                'user'          => auth()->user()->name,
                'listaBusqueda' => $this->listaBusqueda
            ];

            //perfil de pdf
            $pdfContent = PDF::loadView('livewire.reporte-credito.pdf.template-view', $viewData)
                ->setPaper('A4')
                ->output();

            $date = Carbon::now();
            $date = $date->format('Y_m_d_H_s_A');

            //respuesta
            return response()->streamDownload(
                fn () => print($pdfContent),
                "reporte_credito_" . $date . ".pdf"
            );
        }
    }
    public function default()
    {

        $this->id_cliente = null;
        $this->listaBusqueda = [];
        $this->defaultCliente();
    }
}

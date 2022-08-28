<?php

namespace App\Http\Livewire\Pago;

use App\Models\Cliente;
use App\Models\DetallePago;
use App\Models\Pago;
use App\Models\Sede;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;

class PagoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $show;
    public $search;
    public $searchPago;
    //
    public $sede;
    //cliente
    public $id_cliente, $razon_cli, $ruc_cli;
    //pago
    public $id_pago, $monto_pago;
    //pago detalle
    public $id_pago_det;


    public function mount()
    {
        $this->show = 5;
        $sedes = Sede::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($sedes as $sede) {
            $this->sede = $sede->descripcion;
        }
        $this->resetPage();
    }


    public function render()
    {
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

        $pagos = Pago::select(
            '*'
        )
            ->join('clientes', 'clientes.id_cliente', '=', 'pagos.id_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->searchPago . '%');
            })
            ->paginate($this->show);

        $detallePagos = DetallePago::select(
            '*'
        )
            ->where('id_pago', '=', $this->id_pago_det)
            ->where('id_credito', '=', NULL)
            ->where('tipo_pago', '=', 'Pago')
            ->orderby('fecha_pago', 'desc')
            ->paginate($this->show);

        return view('livewire.pago.pago-index', compact('clientes', 'pagos', 'detallePagos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function seleccionarCliente($id_cliente, $razon_cli, $ruc_cli)
    {
        $this->id_cliente = $id_cliente;
        $this->razon_cli = $razon_cli;
        $this->ruc_cli = $ruc_cli;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetPage();
    }

    public function store()
    {

        $messages = [
            'id_cliente.required' => 'Por favor selecciona un cliente.',
            'monto_pago.gt' => 'El valor mínimo para agregar es 1.',
        ];

        $rules = [


            'id_cliente' => 'required',
            'monto_pago' => 'gt:0',

        ];
        $this->validate($rules, $messages);


        date_default_timezone_set('America/Lima');
        $pagos = Pago::where('id_cliente', '=', $this->id_cliente)->get();
        if ($pagos) {
            foreach ($pagos as $pago) {
                $this->id_pago = $pago->id_pago;
            }
            if ($this->id_pago) {

                date_default_timezone_set('America/Lima');
                DetallePago::create([
                    'id_pago'               => $this->id_pago,
                    'monto_detalle_pago'    => $this->monto_pago,
                    'tipo_pago'             => 'Pago',
                    'fecha_pago'            => now()->format('d/m/Y H:i:s A'),
                    'user_create_venta' => auth()->user()->name,
                    'user_sede' => $this->sede,
                ]);
                $pago = Pago::find($this->id_pago);
                $pago->update([
                    'monto_pago' => $pago->monto_pago + $this->monto_pago,
                ]);
            } else {

                date_default_timezone_set('America/Lima');
                $pago = Pago::create([
                    'id_cliente' => $this->id_cliente,
                    'monto_pago' => $this->monto_pago,
                    'user_create_venta' => auth()->user()->name,
                    'user_sede' => $this->sede,
                ])->id_pago;

                DetallePago::create([
                    'id_pago'               => $pago,
                    'monto_detalle_pago'    => $this->monto_pago,
                    'tipo_pago'             => 'Pago',
                    'fecha_pago'            => now()->format('d/m/Y H:i:s A'),
                    'user_create_venta' => auth()->user()->name,
                    'user_sede' => $this->sede,
                ]);
            }
        }
        $this->default();

        //$this->dispatchBrowserEvent('print', ['id' => $id_venta]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se agregó el pago correctamente']);
        $this->dispatchBrowserEvent('actualizar-pagina', []);
    }
    public function default()
    {
        $this->id_cliente = '';
        $this->razon_cli = '';
        $this->monto_pago = '';
        $this->resetPage();
    }

    public function detallePagosModal($id_pago_det)
    {
        $this->id_pago_det = $id_pago_det;
        $this->resetPage();
    }

    public function defaulPage()
    {
        $this->resetPage();
    }
}

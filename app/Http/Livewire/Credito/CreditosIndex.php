<?php

namespace App\Http\Livewire\Credito;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\DetallePago;
use App\Models\Embarcacion;
use App\Models\Pago;
use App\Models\Product;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class CreditosIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $show;
    public $search;
    //cliente
    public $id_cliente, $razon_cliente;
    //credito
    public $id_credito;
    //pago
    public $monto_pagar;
    //sede
    public $sede;

    public function mount()
    {
        $this->show = 10;
        $sedes = Sede::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($sedes as $sede) {
            $this->sede = $sede->descripcion;
        }
    }

    public function render()
    {
        $clientes = Cliente::select(
            'clientes.id_cliente',
            'razon_cli',
            'duenio_cli',
            'ruc_cli',
            'nombre_cli'
        )
            ->join('embarcacions', 'embarcacions.id_cliente', '=', 'clientes.id_cliente')
            ->join('creditos', 'creditos.id_embarcacion', '=', 'embarcacions.id')
            ->where(function ($query) {
                return $query
                    ->orwhere('duenio_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('ruc_cli', 'LIKE', '%' . $this->search . '%');
            })
            ->where('estado_cli', '=', true)
            ->orderby('clientes.id_cliente', 'asc')
            ->groupby('clientes.id_cliente')->paginate($this->show);


        $embarcaciones = Credito::select(
            'id',
            'nombre_emb',
            'duenio_emb',
            'matricula_emb',
            'telefono_emb',
            'fecha_credito',
            'monto_credito',
            'galones_credito',
            'precio_galon_credito',
            'id_credito',
        )
            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->where('embarcacions.id_cliente', '=', $this->id_cliente)
            ->where('creditos.estado_credito', '=', true)
            ->orderby('embarcacions.id_cliente', 'asc')
            ->groupby('id_credito')
            ->paginate($this->show);

        $pagos = Pago::select(
            'monto_pago',
        )
            ->join('clientes', 'clientes.id_cliente', '=', 'pagos.id_cliente')
            ->where('pagos.id_cliente', '=', $this->id_cliente)
            ->paginate($this->show);


        $creditoPrePago =  Credito::select(
            'id',
            'nombre_emb',
            'duenio_emb',
            'matricula_emb',
            'telefono_emb',
            'fecha_credito',
            'monto_credito',
            'galones_credito',
            'precio_galon_credito',
            'id_credito',
        )
            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->where('embarcacions.id_cliente', '=', $this->id_cliente)
            ->where('creditos.id_credito', '=', $this->id_credito)
            ->where('creditos.estado_credito', '=', true)
            ->orderby('embarcacions.id_cliente', 'asc')
            ->groupby('id_credito')
            ->paginate($this->show);

        $historialCreditos =   Credito::select(
            'id',
            'nombre_emb',
            'duenio_emb',
            'matricula_emb',
            'telefono_emb',
            'fecha_credito',
            'monto_credito',
            'galones_credito',
            'precio_galon_credito',
            'id_credito',
        )
            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->where('embarcacions.id_cliente', '=', $this->id_cliente)
            ->where('creditos.estado_credito', '=', false)
            ->orderby('embarcacions.id_cliente', 'asc')
            ->groupby('id_credito')
            ->paginate($this->show);
        return view('livewire.credito.creditos-index', compact('clientes', 'embarcaciones', 'pagos', 'creditoPrePago','historialCreditos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function modalDetalle($id_cliente, $razon_cliente)
    {

        $this->razon_cliente = $razon_cliente;
        $this->id_cliente = $id_cliente;
        $this->dispatchBrowserEvent('modal-detalle', ['producto' =>  '']);
    }

    public function modalPago($id_credito)
    {
        $this->id_credito = $id_credito;
    }

    public function store()
    {

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
                    'id_credito'               => $this->id_credito,
                    'monto_detalle_pago'    => $this->monto_pagar,
                    'tipo_pago'             => 'Credito',
                    'fecha_pago'            => now()->format('d/m/Y H:i:s A'),
                    'user_create_venta' => auth()->user()->name,
                    'user_sede' => $this->sede,
                ]);
                $pago = Pago::find($this->id_pago);
                $pago->update([
                    'monto_pago' => $pago->monto_pago - $this->monto_pagar,
                ]);
            } else {
            }
            $credito = Credito::find($this->id_credito);
            $credito->update([

                'estado_credito' => false
            ]);

            $this->dispatchBrowserEvent('close-modal', []);
            $this->dispatchBrowserEvent('respuesta', ['res' => 'Se realizó el pago correctamente.']);
        }
        $this->default();
    }
    public function default()
    {
        $this->monto_pagar = '';
    }
}

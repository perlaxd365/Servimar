<?php

namespace App\Http\Livewire\Credito;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Embarcacion;
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

    public function mount()
    {
        $this->show = 10;
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
            'nombre_emb',
            'duenio_emb',
            'matricula_emb',
            'telefono_emb',
            'fecha_credito',
            'monto_credito',
            'galones_credito',
            'precio_galon_credito'
            )
            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->where('embarcacions.id_cliente', '=', $this->id_cliente)
            ->where('creditos.estado_credito', '=', true)
            ->orderby('embarcacions.id_cliente', 'asc')
            ->groupby('id_credito')
            ->paginate($this->show);


        return view('livewire.credito.creditos-index', compact('clientes', 'embarcaciones'));
    }

    public function modalDetalle($id_cliente, $razon_cliente)
    {

        $this->razon_cliente = $razon_cliente;
        $this->id_cliente = $id_cliente;
        $this->dispatchBrowserEvent('modal-detalle', ['producto' =>  '']);
    }
}

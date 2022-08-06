<?php

namespace App\Http\Livewire\Credito;

use App\Models\Cliente;
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
    public $id_cliente;

    public function mount()
    {
        $this->show = 10;
    }

    public function render()
    {
        $clientes = Cliente::select('*')
            ->where(function ($query) {
                return $query
                    ->orwhere('duenio_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('ruc_cli', 'LIKE', '%' . $this->search . '%');
            })
            ->where('estado_cli', '=', true)
            ->orderby('id_cliente', 'asc')->paginate($this->show);

        $embarcaciones = Embarcacion::select('*')
            ->join('clientes', 'clientes.id_cliente', '=', 'embarcacions.id_cliente')
            ->join('creditos', 'creditos.id_embarcacion', '=', 'embarcacions.id')
            ->where('clientes.id_cliente', '=', $this->id_cliente)
            ->where('creditos.estado_credito', '=', true)
            ->where('clientes.id_cliente', '=', true)
            ->orderby('clientes.id_cliente', 'asc')->paginate($this->show);


        return view('livewire.credito.creditos-index', compact('clientes', 'embarcaciones'));
    }

    public function modalDetalle($id_cliente)
    {

        $this->id_cliente = $id_cliente;
        $this->dispatchBrowserEvent('modal-detalle', ['producto' =>  'a']);
    }
}

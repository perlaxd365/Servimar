<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use App\Models\Embarcacion;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;
    public $embarcaciones;
    protected $paginationTheme = "bootstrap";
    public $search;
    public $searchEmb;
    public $view,$table;
    public $show;
    public function mount()
    {
        $this->embarcaciones = [];
        $this->view = "create";
        $this->table = "cliente";
        $this->show = 10;
    }

    public function render()
    {
        $embarcaciones = $this->embarcaciones;
        $embarcacionesList = Embarcacion::where('estado_cli', '=', true)
            ->join('clientes', 'clientes.id_cliente', '=', 'embarcacions.id_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orwhere('nombre_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('matricula_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('duenio_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('razon_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('ruc_emb', 'LIKE', '%' . $this->searchEmb . '%');
            })->orderby('id', 'asc')->paginate($this->show);


        $clientes = Cliente::select('*')
            ->join('personas', 'personas.id_persona', '=', 'clientes.id_persona')
            ->join('tipo_clientes', 'tipo_clientes.id_tipo_cliente', '=', 'clientes.id_tipo_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('ruc_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telefono_cli', 'LIKE', '%' . $this->search . '%');
            })
            ->where('estado_cli', '=', true)
            ->orderby('id_cliente', 'asc')->paginate($this->show);
        return view('livewire.cliente.clientes-index', compact('clientes', 'embarcaciones', 'embarcacionesList'));
    }

    public function listaDetalle($id)
    {
        $this->embarcaciones = Embarcacion::where('id_cliente', $id)->get();
        $filas = count($this->embarcaciones);
        $this->dispatchBrowserEvent('slider', ['id' => $id, 'filas' => $filas]);
    }
    public function cliente(){
       $this->table='cliente';
    }
    public function embarcacion(){
        $this->table='embarcacion';
    }

}

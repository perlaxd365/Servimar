<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use App\Models\Embarcacion;
use App\Models\Persona;
use App\Models\TipoCliente;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;
    public $embarcaciones;
    protected $paginationTheme = "bootstrap";
    public $search;
    public $searchEmb;
    public $view, $table;
    public $show;
    //Datos de cliente
    public $id_cliente, $duenio_cli, $razon_cli, $dni_cli, $ruc_cli, $nombre_cli, $telefono_cli, $email_cli, $id_tipo_cliente, $id_persona;
    
    //Datos de embarcacion
    public $nombre_emb,$matricula_emb,$duenio_emb,$telefono_emb;
    public function mount()
    {
        $this->embarcaciones = [];
        $this->view = "create";
        $this->table = "cliente";
        $this->show = 10;
    }

    public function render()
    {
        $clientes = Cliente::select('*')
            ->join('personas', 'personas.id_persona', '=', 'clientes.id_persona')
            ->join('tipo_clientes', 'tipo_clientes.id_tipo_cliente', '=', 'clientes.id_tipo_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('duenio_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('ruc_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email_cli', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telefono_cli', 'LIKE', '%' . $this->search . '%');
            })
            ->where('estado_cli', '=', true)
            ->orderby('id_cliente', 'asc')->paginate($this->show);


            
        $embarcaciones = $this->embarcaciones;
        $embarcacionesList = Embarcacion::select('*')
            ->join('clientes', 'clientes.id_cliente', '=', 'embarcacions.id_cliente')
            ->where(function ($query) {
                return $query
                    ->orwhere('nombre_cli', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orwhere('nombre_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('matricula_emb', 'LIKE', '%' . $this->searchEmb . '%')
                    ->orWhere('duenio_emb', 'LIKE', '%' . $this->searchEmb . '%');
            })
            ->where('estado_emb', '=', true)
            ->orderby('id', 'asc')->paginate($this->show);




        $tipoPersona = Persona::all();
        $tipoCliente = TipoCliente::all();
        return view(
            'livewire.cliente.clientes-index',
            compact('clientes', 'embarcaciones', 'embarcacionesList', 'tipoPersona', 'tipoCliente')
        );
    }

    public function store()
    {
        Cliente::create([
            'id_tipo_cliente' => $this->id_tipo_cliente,
            'id_persona' => $this->id_persona,
            'duenio_cli' => $this->duenio_cli,
            'ruc_cli' => $this->ruc_cli,
            'dni_cli' => $this->dni_cli,
            'razon_cli' => $this->razon_cli,
            'nombre_cli' => $this->nombre_cli,
            'telefono_cli' => $this->telefono_cli,
            'email_cli' => $this->email_cli,
            'user_create_cli' => auth()->user()->name,
            'estado_cli' => true

        ]);

        $this->dispatchBrowserEvent('respuesta', ['res' => 'Agregó a ' . $this->duenio_cli . ' con éxito.']);
        $this->default();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingSearchEmb()
    {
        $this->resetPage();
    }

    public function listaDetalle($id)
    {
        $this->embarcaciones = Embarcacion::where('id_cliente', $id)
                                            ->where('estado_emb', true)
                                            ->get();
        $filas = count($this->embarcaciones);
        $this->dispatchBrowserEvent('slider', ['id' => $id, 'filas' => $filas]);
    }
    public function cliente()
    {
        $this->table = 'cliente';
        $this->search = '';
        $this->resetPage();
    }
    public function embarcacion()
    {
        $this->table = 'embarcacion';
        $this->searchEmb = '';
        $this->resetPage();
    }

    public function editar($id)
    {
        $cliente = Cliente::find($id);

        $this->id_cliente = $cliente->id_cliente;
        $this->id_tipo_cliente = $cliente->id_tipo_cliente;
        $this->id_persona = $cliente->id_persona;
        $this->duenio_cli = $cliente->duenio_cli;
        $this->ruc_cli = $cliente->ruc_cli;
        $this->dni_cli = $cliente->dni_cli;
        $this->razon_cli = $cliente->razon_cli;
        $this->nombre_cli = $cliente->nombre_cli;
        $this->telefono_cli = $cliente->telefono_cli;
        $this->email_cli = $cliente->email_cli;

        $this->view = 'editar';
    }
    public function update()
    {
        $cliente = Cliente::find($this->id_cliente);
        $cliente->update([
            'id_tipo_cliente' => $this->id_tipo_cliente,
            'id_persona' => $this->id_persona,
            'duenio_cli' => $this->duenio_cli,
            'ruc_cli' => $this->ruc_cli,
            'dni_cli' => $this->dni_cli,
            'razon_cli' => $this->razon_cli,
            'nombre_cli' => $this->nombre_cli,
            'telefono_cli' => $this->telefono_cli,
            'email_cli' => $this->email_cli,
        ]);



        $this->dispatchBrowserEvent('respuesta', ['res' => 'Actualizó a ' . $this->duenio_cli . ' con éxito.']);

        $this->default();
    }

    public function default()
    {
        $this->id_tipo_cliente = '';
        $this->id_persona = '';
        $this->duenio_cli = '';
        $this->ruc_cli = '';
        $this->dni_cli = '';
        $this->razon_cli = '';
        $this->nombre_cli = '';
        $this->telefono_cli = '';
        $this->email_cli = '';

        $this->view = 'create';
    }
    public function delete($id)
    {
        $cliente = Cliente::find($id);
        $cliente->update([
            'estado_cli' => false
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se eliminó a  ' . $cliente->duenio_cli . ' con éxito.']);
        $this->default();
    }

    public function modalEmbarcacion($id){
        $this->id_cliente='';
        $this->duenio_emb='';
        $this->nombre_emb='';
        $this->matricula_emb='';
        $this->telefono_emb='';
        $cliente=Cliente::find($id);
        $this->id_cliente = $cliente->id_cliente;
        $this->duenio_cli = $cliente->duenio_cli;
        $this->dispatchBrowserEvent('modal', ['cliente' =>  $cliente->duenio_cli]);
    }
    
    public function storeEmbarcacion(){
        Embarcacion::create([
            'id_cliente'=>$this->id_cliente,
            'duenio_emb'=>$this->duenio_emb,
            'nombre_emb'=>$this->nombre_emb,
            'matricula_emb'=>$this->matricula_emb,
            'telefono_emb'=>$this->telefono_emb,
            'user_create_emb'=>auth()->user()->name,
            'estado_emb'=>true,

        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Agregó  ' . $this->duenio_emb . ' a la empresa  ' . $this->duenio_cli ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->default();
    }
    public function deleteEmb($id)
    {
        $embarcacion = Embarcacion::find($id);
        $embarcacion->update([
            'estado_emb' => false
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se eliminó a  ' . $embarcacion->duenio_emb . ' con éxito.']);
        $this->default();
    }


}

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
    public $id_cliente, $razon_cliente, $duenio;
    //credito
    public $id_credito, $precio_galon_credito_form;
    //pago
    public $monto_pagar, $monto_abonado;
    //sede
    public $sede;
    //actualizar precio por galon individual
    public $mostrar_edit_precio = false,
        $precio_galon_credito_individual_form,
        $id_credito_individual_form;
    //activar ventana
    public $credito_pendiente = true, $historial_credito=false;

    public function mount()
    {
        $this->show = 100;
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
            'monto_credito_pagado',
            'galones_credito',
            'precio_galon_credito',
            'id_credito',
            'user_sede'
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


        $historialCreditos =   Credito::select(
            'id',
            'nombre_emb',
            'duenio_emb',
            'matricula_emb',
            'telefono_emb',
            'fecha_credito',
            'monto_credito_pagado',
            'galones_credito',
            'precio_galon_credito',
            'creditos.id_credito',
        )
            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->where('embarcacions.id_cliente', '=', $this->id_cliente)
            ->where('creditos.estado_credito', '=', false)
            ->orderby('embarcacions.id_cliente', 'asc')
            ->groupby('id_credito')
            ->paginate($this->show);
        return view('livewire.credito.creditos-index', compact('clientes', 'embarcaciones', 'pagos', 'historialCreditos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function modalDetalle($id_cliente, $razon_cliente, $duenio)
    {

        $this->razon_cliente = $razon_cliente;
        $this->id_cliente = $id_cliente;
        $this->duenio = $duenio;
        $this->dispatchBrowserEvent('modal-detalle', ['producto' =>  '']);
    }

    public function modalPago($id_credito, $monto_credito)
    {
        $credito = Credito::find($id_credito);
        $credito->update([
            'monto_credito_pagado' => $monto_credito,
            'estado_credito' => false,
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se realizó el pago correctamente']);
    }


    public function modalPrecioGalon($id_cliente, $razon_cliente, $duenio)
    {

        $this->razon_cliente = $razon_cliente;
        $this->id_cliente = $id_cliente;
        $this->duenio = $duenio;
        $this->dispatchBrowserEvent('modal-precio-galon', ['producto' =>  '']);
    }

    public function updatePrecioGalon()
    {
        Credito::
        join('embarcacions','embarcacions.id','creditos.id_embarcacion')
        ->join('clientes','clientes.id_cliente','embarcacions.id_cliente')
        ->where('estado_credito',true)
        ->where('clientes.id_cliente',  $this->id_cliente)
        ->update(array('precio_galon_credito' => $this->precio_galon_credito_form));

        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se actualizó el precio por Galón correctamente']);

        $this->precio_galon_credito_form = '';
    }

    public function editarPrecioIndividual($precio, $id_credito)
    {
        $this->mostrar_edit_precio = true;
        $this->id_credito_individual_form = $id_credito;
        $this->precio_galon_credito_individual_form = $precio;
    }

    public function updatePrecioGalonIndivual()
    {
        $credito = Credito::find($this->id_credito_individual_form);
        $credito->update([
            'precio_galon_credito' => $this->precio_galon_credito_individual_form
        ]);
        $this->limpiarPrecioGalonIndividual();
    }

    public function limpiarPrecioGalonIndividual()
    {

        $this->id_credito_individual_form = null;
        $this->precio_galon_credito_individual_form = null;
        $this->mostrar_edit_precio = false;

    }
}

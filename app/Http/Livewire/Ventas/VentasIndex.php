<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Embarcacion;
use App\Models\Product;
use App\Models\TipoPago;
use Livewire\Component;
use Livewire\WithPagination;

class VentasIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $show;
    //buscar embarcacion
    public $id_emb, $nombre_emb, $searchEmbarcacion;
    //tipo de pago
    public $id_tipo_pago;
    //id_producto
    public $id_producto;
    //datos de venta
    public $galonaje_venta, $precio_venta, $nombre_ref_venta, $dni_ref_venta, $telefono_ref_venta;
    //Producto actual de abastecimiento
    public $precio_general, $stock_actual;

    public function mount()
    {
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($productos as  $producto) {
            $this->precio_general = $producto->precio_pro;
            $this->stock_actual = $producto->stock_pro;
        }

        $this->show = 5;
    }
    public function render()
    {
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        $tipoPagos = TipoPago::All();
        $embarcaciones = Embarcacion::where('nombre_emb', 'LIKE', '%' . $this->searchEmbarcacion . '%')->paginate($this->show);
        return view('livewire.ventas.ventas-index', compact('embarcaciones', 'productos', 'tipoPagos'));
    }
    public function seleccionEmbarcacion($id, $nombre)
    {
        $this->nombre_emb = $nombre;
        $this->id_emb = $id;
        $this->dispatchBrowserEvent('close-modal');
    }

    public function store()
    {

        $messages = [
            'nombre_emb.required' => 'Por favor selecciona una embarcación.',
            'galonaje_venta.gt' => 'El valor mínimo para agregar es 1.',
            'id_tipo_pago.required' => 'Por favor seleccionar un tipo de pago.',
            'galonaje_venta.lt' => 'La venta no puede exeder los ' . $this->stock_actual . ' Galones.',
            'precio_venta.gt' => 'El valor mínimo para agregar es 1.',
        ];

        $rules = [


            'nombre_emb' => 'required',
            'galonaje_venta' => 'gt:0|lt:' . $this->stock_actual,
            'id_tipo_pago' => 'required',
            'precio_venta' => 'gt:0',
            'nombre_ref_venta' => 'required',


        ];
        $this->validate($rules, $messages);
    }

    public function calcularTotal()
    {
            if($this->galonaje_venta!=null){
            $this->precio_venta = $this->galonaje_venta * $this->precio_general;
            }
    }
    public function updatingSearchEmbarcacion()
    {
        $this->resetPage();
    }
}

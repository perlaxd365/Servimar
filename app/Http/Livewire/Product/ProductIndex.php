<?php

namespace App\Http\Livewire\Product;

use App\Models\Kardex;
use App\Models\Product;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;
    public $show;
    protected $paginationTheme = "bootstrap";
    public $search,$searchKardex;
    public $id_producto, $nombre_pro,$precio_pro;
    //stock
    public $stock_pro, $motivo;
    public function mount()
    {
        $this->show = 10;
        $this->nombre_pro = '';
    }
    public function render()
    {
        $productos = Product::select('*')
            ->join('sedes', 'sedes.id_sede', '=', 'products.id_sede')
            ->where('nombre_pro', 'LIKE', '%' . $this->search . '%')
            ->get();

        $kardexs = Kardex::select('*','kardexes.created_at as fecha_kardex')
        ->join('tipo_movimientos', 'tipo_movimientos.id_tipo_movimiento', '=', 'kardexes.id_tipo_movimiento')
        ->join('products', 'products.id_producto', '=', 'kardexes.id_producto')
        ->join('sedes', 'sedes.id_sede', '=', 'products.id_sede')
            ->where('descripcion', 'LIKE', '%' . $this->searchKardex . '%')
            ->orderby('id_kardex','desc')
            ->paginate($this->show);
        $sedes = Sede::all();
        return view('livewire.product.product-index', compact('sedes', 'productos', 'kardexs'));
    }

    public function modalAdd($id)
    {
        $producto = Product::find($id);
        $this->motivo = 'Aumentar';
        $this->stock_pro = '';
        $this->id_producto = $id;
        $this->nombre_pro = $producto->nombre_pro;
        $this->dispatchBrowserEvent('modal', ['producto' =>  $producto->nombre_pro]);
    }
    public function Aumentar()
    {


        $messages = [
            'stock_pro.gt' => 'El valor mínimo para agregar es 1',
        ];

        $rules = [


            'stock_pro' => 'gt:0',

        ];
        $this->validate($rules, $messages);
        //ACTUALIZAR STOCK A  PRODUCTO
        $producto = Product::find($this->id_producto);
        $monto = $this->stock_pro;
        $this->stock_pro = $this->stock_pro + $producto->stock_pro;
        //ACTUALIZAR STOCK A  PRODUCTO
        $producto->update([
            'stock_pro' => $this->stock_pro,
        ]);
        //AÑADIR A KARDEX
        Kardex::create([
            'id_producto' => $this->id_producto,
            'id_tipo_movimiento' => 1,
            'cantidad_kar' => $monto,
            'total_kar' => $this->stock_pro,
            'user_create_kar' => auth()->user()->name,
        ]);


        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se agregó ' . $monto . ' ' . $producto->unidad_pro . ' a  ' . $producto->nombre_pro]);

        $this->stock_pro = '';
    }

    public function modalSub($id)
    {
        $this->motivo = 'Disminuir';
        $this->stock_pro = '';
        $producto = Product::find($id);
        $this->id_producto = $id;
        $this->nombre_pro = $producto->nombre_pro;
        $this->dispatchBrowserEvent('modal', ['producto' =>  $producto->nombre_pro]);
    }
    public function modalEdit($id)
    {
        $this->motivo = 'Editar';
        $producto = Product::find($id);
        $this->id_producto = $id;
        $this->nombre_pro = $producto->nombre_pro;
        $this->precio_pro = $producto->precio_pro;
        $this->dispatchBrowserEvent('modal-edit', ['producto' =>  $producto->nombre_pro]);
    }

    public function update_producto(){
        
        $producto = Product::find($this->id_producto);
        $producto->update([
            'nombre_pro'=>$this->nombre_pro,
            'precio_pro'=>$this->precio_pro,
        ]);
        $this->dispatchBrowserEvent('close-modal-update');
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se actualizó ' . $this->nombre_pro]);

    }

    public function Disminuir()
    {


        //ACTUALIZAR STOCK A  PRODUCTO
        $producto = Product::find($this->id_producto);

        //VALIDAR
        $messages = [
            'stock_pro.gt' => 'El valor mínimo para agregar es 1',
            'stock_pro.lt' => 'El valor máximo para disminuir es ' . $producto->stock_pro,
        ];

        $rules = [


            'stock_pro' => 'gt:0|lt:' . $producto->stock_pro,

        ];
        $this->validate($rules, $messages);
        $monto = $this->stock_pro;
        $this->stock_pro = $producto->stock_pro - $this->stock_pro;
        $producto->update([
            'stock_pro' => $this->stock_pro,
        ]);

        Kardex::create([
            'id_producto' => $this->id_producto,
            'id_tipo_movimiento' => 2,
            'cantidad_kar' => $monto,
            'total_kar' => $this->stock_pro,
            'user_create_kar' => auth()->user()->name,
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se quitó  ' . $monto . ' ' . $producto->unidad_pro . ' a  ' . $producto->nombre_pro]);

        $this->stock_pro = '';
    }
}

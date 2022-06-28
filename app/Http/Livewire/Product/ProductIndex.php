<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;
    public $show;
    protected $paginationTheme = "bootstrap";
    public $search;
    public function mount()
    {
        $this->show = 10;
    }
    public function render()
    {
        $productos=Product::select('*')
        ->join('sedes', 'sedes.id_sede', '=', 'products.id_sede')
        ->where('nombre_pro', 'LIKE', '%' . $this->search . '%')
        ->paginate($this->show);
        $sedes=Sede::all();
        return view('livewire.product.product-index',compact('sedes','productos'));
    }
    
    public function modalAdd($id){
        $productos=Product::find($id);
        $this->dispatchBrowserEvent('modal', ['producto' =>  $productos->nombre_pro]);
    }
}

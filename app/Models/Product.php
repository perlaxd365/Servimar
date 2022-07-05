<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $name="product";
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'id_sede' ,
        'nombre_pro', 
        'stock_pro',
        'precio_pro',
        'unidad_pro',
        'estado_pro'
    ];
}

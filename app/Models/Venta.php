<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $name="ventas";
    protected $primaryKey = 'id_venta';
    protected $fillable = [
        'id_embarcacion',
        'id_producto',
        'id_tipo_pago',
        'galonaje_venta',
        'precio_venta',
        'moneda_venta',
        'nombre_ref_venta',
        'dni_ref_venta',
        'telefono_ref_venta',
        'fecha_venta',
        'estado_venta',
        'mostrar_venta',
        'user_create_venta',
        'user_sede',
    ];
}

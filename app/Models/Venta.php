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
        'precio_x_galon_venta',
        'nombre_producto',
        'monto_inicial_venta',
        'precio_venta',
        'moneda_venta',
        'nombre_ref_venta',
        'dni_ref_venta',
        'telefono_ref_venta',
        'fecha_venta',
        'nombre_banco_venta',
        'num_operacion_venta',
        'estado_venta',
        'observacion_venta',
        'mostrar_venta',
        'user_create_venta',
        'user_sede',
    ];
}

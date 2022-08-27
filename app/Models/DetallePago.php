<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;
    protected $name="detalle_pagos";
    protected $primaryKey = 'id_detalle_pago';
    protected $fillable = [
        'id_credito',
        'id_pago',
        'monto_detalle_pago',
        'tipo_pago',
        'fecha_pago',
        'user_create_venta',
        'user_sede',
    ];
}

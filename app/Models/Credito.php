<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;
    protected $name="creditos";
    protected $primaryKey = 'id_credito';
    protected $fillable = [
        'id_embarcacion' ,
        'id_venta', 
        'precio_galon_credito',
        'galones_credito',
        'monto_credito_pagado',
        'fecha_credito',
        'estado_credito',
        'user_create_credito'
    ];
}

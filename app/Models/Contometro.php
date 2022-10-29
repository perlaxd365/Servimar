<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contometro extends Model
{
    use HasFactory;
    protected $name="contometros";
    protected $primaryKey = 'id_contometro';
    protected $fillable = [
        'id_venta' ,
        'id_sede', 
        'id_jornada', 
        'contometro_1',
        'contometro_a',
        'contometro_b',
        'estado_contometro',
        'user_create',
        'user_sede',
    ];
}

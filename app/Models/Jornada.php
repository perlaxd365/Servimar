<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $name="jornadas";
    protected $primaryKey = 'id_jornada';
    protected $fillable = [
        'entrada_jornada' ,
        'salida_jornada',
        'estado_jornada',
        'user_create_jornada',
        'user_sede',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $name="clientes";
    protected $fillable = [
        'id_cliente',
        'ruc_cli',
        'dni_cli',
        'razon_cli',
        'nombre_cli',
        'telefono_cli',
        'correo_cli',
        'estado_cli',
    ];
}

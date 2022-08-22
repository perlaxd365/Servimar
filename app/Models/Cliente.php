<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $name="clientes";
    protected $primaryKey = 'id_cliente';
    protected $fillable = [
        'id_persona', 
        'id_cliente',
        'duenio_cli',
        'ruc_cli',
        'dni_cli',
        'razon_cli',
        'nombre_cli',
        'telefono_cli',
        'email_cli',
        'user_create_cli',
        'estado_cli',
    ];
}

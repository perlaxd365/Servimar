<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    use HasFactory;
    protected $name="tipo_clientes";
    protected $fillable = [
        'nombre_tipo',
    ];
}

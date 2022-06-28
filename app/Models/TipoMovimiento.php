<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;
    protected $name="tipo_movimiento";
    protected $fillable = [
        'nombre_tipo',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    use HasFactory;
    protected $name="tipo_pago";
    protected $fillable = [
        'nombre_tipo_pago',
    ];
}

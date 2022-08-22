<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmbarcacion extends Model
{
    use HasFactory;
    protected $name="tipo_embarcacion";
    protected $fillable = [
        'nombre_tipo',
    ];
}

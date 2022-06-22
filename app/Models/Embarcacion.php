<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarcacion extends Model
{
    use HasFactory;
    protected $name="embarcacion";
    protected $fillable = [
        'id_cliente',
        'nombre_emb',
        'duenio_emb',
        'razon_emb',
        'ruc_emb',  
        'matricula_emb',  
        'telefono_emb',  
        'estado_emb',  
    ];
}

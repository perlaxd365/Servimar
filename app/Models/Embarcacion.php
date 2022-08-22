<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarcacion extends Model
{
    use HasFactory;
    protected $name="embarcacion";
    protected $fillable = [
        'id_tipo_embarcacion',
        'id_cliente',
        'nombre_emb',
        'duenio_emb',
        'matricula_emb',  
        'telefono_emb',  
        'user_create_emb', 
        'estado_emb',  
    ];
}

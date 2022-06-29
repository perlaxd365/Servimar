<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $name="kardexes";
    protected $primaryKey = 'id_kardex';
    protected $fillable = [
        'id_producto',
        'id_tipo_movimiento', 
        'cantidad_kar', 
        'total_kar', 
        'user_create_kar', 
    ];
}

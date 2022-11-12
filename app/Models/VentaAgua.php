<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaAgua extends Model
{
    use HasFactory;
    protected $name="venta_aguas";
    protected $primaryKey = 'id_venta_agua';
    protected $fillable = [
        'id_venta_agua',
        'id_embarcacion',
        'monto_agua',
        'contometro_agua',
        'fecha_venta_agua',
        'user_create_venta',
        'user_sede',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $name="pagos";
    protected $primaryKey = 'id_pago';
    protected $fillable = [
        'id_pago',
        'id_cliente',
        'monto_pago',
        'user_create_venta',
        'user_sede',
    ];
}

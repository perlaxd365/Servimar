<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class printController extends Controller
{
    public function index($id)
    {
        $ventas = Venta::select('*')
            ->join('embarcacions', 'embarcacions.id', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', 'ventas.id_tipo_pago')
            ->where('ventas.id_venta',$id)
            ->get();
        print_r(json_encode($ventas));
    }
}

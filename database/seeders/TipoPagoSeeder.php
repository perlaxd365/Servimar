<?php

namespace Database\Seeders;

use App\Models\TipoPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TipoPago::create([
            "nombre_tipo_pago"=>'Efectivo',
        ]);
        TipoPago::create([
            "nombre_tipo_pago"=>'Credito',
        ]);
        TipoPago::create([
            "nombre_tipo_pago"=>'Deposito',
        ]);
    }
}

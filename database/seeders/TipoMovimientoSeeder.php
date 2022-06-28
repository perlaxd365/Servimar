<?php

namespace Database\Seeders;

use App\Models\TipoMovimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TipoMovimiento::create([
            "nombre_tipo"=>'Entrada',
        ]);
        TipoMovimiento::create([
            "nombre_tipo"=>'Salida',
        ]);
    }
}

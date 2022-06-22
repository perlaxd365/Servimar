<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TipoCliente::create([
            "nombre_tipo"=>'Tipo 1',
        ]);
        TipoCliente::create([
            "nombre_tipo"=>'Tipo 2',
        ]);
        TipoCliente::create([
            "nombre_tipo"=>'Tipo 3',
        ]);
        TipoCliente::create([
            "nombre_tipo"=>'Tipo 4',
        ]);
    }
}

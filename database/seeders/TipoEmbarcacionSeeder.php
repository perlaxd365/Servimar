<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use App\Models\TipoEmbarcacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEmbarcacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TipoEmbarcacion::create([
            "nombre_tipo"=>'Anchovetera',
        ]);
        TipoEmbarcacion::create([
            "nombre_tipo"=>'Poteras',
        ]);
        TipoEmbarcacion::create([
            "nombre_tipo"=>'Periquera',
        ]);
        TipoEmbarcacion::create([
            "nombre_tipo"=>'Industriales',
        ]);
    }
}

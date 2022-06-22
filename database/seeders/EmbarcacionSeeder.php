<?php

namespace Database\Seeders;

use App\Models\Embarcacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmbarcacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Embarcacion::create([

            'id_cliente'=>'1',
            'nombre_emb'=>'LA PERLI',
            'duenio_emb'=>'Cesar Antinio Baca',
            'razon_emb'=>'LUKAREL',
            'ruc_emb'=>'10323203203',
            'matricula_emb'=>'345-AKA',
            'telefono_emb'=>'947228623',
            'estado_emb'=>true,
        ]);

        Embarcacion::factory(30)->create();
    }
}

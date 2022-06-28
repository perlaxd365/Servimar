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
            'matricula_emb'=>'345-AKA',
            'telefono_emb'=>'947228623',
            'user_create_emb'=>'Servimar',
            'estado_emb'=>true,
        ]);

        Embarcacion::factory(30)->create();
    }
}

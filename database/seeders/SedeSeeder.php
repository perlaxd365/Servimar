<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Sede::create([
            "descripcion"=>'Gildemeister',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Chata Chimbote',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Cridany',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Chata Paita',
            "estado"=>'1'
        ]);
        
    }
}

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
            "descripcion"=>'Sede 1',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Sede 2',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Sede 3',
            "estado"=>'1'
        ]);
        Sede::create([
            "descripcion"=>'Sede 4',
            "estado"=>'1'
        ]);
        
    }
}

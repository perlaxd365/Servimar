<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Product::create([

            'id_sede'=>'1',
            'nombre_pro'=>'Abastecimiemto de Petroleo 1',
            'stock_pro'=>100.20,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'2',
            'nombre_pro'=>'Abastecimiemto de Petroleo 2',
            'stock_pro'=>189.80,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'3',
            'nombre_pro'=>'Abastecimiemto de Petroleo 3',
            'stock_pro'=>52.90,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'4',
            'nombre_pro'=>'Abastecimiemto de Petroleo 4',
            'stock_pro'=>176.30,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
    }
}

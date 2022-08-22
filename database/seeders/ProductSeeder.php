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
            'nombre_pro'=>'Petroleo Diesel',
            'stock_pro'=>10000,
            'precio_pro'=>17.50,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'2',
            'nombre_pro'=>'Petroleo Diesel',
            'stock_pro'=>10000,
            'precio_pro'=>17.50,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'3',
            'nombre_pro'=>'Petroleo Diesel',
            'stock_pro'=>10000,
            'precio_pro'=>17.50,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
        Product::create([

            'id_sede'=>'4',
            'nombre_pro'=>'Petroleo Diesel',
            'stock_pro'=>10000,
            'precio_pro'=>17.50,
            'unidad_pro'=>'Galones',
            'estado_pro'=>true,
        ]);
    }
}

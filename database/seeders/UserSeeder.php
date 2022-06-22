<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "id_sede"=>'1',
            "name"=>'Cesar Raul Baca',
            "dni"=>'73888312',
            "email"=>'perlaxd365@gmail.com',
            "password"=>bcrypt('12345678'),
            "estado"=>'1',
        ])->assignRole('Admin');
        
        User::factory(50)->create();
    }
}

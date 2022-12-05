<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            "id_sede"=>'4',
            "name"=>'Cesar Raul Baca',
            "dni"=>'73888312', 
            "email"=>'perlaxd365@gmail.com',
            "password"=>bcrypt('12345678'),
            "estado"=>'1',
        ])->assignRole('Admin');date_default_timezone_set('America/Lima');
        DB::table('jornadas')->insert(
            [
                'id_user'    => 1,
                'entrada_jornada'   => now()->format('d/m/Y H:i:s A'), 
                'estado_jornada'    => true,
                'user_create_jornada' => 'Cesar Raul Baca',
                'user_sede'         => 'Chata Paita'
            ]
        );
        
    }
}

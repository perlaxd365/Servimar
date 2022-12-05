<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'id_persona' => '1',
            'duenio_cli' => 'Chita',
            'ruc_cli' => '10738883123',
            'dni_cli' => '73888312',
            'razon_cli' => 'Perli S.A.C.',
            'nombre_cli' => 'Cesar Raul Baca',
            'telefono_cli' => '902517849',
            'email_cli' => 'perlaxd365@gmail.com',
            'user_create_cli' => 'Admin',
            'estado_cli' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Product;
use App\Models\TipoCliente;
use App\Models\TipoMovimiento;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    
        $this->call(PersonaSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TipoClienteSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(EmbarcacionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TipoMovimientoSeeder::class);
        $this->call(TipoPagoSeeder::class);
    }
}

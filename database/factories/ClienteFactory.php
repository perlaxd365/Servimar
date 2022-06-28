<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'id_tipo_cliente' =>  $this->faker->randomElement(['1', '2', '3', '4']),
            'id_persona' =>  $this->faker->randomElement(['1', '2']),
            'duenio_cli' => $this->faker->name(),
            'ruc_cli' => $this->faker->randomNumber(8),
            'dni_cli' => $this->faker->randomNumber(8),
            'razon_cli' => $this->faker->company(),
            'nombre_cli' => $this->faker->name(),
            'telefono_cli' => $this->faker->phoneNumber(),
            'email_cli' => $this->faker->email(),
            'user_create_cli' =>'Servimar',
            'estado_cli' => true,
        ];
    }
}

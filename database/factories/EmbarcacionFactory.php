<?php

namespace Database\Factories;

use App\Models\Embarcacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmbarcacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Embarcacion::class;
    public function definition()
    {
        return [
            
            'id_tipo_embarcacion' =>  $this->faker->randomElement(['1', '2', '3', '4']),
            'id_cliente' =>  $this->faker->randomElement(['1', '2', '3','4','5','6','7','8','9','10']),
            'nombre_emb' => $this->faker->name(),
            'duenio_emb' => $this->faker->name(),
            'matricula_emb' => $this->faker->randomNumber(6),
            'telefono_emb' => $this->faker->phoneNumber(),
            'user_create_emb' => 'Servimar',
            'estado_emb' => true,
        ];
    }
}

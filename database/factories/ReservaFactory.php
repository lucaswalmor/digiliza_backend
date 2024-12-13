<?php

namespace Database\Factories;

use App\Models\Mesa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horario = $this->faker->dateTimeBetween('18:00', '23:00');
        
        return [
            'user_id'   => User::factory(),
            'mesa_id'   => Mesa::inRandomOrder()->first()->id,
            'dat_inicio' => $this->faker->date(),
            'horario'    => $horario->format('H:i'),
        ];
    }
}

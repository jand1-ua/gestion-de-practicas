<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Practica;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Practica>
 */
class PracticaFactory extends Factory
{
    protected $model = Practica::class;

    public function definition(): array
    {
        $fechaInicio = fake()->dateTimeBetween('-6 months', '+1 month');
        $fechaFin    = fake()->optional()->dateTimeBetween($fechaInicio, '+6 months');

        return [
            'alumno_id'     => Alumno::factory(),
            'empresa_id'    => Empresa::factory(),
            'tutor_id'      => Tutor::factory(),
            'fecha_inicio'  => $fechaInicio,
            'fecha_fin'     => $fechaFin,
            'estado'        => fake()->randomElement(['pendiente', 'en_curso', 'finalizada']),
            'observaciones' => fake()->optional()->paragraph(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Practica $practica) {
            // Mantener coherencia: el tutor pertenece a la misma empresa de la práctica.
            if ($practica->tutor && (int) $practica->tutor->empresa_id !== (int) $practica->empresa_id) {
                $practica->tutor->update(['empresa_id' => $practica->empresa_id]);
            }
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alumno>
 */
class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'email'  => fake()->unique()->safeEmail(),
            'grado'  => fake()->randomElement(Alumno::gradosDisponibles()),
            'curso'  => fake()->randomElement(Alumno::cursosDisponibles()),
        ];
    }
}

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
            'grado'  => fake()->randomElement([
                'Ingeniería Informática',
                'Ingeniería Industrial',
                'Administración de Empresas',
            ]),
            'curso'  => fake()->randomElement(['1º', '2º', '3º', '4º']),
        ];
    }
}

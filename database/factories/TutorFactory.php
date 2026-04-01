<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tutor>
 */
class TutorFactory extends Factory
{
    protected $model = Tutor::class;

    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'nombre'     => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'telefono'   => '+34' . fake()->numerify('#########'),
        ];
    }
}

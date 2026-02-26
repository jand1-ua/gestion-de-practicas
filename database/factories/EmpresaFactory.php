<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Empresa>
 */
class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'nombre'            => fake()->company(),
            'cif'               => fake()->unique()->regexify('[A-Z][0-9]{8}'),
            'sector'            => fake()->randomElement([
                'Tecnología',
                'Consultoría',
                'Industria',
                'Servicios',
            ]),
            'ciudad'            => fake()->city(),
            'email_contacto'    => fake()->companyEmail(),
            'telefono_contacto' => fake()->phoneNumber(),
        ];
    }
}

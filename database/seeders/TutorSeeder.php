<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa1 = Empresa::where('cif', 'B12345678')->first();
        $empresa2 = Empresa::where('cif', 'A87654321')->first();

        if ($empresa1) {
            Tutor::updateOrCreate(
                ['email' => 'carlos.ruiz@techsolutions.com'],
                [
                    'empresa_id' => $empresa1->id,
                    'nombre'     => 'Carlos Ruiz',
                    'telefono'   => '600111222',
                ]
            );
        }

        if ($empresa2) {
            Tutor::updateOrCreate(
                ['email' => 'elena.martinez@softedu.com'],
                [
                    'empresa_id' => $empresa2->id,
                    'nombre'     => 'Elena Martínez',
                    'telefono'   => '600333444',
                ]
            );
        }

        Empresa::query()->inRandomOrder()->take(5)->get()->each(function (Empresa $empresa) {
            Tutor::factory(fake()->numberBetween(1, 3))->create([
                'empresa_id' => $empresa->id,
            ]);
        });
    }
}

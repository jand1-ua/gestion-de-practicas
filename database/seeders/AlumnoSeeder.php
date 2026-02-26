<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumno::updateOrCreate(
            ['email' => 'ana.garcia@example.com'],
            ['nombre' => 'Ana García', 'grado' => 'Ingeniería Informática', 'curso' => '4º']
        );

        Alumno::updateOrCreate(
            ['email' => 'luis.perez@example.com'],
            ['nombre' => 'Luis Pérez', 'grado' => 'Ingeniería Informática', 'curso' => '3º']
        );

        Alumno::updateOrCreate(
            ['email' => 'maria.lopez@example.com'],
            ['nombre' => 'María López', 'grado' => 'Ingeniería Informática', 'curso' => '4º']
        );

        Alumno::factory(10)->create();
    }
}

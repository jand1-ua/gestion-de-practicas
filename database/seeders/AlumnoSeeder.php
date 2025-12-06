<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumnos')->insert([
            [
                'nombre' => 'Ana García',
                'email' => 'ana.garcia@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '4º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis Pérez',
                'email' => 'luis.perez@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '3º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María López',
                'email' => 'maria.lopez@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '4º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PracticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('practicas')->insert([
            [
                'alumno_id' => 1,
                'empresa_id' => 1,
                'tutor_id' => 1,
                'fecha_inicio' => '2025-02-01',
                'fecha_fin' => '2025-06-30',
                'estado' => 'en_curso',
                'observaciones' => 'Prácticas de desarrollo web en Laravel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'alumno_id' => 2,
                'empresa_id' => 2,
                'tutor_id' => 2,
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => null,
                'estado' => 'pendiente',
                'observaciones' => 'Pendiente de firma de convenio.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

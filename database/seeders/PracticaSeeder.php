<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Practica;
use App\Models\Tutor;

class PracticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ana   = Alumno::where('email', 'ana.garcia@example.com')->first();
        $luis  = Alumno::where('email', 'luis.perez@example.com')->first();

        $tech  = Empresa::where('cif', 'B12345678')->first();
        $soft  = Empresa::where('cif', 'A87654321')->first();

        $tutorTech = Tutor::where('email', 'carlos.ruiz@techsolutions.com')->first();
        $tutorSoft = Tutor::where('email', 'elena.martinez@softedu.com')->first();

        if ($ana && $tech && $tutorTech) {
            Practica::updateOrCreate(
                [
                    'alumno_id'  => $ana->id,
                    'empresa_id' => $tech->id,
                    'tutor_id'   => $tutorTech->id,
                ],
                [
                    'fecha_inicio'  => '2025-02-01',
                    'fecha_fin'     => '2025-06-30',
                    'estado'        => 'en_curso',
                    'observaciones' => 'Prácticas de desarrollo web en Laravel.',
                ]
            );
        }

        if ($luis && $soft && $tutorSoft) {
            Practica::updateOrCreate(
                [
                    'alumno_id'  => $luis->id,
                    'empresa_id' => $soft->id,
                    'tutor_id'   => $tutorSoft->id,
                ],
                [
                    'fecha_inicio'  => '2025-03-01',
                    'fecha_fin'     => null,
                    'estado'        => 'pendiente',
                    'observaciones' => 'Pendiente de firma de convenio.',
                ]
            );
        }

        Practica::factory(12)->create();
    }
}

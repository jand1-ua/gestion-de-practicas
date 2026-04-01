<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Coordinador de Prácticas', 'email' => 'coordinador@example.com'],
            ['name' => 'Coordinación Adjunta', 'email' => 'coordinacion.adjunta@example.com'],
        ])->each(function (array $coordinador) {
            User::updateOrCreate(
                ['email' => $coordinador['email']],
                [
                    'name' => $coordinador['name'],
                    'password' => Hash::make('coordinador123'),
                    'role' => User::ROLE_COORDINADOR,
                    'alumno_id' => null,
                    'tutor_id' => null,
                    'must_change_password' => false,
                ]
            );
        });

        Alumno::all()->each(function (Alumno $alumno) {
            User::updateOrCreate(
                ['email' => $alumno->email],
                [
                    'name' => $alumno->nombre,
                    'password' => Hash::make('alumno123'),
                    'role' => User::ROLE_ALUMNO,
                    'alumno_id' => $alumno->id,
                    'tutor_id' => null,
                    'must_change_password' => false,
                ]
            );
        });

        Tutor::all()->each(function (Tutor $tutor) {
            User::updateOrCreate(
                ['email' => $tutor->email],
                [
                    'name' => $tutor->nombre,
                    'password' => Hash::make('tutor123'),
                    'role' => User::ROLE_TUTOR,
                    'alumno_id' => null,
                    'tutor_id' => $tutor->id,
                    'must_change_password' => false,
                ]
            );
        });
    }
}

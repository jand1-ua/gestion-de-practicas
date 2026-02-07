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
        User::updateOrCreate(
            ['email' => 'coordinador@example.com'],
            [
                'name'      => 'Coordinador de Prácticas',
                'password'  => Hash::make('coordinador123'),
                'role'      => 'coordinador',
                'alumno_id' => null,
                'tutor_id'  => null,
            ]
        );

        Alumno::all()->each(function (Alumno $alumno) {
            User::updateOrCreate(
                ['email' => $alumno->email],
                [
                    'name'      => $alumno->nombre,
                    'password'  => Hash::make('alumno123'),
                    'role'      => 'alumno',
                    'alumno_id' => $alumno->id,
                    'tutor_id'  => null,
                ]
            );
        });

        Tutor::all()->each(function (Tutor $tutor) {
            User::updateOrCreate(
                ['email' => $tutor->email],
                [
                    'name'      => $tutor->nombre,
                    'password'  => Hash::make('tutor123'),
                    'role'      => 'tutor',
                    'alumno_id' => null,
                    'tutor_id'  => $tutor->id,
                ]
            );
        });
    }
}

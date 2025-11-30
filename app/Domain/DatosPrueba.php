<?php

namespace App\Domain;

use DateTime;

class DatosPrueba
{
    // Crea un conjunto coherente de alumnos, empresas, tutores y prácticas.

    public static function crear(): array
    {
        $empresa1 = new Empresa(1, 'Tech Solutions S.L.', 'B12345678', 'Alicante', 'Tecnología');
        $empresa2 = new Empresa(2, 'Consulting UA S.A.', 'A87654321', 'Elche', 'Consultoría');

        $tutor1 = new Tutor(1, 'María Pérez', 'maria@techsolutions.com', '600111222', $empresa1);
        $tutor2 = new Tutor(2, 'Javier Ruiz', 'jruiz@consultingua.com', '600333444', $empresa2);

        $alumno1 = new Alumno(1, 'Ana López', 'ana@example.com', 'ADE', 3);
        $alumno2 = new Alumno(2, 'Luis Martínez', 'luis@example.com', 'Informática', 4);

        $practica1 = new Practica(
            1,
            $alumno1,
            $empresa1,
            $tutor1,
            new DateTime('2025-02-01'),
            new DateTime('2025-05-31')
        );

        $practica2 = new Practica(
            2,
            $alumno2,
            $empresa2,
            $tutor2,
            new DateTime('2025-03-01'),
            new DateTime('2025-06-30')
        );

        return [
            'alumnos'   => [$alumno1, $alumno2],
            'empresas'  => [$empresa1, $empresa2],
            'tutores'   => [$tutor1, $tutor2],
            'practicas' => [$practica1, $practica2],
        ];
    }
}

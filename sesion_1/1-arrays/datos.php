<?php

// ----- ALUMNOS -----
$alumnos = [
    [
        'id'     => 1,
        'nombre' => 'Ana López',
        'email'  => 'ana@example.com',
        'grado'  => 'ADE',
        'curso'  => 3,
    ],
    [
        'id'     => 2,
        'nombre' => 'Luis Martínez',
        'email'  => 'luis@example.com',
        'grado'  => 'Informática',
        'curso'  => 4,
    ],
];

// ----- EMPRESAS -----
$empresas = [
    [
        'id'     => 1,
        'nombre' => 'Tech Solutions S.L.',
        'cif'    => 'B12345678',
        'ciudad' => 'Alicante',
        'sector' => 'Tecnología',
    ],
    [
        'id'     => 2,
        'nombre' => 'Consulting UA S.A.',
        'cif'    => 'A87654321',
        'ciudad' => 'Elche',
        'sector' => 'Consultoría',
    ],
];

// ----- TUTORES -----
$tutores = [
    [
        'id'         => 1,
        'nombre'     => 'María Pérez',
        'email'      => 'maria@techsolutions.com',
        'telefono'   => '600111222',
        'empresa_id' => 1,
    ],
    [
        'id'         => 2,
        'nombre'     => 'Javier Ruiz',
        'email'      => 'jruiz@consultingua.com',
        'telefono'   => '600333444',
        'empresa_id' => 2,
    ],
];

// ----- PRACTICAS -----
$practicas = [
    [
        'id'          => 1,
        'alumno_id'   => 1,
        'empresa_id'  => 1,
        'tutor_id'    => 1,
        'fecha_inicio'=> '2025-02-01',
        'fecha_fin'   => '2025-05-31',
    ],
    [
        'id'          => 2,
        'alumno_id'   => 2,
        'empresa_id'  => 2,
        'tutor_id'    => 2,
        'fecha_inicio'=> '2025-03-01',
        'fecha_fin'   => '2025-06-30',
    ],
];

/**
 * Devuelve las prácticas asociadas a un alumno.
 */
function obtenerPracticasDeAlumno(int $alumnoId, array $practicas): array
{
    $resultado = [];

    foreach ($practicas as $practica) {
        if ($practica['alumno_id'] === $alumnoId) {
            $resultado[] = $practica;
        }
    }

    return $resultado;
}

<?php

require __DIR__ . '/Domain/Alumno.php';
require __DIR__ . '/Domain/Empresa.php';
require __DIR__ . '/Domain/Tutor.php';
require __DIR__ . '/Domain/Practica.php';

use Practicas\Domain\Alumno;
use Practicas\Domain\Empresa;
use Practicas\Domain\Tutor;
use Practicas\Domain\Practica;

$empresa1 = new Empresa(1, 'Tech Solutions S.L.', 'B12345678', 'Alicante', 'Tecnología');
$tutor1   = new Tutor(1, 'María Pérez', 'maria@techsolutions.com', '600111222', $empresa1);
$alumno1  = new Alumno(1, 'Ana López', 'ana@example.com', 'ADE', 3);

$practica1 = new Practica(
    1,
    $alumno1,
    $empresa1,
    $tutor1,
    new DateTime('2025-02-01'),
    new DateTime('2025-05-31')
);

echo 'Alumno: ' . $practica1->getAlumno()->getNombre() . PHP_EOL;
echo 'Estado hoy: ' . $practica1->getEstado() . PHP_EOL;

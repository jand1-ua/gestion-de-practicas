<?php

require __DIR__ . '/model/Alumno.php';
require __DIR__ . '/model/Empresa.php';
require __DIR__ . '/model/Tutor.php';
require __DIR__ . '/model/Practica.php';

// Objetos de ejemplo
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
echo 'Empresa: ' . $practica1->getEmpresa()->getNombre() . PHP_EOL;
echo 'Tutor: ' . $practica1->getTutor()->getNombre() . PHP_EOL;
echo 'Duración: ' . $practica1->getDuracionEnDias() . ' días' . PHP_EOL;
echo 'Estado hoy: ' . $practica1->getEstado() . PHP_EOL;

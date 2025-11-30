<?php

echo "Entrando en demo_listados.php" . PHP_EOL;

require __DIR__ . '/datos.php';

echo "Alumnos cargados: " . count($alumnos) . PHP_EOL;
echo "Empresas cargadas: " . count($empresas) . PHP_EOL;
echo "Tutores cargados: " . count($tutores) . PHP_EOL;
echo "Prácticas cargadas: " . count($practicas) . PHP_EOL;

foreach ($alumnos as $alumno) {
    echo "Alumno: {$alumno['nombre']} ({$alumno['grado']} - curso {$alumno['curso']})" . PHP_EOL;

    $practicasAlumno = obtenerPracticasDeAlumno($alumno['id'], $practicas);
    echo '  Nº de prácticas: ' . count($practicasAlumno) . PHP_EOL;

    foreach ($practicasAlumno as $practica) {
        echo "    Práctica {$practica['id']} en empresa {$practica['empresa_id']}"
           . " desde {$practica['fecha_inicio']} hasta {$practica['fecha_fin']}" . PHP_EOL;
    }

    echo PHP_EOL;
}

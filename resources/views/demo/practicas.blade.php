<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prácticas (demo)</title>
</head>
<body>
    <h1>Prácticas (demo)</h1>

    <table border="1" cellpadding="4">
        <thead>
        <tr>
            <th>ID</th>
            <th>Alumno</th>
            <th>Empresa</th>
            <th>Tutor</th>
            <th>Duración (días)</th>
            <th>Estado hoy</th>
        </tr>
        </thead>
        <tbody>
        @foreach($practicas as $practica)
            <tr>
                <td>{{ $practica->getId() }}</td>
                <td>{{ $practica->getAlumno()->getNombre() }}</td>
                <td>{{ $practica->getEmpresa()->getNombre() }}</td>
                <td>{{ $practica->getTutor()->getNombre() }}</td>
                <td>{{ $practica->getDuracionEnDias() }}</td>
                <td>{{ $practica->getEstado() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

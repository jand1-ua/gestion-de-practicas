<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prácticas (acceso a datos)</title>
</head>
<body>
    <h1>Listado de prácticas (joins con Query Builder)</h1>

    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Alumno</th>
            <th>Empresa</th>
            <th>Tutor</th>
            <th>Estado</th>
            <th>Inicio</th>
            <th>Fin</th>
        </tr>
        </thead>
        <tbody>
        @foreach($practicas as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->alumno }}</td>
                <td>{{ $p->empresa }}</td>
                <td>{{ $p->tutor }}</td>
                <td>{{ $p->estado }}</td>
                <td>{{ $p->fecha_inicio }}</td>
                <td>{{ $p->fecha_fin }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ route('db.alumnos') }}">Ver alumnos (BD)</a> |
        <a href="{{ url('/') }}">Volver a la página de inicio</a>
    </p>
</body>
</html>

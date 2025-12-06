<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prácticas (Eloquent)</title>
</head>
<body>
    <h1>Prácticas (Eloquent ORM)</h1>
    <p>Ejemplo de joins resueltos mediante relaciones Eloquent.</p>

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
                <td>{{ $p->alumno?->nombre }}</td>
                <td>{{ $p->empresa?->nombre }}</td>
                <td>{{ $p->tutor?->nombre }}</td>
                <td>{{ $p->estado }}</td>
                <td>{{ $p->fecha_inicio }}</td>
                <td>{{ $p->fecha_fin }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ route('eloquent.alumnos') }}">Ver alumnos (Eloquent)</a> |
        <a href="{{ url('/') }}">Inicio</a>
    </p>
</body>
</html>

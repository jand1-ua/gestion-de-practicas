<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos (Eloquent ORM)</title>
</head>
<body>
    <h1>Alumnos (Eloquent ORM)</h1>
    <p>Ejemplo de uso de relaciones Alumno → Prácticas.</p>

    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Grado</th>
            <th>Curso</th>
            <th>Nº prácticas</th>
        </tr>
        </thead>
        <tbody>
        @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->id }}</td>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->grado ?? '-' }}</td>
                <td>{{ $alumno->curso ?? '-' }}</td>
                <td>{{ $alumno->practicas->count() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ route('eloquent.practicas') }}">Ver prácticas (Eloquent)</a> |
        <a href="{{ url('/') }}">Inicio</a>
    </p>
</body>
</html>

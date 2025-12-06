<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos (acceso a datos)</title>
</head>
<body>
    <h1>Listado de alumnos (consulta con Query Builder)</h1>

    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Grado</th>
            <th>Curso</th>
        </tr>
        </thead>
        <tbody>
        @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->id }}</td>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->grado }}</td>
                <td>{{ $alumno->curso }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ url('/') }}">Volver a la página de inicio</a> |
        <a href="{{ route('db.practicas') }}">Ver prácticas (BD)</a>
    </p>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos (demo)</title>
</head>
<body>
    <h1>Alumnos (demo)</h1>

    <table border="1" cellpadding="4">
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
                <td>{{ $alumno->getId() }}</td>
                <td>{{ $alumno->getNombre() }}</td>
                <td>{{ $alumno->getEmail() }}</td>
                <td>{{ $alumno->getGrado() }}</td>
                <td>{{ $alumno->getCurso() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de alumno</title>
</head>
<body>
<h1>Detalle de alumno</h1>

<p>
    <a href="{{ route('admin.alumnos.index') }}">Volver al listado</a>
</p>

<ul>
    <li><strong>ID:</strong> {{ $alumno->id }}</li>
    <li><strong>Nombre:</strong> {{ $alumno->nombre }}</li>
    <li><strong>Email:</strong> {{ $alumno->email }}</li>
    <li><strong>Grado:</strong> {{ $alumno->grado }}</li>
    <li><strong>Curso:</strong> {{ $alumno->curso }}</li>
</ul>

</body>
</html>

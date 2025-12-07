<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar alumno</title>
</head>
<body>
<h1>Editar alumno</h1>

<p>
    <a href="{{ route('admin.alumnos.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.alumnos.update', $alumno) }}" method="POST">
    @method('PUT')
    @include('admin.alumnos._form')
    <div style="margin-top: 12px;">
        <button type="submit">Actualizar</button>
    </div>
</form>
</body>
</html>

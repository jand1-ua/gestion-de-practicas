<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo alumno</title>
</head>
<body>
<h1>Nuevo alumno</h1>

<p>
    <a href="{{ route('admin.alumnos.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.alumnos.store') }}" method="POST">
    @include('admin.alumnos._form')
    <div style="margin-top: 12px;">
        <button type="submit">Guardar</button>
    </div>
</form>
</body>
</html>

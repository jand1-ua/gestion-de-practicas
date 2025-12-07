<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo tutor</title>
</head>
<body>
<h1>Nuevo tutor</h1>

<p>
    <a href="{{ route('admin.tutores.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.tutores.store') }}" method="POST">
    @include('admin.tutores._form')

    <div style="margin-top: 12px;">
        <button type="submit">Guardar</button>
    </div>
</form>

</body>
</html>

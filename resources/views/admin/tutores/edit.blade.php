<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar tutor</title>
</head>
<body>
<h1>Editar tutor</h1>

<p>
    <a href="{{ route('admin.tutores.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.tutores.update', $tutor) }}" method="POST">
    @method('PUT')
    @include('admin.tutores._form')

    <div style="margin-top: 12px;">
        <button type="submit">Actualizar</button>
    </div>
</form>

</body>
</html>

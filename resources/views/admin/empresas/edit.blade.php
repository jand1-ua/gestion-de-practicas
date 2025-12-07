<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar empresa</title>
</head>
<body>
<h1>Editar empresa</h1>

<p>
    <a href="{{ route('admin.empresas.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.empresas.update', $empresa) }}" method="POST">
    @method('PUT')
    @include('admin.empresas._form')
    <div style="margin-top: 12px;">
        <button type="submit">Actualizar</button>
    </div>
</form>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva empresa</title>
</head>
<body>
<h1>Nueva empresa</h1>

<p>
    <a href="{{ route('admin.empresas.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.empresas.store') }}" method="POST">
    @include('admin.empresas._form')

    <div style="margin-top: 12px;">
        <button type="submit">Guardar</button>
    </div>
</form>

</body>
</html>

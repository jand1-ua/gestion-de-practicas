<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de empresa</title>
</head>
<body>
<h1>Detalle de empresa</h1>

<p>
    <a href="{{ route('admin.empresas.index') }}">Volver al listado</a>
</p>

<ul>
    <li><strong>ID:</strong> {{ $empresa->id }}</li>
    <li><strong>Nombre:</strong> {{ $empresa->nombre }}</li>
    <li><strong>CIF:</strong> {{ $empresa->cif }}</li>
    <li><strong>Sector:</strong> {{ $empresa->sector }}</li>
    <li><strong>Ciudad:</strong> {{ $empresa->ciudad }}</li>
    <li><strong>Email de contacto:</strong> {{ $empresa->email_contacto }}</li>
    <li><strong>Teléfono de contacto:</strong> {{ $empresa->telefono_contacto }}</li>
</ul>

</body>
</html>

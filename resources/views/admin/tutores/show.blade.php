<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de tutor</title>
</head>
<body>
<h1>Detalle de tutor</h1>

<p>
    <a href="{{ route('admin.tutores.index') }}">Volver al listado</a>
</p>

<ul>
    <li><strong>ID:</strong> {{ $tutor->id }}</li>
    <li><strong>Nombre:</strong> {{ $tutor->nombre }}</li>
    <li><strong>Email:</strong> {{ $tutor->email }}</li>
    <li><strong>Teléfono:</strong> {{ $tutor->telefono }}</li>
    <li><strong>Empresa:</strong> {{ $tutor->empresa?->nombre }}</li>
</ul>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de práctica</title>
</head>
<body>
<h1>Práctica #{{ $practica->id }}</h1>

<p><a href="{{ route('admin.practicas.index') }}">Volver al listado</a></p>

<ul>
    <li><strong>Alumno:</strong> {{ $practica->alumno->nombre ?? '-' }}</li>
    <li><strong>Empresa:</strong> {{ $practica->empresa->nombre ?? '-' }}</li>
    <li><strong>Tutor:</strong> {{ $practica->tutor->nombre ?? '-' }}</li>
    <li><strong>Estado:</strong> {{ $practica->estado }}</li>
    <li><strong>Fecha inicio:</strong> {{ $practica->fecha_inicio }}</li>
    <li><strong>Fecha fin:</strong> {{ $practica->fecha_fin }}</li>
    <li><strong>Observaciones:</strong><br>
        {!! nl2br(e($practica->observaciones)) !!}
    </li>
</ul>

<p>
    <a href="{{ route('admin.practicas.edit', $practica) }}">Editar</a>
</p>
</body>
</html>

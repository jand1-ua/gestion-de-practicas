<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva práctica</title>
</head>
<body>
<h1>Crear nueva práctica</h1>

<p>
    <a href="{{ route('admin.practicas.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.practicas.store') }}" method="POST">
    @csrf

    {{-- En create no tenemos todavía $practica, se la pasamos como null --}}
    @include('admin.practicas._form', ['practica' => null])
</form>

</body>
</html>

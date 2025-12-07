<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar práctica</title>
</head>
<body>
<h1>Editar práctica #{{ $practica->id }}</h1>

<p>
    <a href="{{ route('admin.practicas.index') }}">Volver al listado</a>
</p>

<form action="{{ route('admin.practicas.update', $practica) }}" method="POST">
    @csrf
    @method('PUT')

    @include('admin.practicas._form', ['practica' => $practica])
</form>

</body>
</html>

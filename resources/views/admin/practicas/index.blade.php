<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de prácticas</title>
</head>
<body>
<h1>Gestión de prácticas</h1>

<p>
    <a href="{{ url('/') }}">Inicio</a> |
    <a href="{{ route('admin.alumnos.index') }}">Gestión de alumnos</a> |
    <a href="{{ route('admin.empresas.index') }}">Gestión de empresas</a> |
    <a href="{{ route('admin.tutores.index') }}">Gestión de tutores</a> |
    <a href="{{ route('admin.practicas.create') }}">Nueva práctica</a>
</p>

@if (session('success'))
    <p style="color: darkgreen;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: darkred;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="4" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Alumno</th>
        <th>Empresa</th>
        <th>Tutor</th>
        <th>Estado</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Observaciones</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($practicas as $practica)
        <tr>
            <td>{{ $practica->id }}</td>
            <td>{{ $practica->alumno->nombre ?? '-' }}</td>
            <td>{{ $practica->empresa->nombre ?? '-' }}</td>
            <td>{{ $practica->tutor->nombre ?? '-' }}</td>
            <td>{{ $practica->estado }}</td>
            <td>{{ $practica->fecha_inicio }}</td>
            <td>{{ $practica->fecha_fin }}</td>
            <td>{{ $practica->observaciones }}</td>
            <td>
                <a href="{{ route('admin.practicas.show', $practica) }}">Ver</a> |
                <a href="{{ route('admin.practicas.edit', $practica) }}">Editar</a> |
                <form action="{{ route('admin.practicas.destroy', $practica) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('¿Eliminar práctica?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9">No hay prácticas registradas.</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de alumnos</title>
</head>
<body>
<h1>Gestión de alumnos</h1>

<p>
    <a href="{{ url('/') }}">Inicio</a> |
    <a href="{{ route('admin.alumnos.create') }}">Nuevo alumno</a>
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
        <th>Nombre</th>
        <th>Email</th>
        <th>Grado</th>
        <th>Curso</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse($alumnos as $alumno)
        <tr>
            <td>{{ $alumno->id }}</td>
            <td>
                <a href="{{ route('admin.alumnos.show', $alumno) }}">
                    {{ $alumno->nombre }}
                </a>
            </td>
            <td>{{ $alumno->email }}</td>
            <td>{{ $alumno->grado }}</td>
            <td>{{ $alumno->curso }}</td>
            <td>
                <a href="{{ route('admin.alumnos.edit', $alumno) }}">Editar</a>
                |
                <form action="{{ route('admin.alumnos.destroy', $alumno) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('¿Seguro que quieres eliminar este alumno?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Borrar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No hay alumnos registrados.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div style="margin-top: 10px;">
    {{ $alumnos->links() }}
</div>
</body>
</html>

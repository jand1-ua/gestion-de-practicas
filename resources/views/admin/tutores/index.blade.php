<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de tutores</title>
</head>
<body>
<h1>Gestión de tutores</h1>

<p>
    <a href="{{ url('/') }}">Inicio</a> |
    <a href="{{ route('admin.alumnos.index') }}">Gestión de alumnos</a> |
    <a href="{{ route('admin.empresas.index') }}">Gestión de empresas</a> |
    <a href="{{ route('admin.tutores.create') }}">Nuevo tutor</a>
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
        <th>Teléfono</th>
        <th>Empresa</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($tutores as $tutor)
        <tr>
            <td>{{ $tutor->id }}</td>
            <td>
                <a href="{{ route('admin.tutores.show', $tutor) }}">
                    {{ $tutor->nombre }}
                </a>
            </td>
            <td>{{ $tutor->email }}</td>
            <td>{{ $tutor->telefono }}</td>
            <td>{{ $tutor->empresa?->nombre }}</td>
            <td>
                <a href="{{ route('admin.tutores.edit', $tutor) }}">Editar</a>
                |
                <form action="{{ route('admin.tutores.destroy', $tutor) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('¿Eliminar tutor?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Borrar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No hay tutores registrados.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div style="margin-top: 10px;">
    {{ $tutores->links() }}
</div>

</body>
</html>

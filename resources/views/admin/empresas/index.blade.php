<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de empresas</title>
</head>
<body>
<h1>Gestión de empresas</h1>

<p>
    <a href="{{ url('/') }}">Inicio</a> |
    <a href="{{ route('admin.alumnos.index') }}">Gestión de alumnos</a> |
    <a href="{{ route('admin.tutores.index') }}">Gestión de tutores</a> |
    <a href="{{ route('admin.empresas.create') }}">Nueva empresa</a>
</p>

@if (session('success'))
    <p style="color:darkgreen;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color:darkred;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="4" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>CIF</th>
        <th>Sector</th>
        <th>Ciudad</th>
        <th>Email contacto</th>
        <th>Teléfono contacto</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse($empresas as $empresa)
        <tr>
            <td>{{ $empresa->id }}</td>
            <td>
                <a href="{{ route('admin.empresas.show', $empresa) }}">
                    {{ $empresa->nombre }}
                </a>
            </td>
            <td>{{ $empresa->cif }}</td>
            <td>{{ $empresa->sector }}</td>
            <td>{{ $empresa->ciudad }}</td>
            <td>{{ $empresa->email_contacto }}</td>
            <td>{{ $empresa->telefono_contacto }}</td>
            <td>
                <a href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a> |
                <form action="{{ route('admin.empresas.destroy', $empresa) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('¿Eliminar empresa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Borrar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">No hay empresas registradas.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div style="margin-top:10px;">
    {{ $empresas->links() }}
</div>

</body>
</html>

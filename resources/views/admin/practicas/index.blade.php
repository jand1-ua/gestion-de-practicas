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

{{-- Filtros de búsqueda --}}
<form method="GET" action="{{ route('admin.practicas.index') }}" style="margin-bottom: 1rem; padding: .5rem; border: 1px solid #ccc;">
    <strong>Filtros</strong><br><br>

    {{-- Estado --}}
    <label for="estado">Estado:</label>
    <select name="estado" id="estado">
        <option value="">-- Todos --</option>
        <option value="en_curso"  {{ request('estado') === 'en_curso' ? 'selected' : '' }}>En curso</option>
        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="finalizada" {{ request('estado') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
    </select>

    &nbsp;&nbsp;

    {{-- Empresa --}}
    <label for="empresa_id">Empresa:</label>
    <select name="empresa_id" id="empresa_id">
        <option value="">-- Todas --</option>
        @foreach ($empresas as $empresa)
            <option value="{{ $empresa->id }}"
                {{ (string)request('empresa_id') === (string)$empresa->id ? 'selected' : '' }}>
                {{ $empresa->nombre }}
            </option>
        @endforeach
    </select>

    &nbsp;&nbsp;

    {{-- Alumno --}}
    <label for="alumno_id">Alumno:</label>
    <select name="alumno_id" id="alumno_id">
        <option value="">-- Todos --</option>
        @foreach ($alumnos as $alumno)
            <option value="{{ $alumno->id }}"
                {{ (string)request('alumno_id') === (string)$alumno->id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @endforeach
    </select>

    &nbsp;&nbsp;

    {{-- Tutor --}}
    <label for="tutor_id">Tutor:</label>
    <select name="tutor_id" id="tutor_id">
        <option value="">-- Todos --</option>
        @foreach ($tutores as $tutor)
            <option value="{{ $tutor->id }}"
                {{ (string)request('tutor_id') === (string)$tutor->id ? 'selected' : '' }}>
                {{ $tutor->nombre }} ({{ $tutor->empresa->nombre ?? '-' }})
            </option>
        @endforeach
    </select>

    &nbsp;&nbsp;

    <button type="submit">Filtrar</button>
    <a href="{{ route('admin.practicas.index') }}">Limpiar filtros</a>
</form>

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

{{-- Paginación --}}
@if ($practicas instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 1rem;">
        {{ $practicas->links() }}
    </div>
@endif

</body>
</html>

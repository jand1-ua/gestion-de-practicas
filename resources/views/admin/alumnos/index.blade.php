@extends('layouts.app')

@section('title', 'Alumnos · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Alumnos</h2>
        <p>Gestión de alumnos registrados en el sistema.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.alumnos.create') }}">Nuevo alumno</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.alumnos.index') }}" class="search-toolbar">
        <div class="field search-toolbar__field">
            <label class="label" for="q">Buscar</label>
            <input class="control" id="q" name="q" type="search" value="{{ $search ?? request('q') }}" data-autofocus
                   placeholder="Nombre, email, grado o curso">
            <div class="help">La búsqueda consulta toda la base de datos y se mantiene al paginar.</div>
        </div>

        <div class="actions search-toolbar__actions">
            <button class="btn btn-primary" type="submit">Buscar</button>
            <a class="btn" href="{{ route('admin.alumnos.index') }}">Limpiar</a>
        </div>

        <div class="muted search-toolbar__meta">{{ $alumnos->total() }} registro(s)</div>
    </form>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                    <th>Acceso portal</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                    <tr>
                        <td>
                            <a href="{{ route('admin.alumnos.show', $alumno) }}"><strong>{{ $alumno->nombre }}</strong></a>
                        </td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
                        <td>
                            @if($alumno->user)
                                <span class="status-pill is-active">Activo</span>
                            @else
                                <span class="status-pill">No generado</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.alumnos.edit', $alumno) }}">Editar</a>
                                <form action="{{ route('admin.alumnos.destroy', $alumno) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este alumno?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">No se han encontrado alumnos con los criterios indicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $alumnos->links() }}
</div>
@endsection

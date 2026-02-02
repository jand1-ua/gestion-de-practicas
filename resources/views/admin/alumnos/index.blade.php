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
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="alumnos-search">Buscar</label>
            <input class="control" id="alumnos-search" type="search" data-autofocus data-table-filter="alumnos-table"
                   placeholder="Nombre, email, grado...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $alumnos->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="alumnos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->id }}</td>
                        <td>
                            <a href="{{ route('admin.alumnos.show', $alumno) }}"><strong>{{ $alumno->nombre }}</strong></a>
                        </td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
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
                        <td colspan="6" class="muted">No hay alumnos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $alumnos->links() }}
</div>
@endsection

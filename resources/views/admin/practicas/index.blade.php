@extends('layouts.app')

@section('title', 'Prácticas · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

@php
    $estadoActual = request('estado');
    $empresaActual = request('empresa_id');
    $alumnoActual = request('alumno_id');
    $tutorActual = request('tutor_id');
@endphp

<div class="pagehead">
    <div>
        <h2>Prácticas</h2>
        <p>Listado y filtros de asignaciones de prácticas.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.practicas.create') }}">Nueva práctica</a>
    </div>
</div>

<div class="card">
    <h3>Filtros</h3>
    <p class="muted">Los filtros consultan la base de datos. Puedes además usar la búsqueda local para filtrar la tabla actual.</p>

    <form method="GET" action="{{ route('admin.practicas.index') }}" class="form" style="margin-top:12px;">
        <div class="field-row">
            <div class="field">
                <label class="label" for="estado">Estado</label>
                <select class="select" name="estado" id="estado">
                    @foreach($estados as $value => $label)
                        <option value="{{ $value }}" @selected((string) $estadoActual === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label" for="empresa_id">Empresa</label>
                <select class="select" name="empresa_id" id="empresa_id">
                    <option value="">Todas</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" @selected((string) $empresaActual === (string) $empresa->id)>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label class="label" for="alumno_id">Alumno</label>
                <select class="select" name="alumno_id" id="alumno_id">
                    <option value="">Todos</option>
                    @foreach ($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" @selected((string) $alumnoActual === (string) $alumno->id)>
                            {{ $alumno->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label" for="tutor_id">Tutor</label>
                <select class="select" name="tutor_id" id="tutor_id">
                    <option value="">Todos</option>
                    @foreach ($tutores as $tutor)
                        <option value="{{ $tutor->id }}" @selected((string) $tutorActual === (string) $tutor->id)>
                            {{ $tutor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Aplicar filtros</button>
            <a class="btn" href="{{ route('admin.practicas.index') }}">Limpiar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="practicas-search">Buscar en esta página</label>
            <input class="control" id="practicas-search" type="search" data-table-filter="practicas-table"
                   placeholder="Alumno, empresa, tutor, observaciones...">
            <div class="help">Filtro local (no afecta a los enlaces de paginación).</div>
        </div>
        <div class="muted">{{ $practicas->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="practicas-table">
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
                <th style="width:240px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($practicas as $practica)
                @php
                    $estado = $practica->estado;
                    $estadoLabel = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                    $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                @endphp
                <tr>
                    <td class="muted">#{{ $practica->id }}</td>
                    <td>{{ $practica->alumno->nombre ?? '-' }}</td>
                    <td>{{ $practica->empresa->nombre ?? '-' }}</td>
                    <td>{{ $practica->tutor->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $badge }}">{{ $estadoLabel }}</span></td>
                    <td class="muted">{{ $practica->fecha_inicio }}</td>
                    <td class="muted">{{ $practica->fecha_fin ?? '—' }}</td>
                    <td style="max-width: 360px;">{{ $practica->observaciones }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-sm" href="{{ route('admin.practicas.show', $practica) }}">Ver</a>
                            <a class="btn btn-sm" href="{{ route('admin.practicas.edit', $practica) }}">Editar</a>
                            <form action="{{ route('admin.practicas.destroy', $practica) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar práctica?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="muted">No hay prácticas registradas con los filtros seleccionados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $practicas->links() }}
</div>
@endsection

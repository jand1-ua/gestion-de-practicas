@extends('layouts.app')

@section('title', 'Prácticas · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

@php
    $estadoActual = request('estado');
    $empresaActual = request('empresa_id');
    $alumnoActual = request('alumno_id');
    $tutorActual = request('tutor_id');
    $search = request('q');
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
    <p class="muted">Los filtros y la búsqueda consultan la base de datos y se mantienen al paginar.</p>

    <form method="GET" action="{{ route('admin.practicas.index') }}" class="form" style="margin-top:12px;">
        <div class="field">
            <label class="label" for="q">Búsqueda general</label>
            <input class="control" id="q" name="q" type="search" value="{{ $search }}"
                   placeholder="Alumno, empresa, tutor, estado u observaciones">
        </div>

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
    <div class="search-toolbar__meta muted">{{ $practicas->total() }} registro(s)</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
            <tr>
                <th>Alumno</th>
                <th>Empresa</th>
                <th>Tutor</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Observaciones</th>
                <th style="width:180px;">Acciones</th>
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
                    <td>{{ $practica->alumno->nombre ?? '-' }}</td>
                    <td>{{ $practica->empresa->nombre ?? '-' }}</td>
                    <td>{{ $practica->tutor->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $badge }}">{{ $estadoLabel }}</span></td>
                    <td class="muted">{{ optional($practica->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="muted">{{ optional($practica->fecha_fin)->format('d/m/Y') ?: '—' }}</td>
                    <td style="max-width: 360px;">{{ $practica->observaciones ?: '—' }}</td>
                    <td>
                        <div class="actions">
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
                    <td colspan="8" class="muted">No hay prácticas registradas con los filtros seleccionados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $practicas->links() }}
</div>
@endsection

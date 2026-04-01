@extends('layouts.app')

@section('title', 'Detalle de práctica · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

@php
    $estado = $practica->estado;
    $estadoLabel = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
    $badgeClass = $estado === 'finalizada'
        ? 'badge-ok'
        : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
@endphp

<div class="pagehead">
    <div>
        <h2>Detalle de la práctica</h2>
        <p>Información de la asignación y del periodo de prácticas.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.practicas.edit', $practica) }}">Editar</a>
        <a class="btn" href="{{ route('admin.practicas.index') }}">Volver</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Asignación</h3>

        <div class="kv">
            <div class="k">Alumno</div>
            <div class="v">{{ $practica->alumno->nombre ?? '-' }}</div>

            <div class="k">Empresa</div>
            <div class="v">{{ $practica->empresa->nombre ?? '-' }}</div>

            <div class="k">Tutor</div>
            <div class="v">{{ $practica->tutor->nombre ?? '-' }}</div>

            <div class="k">Estado</div>
            <div class="v"><span class="badge {{ $badgeClass }}">{{ $estadoLabel }}</span></div>
        </div>
    </div>

    <div class="card">
        <h3>Fechas y observaciones</h3>

        <div class="kv">
            <div class="k">Fecha inicio</div>
            <div class="v">{{ optional($practica->fecha_inicio)->format('d/m/Y') }}</div>

            <div class="k">Fecha fin</div>
            <div class="v">{{ optional($practica->fecha_fin)->format('d/m/Y') ?: '—' }}</div>

            <div class="k">Observaciones</div>
            <div class="v practica-detail-text">{{ $practica->observaciones ?: '—' }}</div>
        </div>

        <hr class="hr">

        <div class="actions">
            <a class="btn" href="{{ route('admin.practicas.index', ['alumno_id' => $practica->alumno_id]) }}">Más prácticas del alumno</a>
            <a class="btn" href="{{ route('admin.practicas.index', ['empresa_id' => $practica->empresa_id]) }}">Más prácticas de la empresa</a>
        </div>
    </div>
</div>
@endsection

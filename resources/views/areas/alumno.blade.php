@extends('layouts.app')

@section('title', 'Área del alumno · Gestión de Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Área del alumno</h2>
        <p>Resumen de tus datos y prácticas asignadas.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Mi perfil</h3>
        <p style="margin-top:10px;"><strong>{{ $user->profileName() }}</strong></p>
        <p class="muted" style="margin:6px 0 0;">{{ $user->email }}</p>
        <p style="margin:10px 0 0;"><span class="badge badge-ok">alumno</span></p>
    </div>

    <div class="card">
        <h3>Acciones rápidas</h3>
        <p class="muted">Atajos para lo más habitual.</p>
        <div class="actions" style="margin-top:12px;">
            <a class="btn btn-primary" href="{{ route('mensajes.create') }}">Nuevo mensaje</a>
            <a class="btn" href="{{ route('home') }}">Inicio</a>
        </div>
    </div>
</div>

<div style="margin-top:16px;"></div>

@if ($alumno)
    <div class="card">
        <h3>Mis prácticas</h3>
        <p class="muted">Listado de prácticas asociadas a tu perfil.</p>

        @if ($alumno->practicas->isEmpty())
            <div class="alert" style="margin-top:12px;">No tienes prácticas registradas.</div>
        @else
            <div class="table-wrap" style="margin-top:12px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Tutor</th>
                            <th>Estado</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumno->practicas as $practica)
                            <tr>
                                <td>#{{ $practica->id }}</td>
                                <td>{{ $practica->empresa?->nombre ?? '-' }}</td>
                                <td>{{ $practica->tutor?->nombre ?? '-' }}</td>
                                <td>
                                    @php
                                        $estado = $practica->estado;
                                        $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                                        $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $label }}</span>
                                </td>
                                <td>{{ $practica->fecha_inicio }}</td>
                                <td>{{ $practica->fecha_fin ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@else
    <div class="alert alert-danger">No hay alumno asociado a este usuario.</div>
@endif
@endsection

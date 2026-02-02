@extends('layouts.app')

@section('title', 'Área del tutor · Gestión de Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Área del tutor</h2>
        <p>Prácticas que supervisas y accesos rápidos.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Mi perfil</h3>
        <p style="margin-top:10px;"><strong>{{ $user->name }}</strong></p>
        <p class="muted" style="margin:6px 0 0;">{{ $user->email }}</p>
        <p style="margin:10px 0 0;"><span class="badge badge-ok">tutor</span></p>
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

@if ($tutor)
    <div class="card">
        <h3>Prácticas que superviso</h3>
        <p class="muted">Listado de prácticas asignadas a tu tutoría.</p>

        @if ($tutor->practicas->isEmpty())
            <div class="alert" style="margin-top:12px;">No tienes prácticas asignadas.</div>
        @else
            <div class="table-wrap" style="margin-top:12px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Alumno</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tutor->practicas as $practica)
                            <tr>
                                <td>#{{ $practica->id }}</td>
                                <td>{{ $practica->alumno?->nombre ?? '-' }}</td>
                                <td>{{ $practica->empresa?->nombre ?? '-' }}</td>
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
    <div class="alert alert-danger">No hay tutor asociado a este usuario.</div>
@endif
@endsection

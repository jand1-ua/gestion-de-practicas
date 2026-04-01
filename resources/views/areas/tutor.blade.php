@extends('layouts.app')

@section('title', 'Área del tutor · Gestión de Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Área del tutor</h2>
        <p>Resumen de alumnos, empresa y prácticas que supervisas.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
    </div>
</div>

@if ($tutor)
    @php
        $practicas = $tutor->practicas;
        $alumnosUnicos = $practicas
            ->filter(fn ($practica) => $practica->alumno)
            ->unique('alumno_id')
            ->values();
        $enCurso = $practicas->where('estado', 'en_curso')->count();
        $pendientes = $practicas->where('estado', 'pendiente')->count();
        $finalizadas = $practicas->where('estado', 'finalizada')->count();
    @endphp

    <div class="grid-3">
        <div class="card">
            <h3>Mi perfil</h3>
            <p style="margin-top:10px;"><strong>{{ $user->profileName() }}</strong></p>
            <p class="muted" style="margin:6px 0 0;">{{ $user->email }}</p>
            <p class="muted" style="margin:6px 0 0;">Empresa: {{ $tutor->empresa?->nombre ?? 'Sin empresa asignada' }}</p>
            <p style="margin:10px 0 0;"><span class="badge badge-ok">Tutor</span></p>
        </div>

        <div class="card stat-card">
            <h3>Prácticas activas</h3>
            <div class="stat-number">{{ $enCurso }}</div>
            <p class="muted">Prácticas en curso actualmente.</p>
        </div>

        <div class="card stat-card">
            <h3>Alumnos supervisados</h3>
            <div class="stat-number">{{ $alumnosUnicos->count() }}</div>
            <p class="muted">Alumnos distintos vinculados a tu tutoría.</p>
        </div>
    </div>

    <div style="margin-top:16px;"></div>

    <div class="grid-3">
        <div class="card stat-card">
            <h3>Pendientes</h3>
            <div class="stat-number">{{ $pendientes }}</div>
            <p class="muted">Prácticas pendientes de inicio o revisión.</p>
        </div>

        <div class="card stat-card">
            <h3>Finalizadas</h3>
            <div class="stat-number">{{ $finalizadas }}</div>
            <p class="muted">Prácticas cerradas en el histórico.</p>
        </div>

        <div class="card">
            <h3>Acciones rápidas</h3>
            <p class="muted">Atajos para el trabajo diario.</p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn btn-primary" href="{{ route('mensajes.create') }}">Nuevo mensaje</a>
                <a class="btn" href="{{ route('home') }}">Inicio</a>
            </div>
        </div>
    </div>

    <div style="margin-top:16px;"></div>

    <div class="card">
        <h3>Alumnos que superviso</h3>
        <p class="muted">Vista resumida por alumno, con fechas y estado más reciente.</p>

        @if ($alumnosUnicos->isEmpty())
            <div class="alert" style="margin-top:12px;">Todavía no tienes alumnos asignados.</div>
        @else
            <div class="table-wrap" style="margin-top:12px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnosUnicos as $practica)
                            @php
                                $estado = $practica->estado;
                                $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                                $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                            @endphp
                            <tr>
                                <td>{{ $practica->alumno?->nombre ?? '-' }}</td>
                                <td>{{ $practica->empresa?->nombre ?? '-' }}</td>
                                <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                                <td>{{ optional($practica->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ optional($practica->fecha_fin)->format('d/m/Y') ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div style="margin-top:16px;"></div>

    <div class="card">
        <h3>Prácticas que superviso</h3>
        <p class="muted">Listado completo de prácticas asignadas a tu tutoría.</p>

        @if ($practicas->isEmpty())
            <div class="alert" style="margin-top:12px;">No tienes prácticas asignadas.</div>
        @else
            <div class="table-wrap" style="margin-top:12px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($practicas as $practica)
                            @php
                                $estado = $practica->estado;
                                $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                                $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                            @endphp
                            <tr>
                                <td>{{ $practica->alumno?->nombre ?? '-' }}</td>
                                <td>{{ $practica->empresa?->nombre ?? '-' }}</td>
                                <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                                <td>{{ optional($practica->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ optional($practica->fecha_fin)->format('d/m/Y') ?: '—' }}</td>
                                <td>{{ $practica->observaciones ?: '—' }}</td>
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

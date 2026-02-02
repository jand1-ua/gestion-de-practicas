@extends('layouts.app')

@section('title', 'Inicio · Gestión de Prácticas')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="pagehead">
    <div>
        <span class="kicker"><span class="dot"></span> Sistema activo · <span class="nowrap">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span></span>
        <h2 style="margin:12px 0 6px; font-size:28px; line-height:1.12; letter-spacing:-0.4px;">Bienvenido a la plataforma de Gestión de Prácticas</h2>
        <p>
            Centraliza el ciclo completo de prácticas: alta de alumnos, empresas y tutores, asignación de prácticas,
            seguimiento y mensajería interna.
        </p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('sesiones') }}">Ir a sesiones / ejemplos</a>

        @if ($user)
            @if ($user->role === 'coordinador')
                <a class="btn" href="{{ route('admin.practicas.index') }}">Gestionar prácticas</a>
            @elseif ($user->role === 'alumno')
                <a class="btn" href="{{ route('area.alumno') }}">Ver mi área</a>
            @elseif ($user->role === 'tutor')
                <a class="btn" href="{{ route('area.tutor') }}">Ver mi área</a>
            @endif
        @else
            <a class="btn" href="{{ route('login') }}">Acceder</a>
        @endif
    </div>
</div>

<div class="grid-2">
    <div class="stack">
        <div class="card">
            <h3>Qué puedes hacer</h3>
            <p>Funciones principales según tu rol.</p>

            <div class="grid-3" style="margin-top:12px;">
                <div class="card" style="background: rgba(255,255,255,.06);">
                    <h3>Gestión unificada</h3>
                    <p>Alumnos, empresas, tutores y prácticas en un flujo consistente.</p>
                </div>
                <div class="card" style="background: rgba(255,255,255,.06);">
                    <h3>Seguimiento por rol</h3>
                    <p>Accesos y acciones adaptados a coordinador, alumno y tutor.</p>
                </div>
                <div class="card" style="background: rgba(255,255,255,.06);">
                    <h3>Mensajería interna</h3>
                    <p>Comunicación directa dentro de la plataforma, con bandeja y respuestas.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h3>Atajos recomendados</h3>
            <p>Entra rápido a los módulos más usados.</p>

            <div class="actions" style="margin-top:12px;">
                @if ($user)
                    <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
                    @if ($user->role === 'coordinador')
                        <a class="btn" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
                        <a class="btn" href="{{ route('admin.empresas.index') }}">Empresas</a>
                        <a class="btn" href="{{ route('admin.tutores.index') }}">Tutores</a>
                        <a class="btn" href="{{ route('admin.practicas.index') }}">Prácticas</a>
                    @endif
                @else
                    <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
                @endif
            </div>
        </div>
    </div>

    <aside class="card">
        <h3>Estado de la cuenta</h3>

        @if ($user)
            <p style="margin: 10px 0 0;">
                <strong>{{ $user->name }}</strong>
                <span class="muted">· {{ $user->email }}</span>
            </p>
            <p style="margin: 8px 0 0;" class="muted">Rol: <span class="badge badge-ok">{{ $user->role }}</span></p>

            <hr class="hr">

            <div class="stack" style="gap:10px;">
                @if ($user->role === 'coordinador')
                    <a class="btn" href="{{ route('admin.dashboard') }}">Ir al panel</a>
                @elseif ($user->role === 'alumno')
                    <a class="btn" href="{{ route('area.alumno') }}">Ir a mi área</a>
                @elseif ($user->role === 'tutor')
                    <a class="btn" href="{{ route('area.tutor') }}">Ir a mi área</a>
                @endif

                <a class="btn" href="{{ route('sesiones') }}">Ver índice de sesiones</a>
            </div>
        @else
            <p class="muted" style="margin-top:10px;">
                No has iniciado sesión. Accede para ver tu panel y funciones según rol.
            </p>

            <hr class="hr">

            <div class="stack" style="gap:10px;">
                <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
                <a class="btn" href="{{ route('sesiones') }}">Ver sesiones / ejemplos</a>
            </div>
        @endif
    </aside>
</div>
@endsection

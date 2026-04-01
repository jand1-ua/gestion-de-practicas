@extends('layouts.app')

@section('title', 'Inicio · Gestión de Prácticas')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="pagehead">
    <div>
        <span class="kicker"><span class="dot"></span> Plataforma operativa</span>
        <h2 style="margin:12px 0 6px; font-size:28px; line-height:1.12; letter-spacing:-0.4px;">Gestión integral de prácticas externas</h2>
        <p>
            La aplicación centraliza la gestión de alumnos, empresas, tutores, asignaciones de prácticas
            y comunicación interna en un único entorno de trabajo.
        </p>
    </div>

    <div class="actions">
        @if ($user)
            @if ($user->isCoordinator())
                <a class="btn btn-primary" href="{{ route('admin.practicas.index') }}">Acceder al panel</a>
            @elseif ($user->isAlumno())
                <a class="btn btn-primary" href="{{ route('area.alumno') }}">Ir a mi área</a>
            @elseif ($user->isTutor())
                <a class="btn btn-primary" href="{{ route('area.tutor') }}">Ir a mi área</a>
            @endif
            <a class="btn" href="{{ route('mensajes.index') }}">Abrir mensajería</a>
        @else
            <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
        @endif
    </div>
</div>

<div class="grid-2">
    <div class="stack">
        <div class="card">
            <h3>Módulos principales</h3>
            <p>Acceso unificado a la operativa diaria de la plataforma.</p>

            <div class="grid-3" style="margin-top:12px;">
                <div class="card feature-card">
                    <h3>Gestión académica</h3>
                    <p>Altas, edición y seguimiento de alumnos, tutores y empresas colaboradoras.</p>
                </div>
                <div class="card feature-card">
                    <h3>Asignación de prácticas</h3>
                    <p>Registro del estado de cada práctica, fechas y responsables asociados.</p>
                </div>
                <div class="card feature-card">
                    <h3>Mensajería interna</h3>
                    <p>Comunicación directa entre coordinación, alumnado y tutores desde la propia aplicación.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h3>Accesos rápidos</h3>
            <p>Entradas directas a las secciones más usadas según el rol activo.</p>

            <div class="actions" style="margin-top:12px;">
                @if ($user)
                    <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
                    @if ($user->isCoordinator())
                        <a class="btn" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
                        <a class="btn" href="{{ route('admin.empresas.index') }}">Empresas</a>
                        <a class="btn" href="{{ route('admin.tutores.index') }}">Tutores</a>
                        <a class="btn" href="{{ route('admin.practicas.index') }}">Prácticas</a>
                    @elseif ($user->isAlumno())
                        <a class="btn" href="{{ route('area.alumno') }}">Mi área</a>
                    @elseif ($user->isTutor())
                        <a class="btn" href="{{ route('area.tutor') }}">Mi área</a>
                    @endif
                @else
                    <a class="btn" href="{{ route('login') }}">Acceder</a>
                @endif
            </div>
        </div>
    </div>

    <aside class="card">
        <h3>Estado de la cuenta</h3>

        @if ($user)
            <p style="margin: 10px 0 0;">
                <strong>{{ $user->profileName() }}</strong>
                <span class="muted">· {{ $user->email }}</span>
            </p>
            <p style="margin: 8px 0 0;" class="muted">Rol activo: <span class="badge badge-ok">{{ $user->roleLabel() }}</span></p>

            <hr class="hr">

            <div class="stack" style="gap:10px;">
                @if ($user->isCoordinator())
                    <a class="btn" href="{{ route('admin.dashboard') }}">Abrir panel de coordinación</a>
                @elseif ($user->isAlumno())
                    <a class="btn" href="{{ route('area.alumno') }}">Abrir mi área</a>
                @elseif ($user->isTutor())
                    <a class="btn" href="{{ route('area.tutor') }}">Abrir mi área</a>
                @endif
                <a class="btn" href="{{ route('mensajes.index') }}">Ir a mensajería</a>
            </div>
        @else
            <p class="muted" style="margin-top:10px;">
                Inicia sesión para acceder a las funciones correspondientes a tu rol dentro de la plataforma.
            </p>

            <hr class="hr">

            <div class="stack" style="gap:10px;">
                <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        @endif
    </aside>
</div>
@endsection

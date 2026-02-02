@extends('layouts.app')

@section('title', 'Sesiones · Gestión de Prácticas')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="pagehead">
    <div>
        <h2>Sesiones</h2>
        <p>Índice del proyecto (hasta Sesión 11: mensajería interna).</p>
        @if (Auth::check())
            <p class="muted" style="margin:6px 0 0;">
                Sesión iniciada como <strong>{{ Auth::user()->name }}</strong>
                <span class="muted">(rol: {{ Auth::user()->role }})</span>.
            </p>
        @endif
    </div>

    <div class="actions">
        @if (Auth::check())
            @if (Auth::user()->role === 'coordinador')
                <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Panel coordinador</a>
            @elseif (Auth::user()->role === 'alumno')
                <a class="btn btn-primary" href="{{ route('area.alumno') }}">Mi área</a>
            @elseif (Auth::user()->role === 'tutor')
                <a class="btn btn-primary" href="{{ route('area.tutor') }}">Mi área</a>
            @endif
        @endif
    </div>
</div>

<div class="grid-2">
    <div class="stack">
        <div class="card">
            <h3>Sesión 2 – Laravel básico (datos en memoria)</h3>
            <p>
                Vistas de demo con datos en memoria para introducir rutas y controladores.
            </p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn" href="{{ route('demo.alumnos') }}">Demo: alumnos</a>
                <a class="btn" href="{{ route('demo.practicas') }}">Demo: prácticas</a>
            </div>
        </div>

        <div class="card">
            <h3>Sesión 3 – Acceso a datos (Query Builder)</h3>
            <p>Consultas SQL con Query Builder, joins y paginación.</p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn" href="{{ route('db.alumnos') }}">Alumnos desde BD</a>
                <a class="btn" href="{{ route('db.practicas') }}">Prácticas (joins)</a>
            </div>
        </div>

        <div class="card">
            <h3>Sesión 4 – Eloquent ORM</h3>
            <p>Modelos, relaciones y carga de datos con Eloquent.</p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn" href="{{ route('eloquent.alumnos') }}">Alumnos (Eloquent)</a>
                <a class="btn" href="{{ route('eloquent.practicas') }}">Prácticas (Eloquent)</a>
            </div>
        </div>
    </div>

    <aside class="stack">
        <div class="card">
            <h3>Sesiones 5–7 – CRUD coordinación</h3>
            <p>CRUD completos para alumnos, empresas, tutores y prácticas (solo coordinador).</p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
                <a class="btn" href="{{ route('admin.empresas.index') }}">Empresas</a>
                <a class="btn" href="{{ route('admin.tutores.index') }}">Tutores</a>
                <a class="btn" href="{{ route('admin.practicas.index') }}">Prácticas</a>
            </div>
            <p class="help" style="margin-top:10px;">Requiere rol <span class="badge">coordinador</span>.</p>
        </div>

        <div class="card">
            <h3>Sesión 10 – Autenticación y roles</h3>
            <p>Login, logout, middleware por roles y áreas privadas.</p>
            <div class="actions" style="margin-top:12px;">
                <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
                <a class="btn" href="{{ route('area.coordinador') }}">Área coordinador</a>
                <a class="btn" href="{{ route('area.alumno') }}">Área alumno</a>
                <a class="btn" href="{{ route('area.tutor') }}">Área tutor</a>
            </div>
        </div>

        <div class="card">
            <h3>Sesión 11 – Mensajería interna</h3>
            <p>Comunicación entre coordinadores, alumnos y tutores dentro de la plataforma.</p>
            <div class="actions" style="margin-top:12px;">
                @if (Auth::check())
                    <a class="btn btn-primary" href="{{ route('mensajes.index') }}">Mi bandeja</a>
                    <a class="btn" href="{{ route('mensajes.create') }}">Redactar</a>
                @else
                    <a class="btn" href="{{ route('login') }}">Inicia sesión para acceder</a>
                @endif
            </div>
        </div>
    </aside>
</div>
@endsection

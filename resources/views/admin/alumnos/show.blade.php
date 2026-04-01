@extends('layouts.app')

@section('title', 'Detalle de alumno · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>{{ $alumno->nombre }}</h2>
        <p>Detalle de la ficha del alumno seleccionado.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.alumnos.edit', $alumno) }}">Editar</a>
        <a class="btn" href="{{ route('admin.alumnos.index') }}">Volver</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Datos principales</h3>

        <div class="kv">
            <div class="k">Nombre</div>
            <div class="v"><strong>{{ $alumno->nombre }}</strong></div>

            <div class="k">Email</div>
            <div class="v">{{ $alumno->email }}</div>

            <div class="k">Grado</div>
            <div class="v">{{ $alumno->grado }}</div>

            <div class="k">Curso</div>
            <div class="v">{{ $alumno->curso }}</div>

            <div class="k">Prácticas asociadas</div>
            <div class="v">{{ $alumno->practicas()->count() }}</div>
        </div>
    </div>

    <div class="card">
        <h3>Acceso al portal</h3>

        @if($alumno->user)
            <div class="portal-access-status is-active">
                <strong>Acceso activo</strong>
                <div class="muted">Cuenta enlazada con el email <strong>{{ $alumno->user->email }}</strong>.</div>
                @if($alumno->user->must_change_password)
                    <div class="help">El usuario todavía debe cambiar su contraseña temporal.</div>
                @endif
            </div>
        @else
            <div class="portal-access-status">
                <strong>Sin acceso generado</strong>
                <div class="muted">Puedes generar sus credenciales desde la pantalla de edición.</div>
            </div>
        @endif

        <hr class="hr">

        <div class="actions" style="margin-top:12px;">
            <a class="btn" href="{{ route('admin.practicas.index', ['alumno_id' => $alumno->id]) }}">Ver prácticas del alumno</a>
            <a class="btn" href="{{ route('admin.practicas.create') }}">Crear práctica</a>
        </div>
    </div>
</div>
@endsection

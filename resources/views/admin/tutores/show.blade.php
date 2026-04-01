@extends('layouts.app')

@section('title', 'Detalle de tutor · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>{{ $tutor->nombre }}</h2>
        <p>Detalle del tutor seleccionado.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.tutores.edit', $tutor) }}">Editar</a>
        <a class="btn" href="{{ route('admin.tutores.index') }}">Volver</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Datos principales</h3>

        <div class="kv">
            <div class="k">Nombre</div>
            <div class="v"><strong>{{ $tutor->nombre }}</strong></div>

            <div class="k">Empresa</div>
            <div class="v">{{ $tutor->empresa->nombre ?? '-' }}</div>

            <div class="k">Email</div>
            <div class="v">{{ $tutor->email }}</div>

            <div class="k">Teléfono</div>
            <div class="v">{{ $tutor->telefono }}</div>

            <div class="k">Prácticas asociadas</div>
            <div class="v">{{ $tutor->practicas()->count() }}</div>
        </div>
    </div>

    <div class="card">
        <h3>Acceso al portal</h3>

        @if($tutor->user)
            <div class="portal-access-status is-active">
                <strong>Acceso activo</strong>
                <div class="muted">Cuenta enlazada con el email <strong>{{ $tutor->user->email }}</strong>.</div>
                @if($tutor->user->must_change_password)
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
            <a class="btn" href="{{ route('admin.practicas.index', ['tutor_id' => $tutor->id]) }}">Ver prácticas del tutor</a>
            <a class="btn" href="{{ route('admin.practicas.create') }}">Crear práctica</a>
        </div>
    </div>
</div>
@endsection

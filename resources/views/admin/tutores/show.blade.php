@extends('layouts.app')

@section('title', 'Detalle de tutor · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Tutor #{{ $tutor->id }}</h2>
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
        <h3>Acciones</h3>
        <p class="muted">Accesos rápidos relacionados.</p>

        <div class="actions" style="margin-top:12px;">
            <a class="btn" href="{{ route('admin.practicas.index', ['tutor_id' => $tutor->id]) }}">Ver prácticas del tutor</a>
            <a class="btn" href="{{ route('admin.practicas.create') }}">Crear práctica</a>
        </div>

        <hr class="hr">

        <div class="help">Nota: la mensajería está disponible desde la barra superior.</div>
    </div>
</div>
@endsection

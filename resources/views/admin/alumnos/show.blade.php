@extends('layouts.app')

@section('title', 'Detalle de alumno · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Alumno #{{ $alumno->id }}</h2>
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
        <h3>Acciones</h3>
        <p class="muted">Accesos rápidos relacionados.</p>

        <div class="actions" style="margin-top:12px;">
            <a class="btn" href="{{ route('admin.practicas.index', ['alumno_id' => $alumno->id]) }}">Ver prácticas del alumno</a>
            <a class="btn" href="{{ route('admin.practicas.create') }}">Crear práctica</a>
        </div>

        <hr class="hr">

        <div class="help">Consejo: usa el filtro de prácticas para localizar rápidamente las asignaciones.</div>
    </div>
</div>
@endsection

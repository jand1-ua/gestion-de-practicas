@extends('layouts.app')

@section('title', 'Editar alumno · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Editar alumno</h2>
        <p>Actualiza la información del alumno seleccionado.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.alumnos.show', $alumno) }}">Ver detalle</a>
        <a class="btn" href="{{ route('admin.alumnos.index') }}">Volver</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.alumnos.update', $alumno) }}">
        @csrf
        @method('PUT')

        @include('admin.alumnos._form', ['alumno' => $alumno])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar cambios</button>
            <a class="btn" href="{{ route('admin.alumnos.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

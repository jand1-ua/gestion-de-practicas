@extends('layouts.app')

@section('title', 'Nuevo alumno · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Nuevo alumno</h2>
        <p>Alta de un alumno en el sistema.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.alumnos.index') }}">Volver al listado</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.alumnos.store') }}">
        @include('admin.alumnos._form')

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="{{ route('admin.alumnos.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

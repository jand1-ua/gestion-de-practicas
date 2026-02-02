@extends('layouts.app')

@section('title', 'Nueva práctica · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Nueva práctica</h2>
        <p>Asigna un alumno a una empresa y un tutor para un periodo concreto.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.practicas.index') }}">Volver al listado</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.practicas.store') }}">
        @include('admin.practicas._form', [
            'alumnos' => $alumnos,
            'empresas' => $empresas,
            'tutores' => $tutores,
        ])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="{{ route('admin.practicas.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

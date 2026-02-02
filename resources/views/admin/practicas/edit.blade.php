@extends('layouts.app')

@section('title', 'Editar práctica · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Editar práctica #{{ $practica->id }}</h2>
        <p>Actualiza la asignación, fechas y estado.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.practicas.show', $practica) }}">Ver detalle</a>
        <a class="btn" href="{{ route('admin.practicas.index') }}">Volver</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.practicas.update', $practica) }}">
        @csrf
        @method('PUT')

        @include('admin.practicas._form', [
            'practica' => $practica,
            'alumnos' => $alumnos,
            'empresas' => $empresas,
            'tutores' => $tutores,
        ])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar cambios</button>
            <a class="btn" href="{{ route('admin.practicas.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

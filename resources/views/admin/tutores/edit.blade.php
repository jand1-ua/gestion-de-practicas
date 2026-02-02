@extends('layouts.app')

@section('title', 'Editar tutor · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Editar tutor</h2>
        <p>Actualiza la información del tutor seleccionado.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.tutores.show', $tutor) }}">Ver detalle</a>
        <a class="btn" href="{{ route('admin.tutores.index') }}">Volver</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.tutores.update', $tutor) }}">
        @csrf
        @method('PUT')

        @include('admin.tutores._form', ['empresas' => $empresas, 'tutor' => $tutor])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar cambios</button>
            <a class="btn" href="{{ route('admin.tutores.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Editar coordinador · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Editar coordinador</h2>
        <p>Actualiza los datos de acceso de la cuenta seleccionada.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.coordinadores.index') }}">Volver</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.coordinadores.update', $coordinador) }}">
        @csrf
        @method('PUT')

        @include('admin.coordinadores._form', ['coordinador' => $coordinador])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar cambios</button>
            <a class="btn" href="{{ route('admin.coordinadores.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

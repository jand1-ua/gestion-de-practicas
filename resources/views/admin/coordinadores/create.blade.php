@extends('layouts.app')

@section('title', 'Nuevo coordinador · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Nuevo coordinador</h2>
        <p>Alta de una nueva cuenta de coordinación con contraseña temporal.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.coordinadores.index') }}">Volver al listado</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.coordinadores.store') }}">
        @include('admin.coordinadores._form')

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="{{ route('admin.coordinadores.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

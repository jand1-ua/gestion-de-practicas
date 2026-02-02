@extends('layouts.app')

@section('title', 'Nuevo tutor · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Nuevo tutor</h2>
        <p>Alta de un tutor de empresa.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.tutores.index') }}">Volver al listado</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.tutores.store') }}">
        @include('admin.tutores._form', ['empresas' => $empresas, 'tutor' => null])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="{{ route('admin.tutores.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

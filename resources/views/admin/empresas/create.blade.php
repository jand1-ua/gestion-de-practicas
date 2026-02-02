@extends('layouts.app')

@section('title', 'Nueva empresa · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Nueva empresa</h2>
        <p>Registro de una empresa colaboradora.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.empresas.index') }}">Volver al listado</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.empresas.store') }}">
        @include('admin.empresas._form')

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="{{ route('admin.empresas.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Editar empresa · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Editar empresa</h2>
        <p>Actualiza la información de la empresa seleccionada.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('admin.empresas.show', $empresa) }}">Ver detalle</a>
        <a class="btn" href="{{ route('admin.empresas.index') }}">Volver</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="card">
    <form class="form" method="POST" action="{{ route('admin.empresas.update', $empresa) }}">
        @csrf
        @method('PUT')

        @include('admin.empresas._form', ['empresa' => $empresa])

        <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar cambios</button>
            <a class="btn" href="{{ route('admin.empresas.index') }}">Cancelar</a>
        </div>
    </form>
</div>
@endsection

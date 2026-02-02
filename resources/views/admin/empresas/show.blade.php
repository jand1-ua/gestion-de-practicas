@extends('layouts.app')

@section('title', 'Detalle de empresa · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Empresa #{{ $empresa->id }}</h2>
        <p>Detalle de la empresa seleccionada.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a>
        <a class="btn" href="{{ route('admin.empresas.index') }}">Volver</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Datos principales</h3>

        <div class="kv">
            <div class="k">Nombre</div>
            <div class="v"><strong>{{ $empresa->nombre }}</strong></div>

            <div class="k">CIF</div>
            <div class="v">{{ $empresa->cif }}</div>

            <div class="k">Sector</div>
            <div class="v">{{ $empresa->sector }}</div>

            <div class="k">Ciudad</div>
            <div class="v">{{ $empresa->ciudad }}</div>

            <div class="k">Prácticas asociadas</div>
            <div class="v">{{ $empresa->practicas()->count() }}</div>
        </div>
    </div>

    <div class="card">
        <h3>Contacto</h3>
        <p class="muted">Datos de contacto para coordinación.</p>

        <div class="kv">
            <div class="k">Email</div>
            <div class="v">{{ $empresa->email_contacto }}</div>

            <div class="k">Teléfono</div>
            <div class="v">{{ $empresa->telefono_contacto }}</div>
        </div>

        <hr class="hr">

        <div class="actions">
            <a class="btn" href="{{ route('admin.practicas.index', ['empresa_id' => $empresa->id]) }}">Ver prácticas de la empresa</a>
        </div>
    </div>
</div>
@endsection

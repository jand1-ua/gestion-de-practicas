@extends('layouts.app')

@section('title', 'Configurar contraseña · Gestión de Prácticas')

@section('content')
<div class="narrow">
    <div class="pagehead" style="margin-bottom:10px;">
        <div>
            <h2>Cambiar contraseña temporal</h2>
            <p>Tu cuenta se ha creado con una contraseña provisional. Debes definir una nueva antes de entrar en el resto de la aplicación.</p>
        </div>
    </div>

    @include('partials.validation-errors')

    <div class="card">
        <form class="form" method="POST" action="{{ route('password.setup.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label" for="password">Nueva contraseña</label>
                <input class="control" id="password" type="password" name="password" required autocomplete="new-password">
                <div class="help">Usa al menos 8 caracteres e incluye letras y números.</div>
            </div>

            <div class="field">
                <label class="label" for="password_confirmation">Confirmar contraseña</label>
                <input class="control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Guardar contraseña</button>
            </div>
        </form>

        <div class="actions" style="margin-top:12px;">
            <form class="inline" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>
</div>
@endsection

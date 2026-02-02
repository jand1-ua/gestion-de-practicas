@extends('layouts.app')

@section('title', 'Iniciar sesión · Gestión de Prácticas')

@section('content')
<div class="narrow">
    <div class="pagehead" style="margin-bottom:10px;">
        <div>
            <h2>Iniciar sesión</h2>
            <p>Accede con tu email y contraseña. Según tu rol verás un área diferente.</p>
        </div>
    </div>

    @include('partials.validation-errors')

    <form class="form" method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="field">
            <label class="label" for="email">Email</label>
            <input class="control" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
        </div>

        <div class="field">
            <label class="label" for="password">Contraseña</label>
            <input class="control" id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <label class="label" style="display:flex; align-items:center; gap:10px; margin-top:4px;">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            Recordar sesión
        </label>

        <div class="actions" style="margin-top:8px;">
            <button class="btn btn-primary" type="submit">Entrar</button>
            <a class="btn" href="{{ route('home') }}">Volver a inicio</a>
        </div>
    </form>
</div>
@endsection

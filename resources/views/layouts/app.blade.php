<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'PractUA')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('head')
</head>
<body>
@php
    $user = auth()->user();
@endphp

<div class="wrap stack">
    <header class="topbar" role="banner">
        <a class="brand" href="{{ route('home') }}" aria-label="Ir a inicio">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>PractUA</h1>
                <p>Alumnos · tutores · coordinadores</p>
            </div>
        </a>

        <button class="nav-toggle" type="button" aria-controls="app-nav" aria-expanded="false" title="Abrir/cerrar menú">
            ☰
        </button>

        <nav id="app-nav" class="nav" aria-label="Navegación principal">
            @if ($user)
                <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>

                @if ($user->role === 'coordinador')
                    <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Panel coordinador</a>
                @elseif ($user->role === 'alumno')
                    <a class="btn btn-primary" href="{{ route('area.alumno') }}">Mi área</a>
                @elseif ($user->role === 'tutor')
                    <a class="btn btn-primary" href="{{ route('area.tutor') }}">Mi área</a>
                @endif

                <form class="inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                </form>
            @else
                <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
            @endif
        </nav>
    </header>

    <main class="content" role="main">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="app-footer" role="contentinfo">
        <div>PractUA · Laravel v{{ Illuminate\Foundation\Application::VERSION }}</div>
        <div class="muted">PHP v{{ PHP_VERSION }}</div>
    </footer>
</div>

@stack('scripts')
</body>
</html>

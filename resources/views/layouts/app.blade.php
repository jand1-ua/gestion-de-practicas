<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'PractUA')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <script>
        (function () {
            try {
                var storedTheme = window.localStorage.getItem('practua-theme');
                var theme = storedTheme === 'light' || storedTheme === 'dark'
                    ? storedTheme
                    : 'dark';

                document.documentElement.setAttribute('data-theme', theme);
            } catch (error) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('head')
</head>
<body>
@php
    $user = auth()->user();
    $isActive = static fn (...$patterns) => request()->routeIs(...$patterns) ? ' is-active' : '';

    $primaryRoute = null;
    $primaryLabel = null;
    $primaryPatterns = [];

    if ($user?->isCoordinator()) {
        $primaryRoute = route('admin.dashboard');
        $primaryLabel = 'Panel coordinador';
        $primaryPatterns = ['admin.*', 'area.coordinador'];
    } elseif ($user?->isAlumno()) {
        $primaryRoute = route('area.alumno');
        $primaryLabel = 'Mi área';
        $primaryPatterns = ['area.alumno'];
    } elseif ($user?->isTutor()) {
        $primaryRoute = route('area.tutor');
        $primaryLabel = 'Mi área';
        $primaryPatterns = ['area.tutor'];
    }
@endphp

<div class="wrap stack">
    <header class="topbar" role="banner">
        <a class="brand" href="{{ route('home') }}" aria-label="Ir a inicio">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>PractUA</h1>
                <p>Gestión de prácticas externas</p>
            </div>
        </a>

        <button class="nav-toggle" type="button" aria-controls="app-nav" aria-expanded="false" title="Abrir/cerrar menú">
            ☰
        </button>

        <nav id="app-nav" class="nav" aria-label="Navegación principal">
            <a class="btn{{ $isActive('home') }}" href="{{ route('home') }}">Inicio</a>
            <button class="btn theme-toggle" type="button" data-theme-toggle aria-pressed="false" title="Cambiar entre modo claro y oscuro">
                <span class="theme-toggle__icon" data-theme-toggle-icon aria-hidden="true">☀️</span>
                <span data-theme-toggle-label>Modo claro</span>
            </button>

            @if ($user)
                <a class="btn{{ $isActive('mensajes.*') }}" href="{{ route('mensajes.index') }}">Mensajería</a>

                @if ($primaryRoute && $primaryLabel)
                    <a class="btn btn-primary{{ $isActive(...$primaryPatterns) }}" href="{{ $primaryRoute }}">{{ $primaryLabel }}</a>
                @endif

                <form class="inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                </form>
            @else
                <a class="btn btn-primary{{ $isActive('login') }}" href="{{ route('login') }}">Iniciar sesión</a>
            @endif
        </nav>
    </header>

    <main class="content" role="main">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="app-footer" role="contentinfo">
        <div>PractUA · Plataforma de gestión de prácticas</div>
        <div class="muted">Universidad · Empresas · Tutores · Alumnos</div>
    </footer>
</div>

@stack('scripts')
</body>
</html>

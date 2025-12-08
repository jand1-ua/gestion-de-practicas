<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestión de Prácticas de Alumnos</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f5f5;
            color: #222;
        }
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 24px 20px 32px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        h1 {
            margin-top: 0;
            margin-bottom: .25rem;
        }
        h2 {
            margin-top: 1.5rem;
            margin-bottom: .4rem;
        }
        p {
            margin: .25rem 0 .5rem;
        }
        ul {
            margin: 0 0 .75rem 1rem;
            padding-left: .5rem;
        }
        li {
            margin: .15rem 0;
        }
        a {
            color: #c62828;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        code {
            background: #eee;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: .9em;
        }
        footer {
            margin-top: 2rem;
            font-size: .8rem;
            color: #666;
        }
    </style>
</head>
<body>
<main>
    <header>
        <h1>Gestión de Prácticas de Alumnos</h1>
        <p>Aplicación de ejemplo para las sesiones de PHP y Laravel.</p>
        <p style="font-size: .9rem; color:#555;">
            Desde esta página puedes acceder rápidamente a los ejemplos de cada sesión.
        </p>
    </header>

    @php use Illuminate\Support\Facades\Auth; @endphp

    @if (Auth::check())
        <p style="font-size:.9rem; color:#555;">
            Sesión iniciada como <strong>{{ Auth::user()->name }}</strong>
            (rol: {{ Auth::user()->role }}).
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Ir al panel de administración</a>
            @elseif (Auth::user()->role === 'alumno')
                <a href="{{ route('area.alumno') }}">Ir a mi área de alumno</a>
            @elseif (Auth::user()->role === 'tutor')
                <a href="{{ route('area.tutor') }}">Ir a mi área de tutor</a>
            @endif
        </p>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    @else
        <p style="font-size:.9rem; color:#555;">
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </p>
    @endif


    {{-- Sesión 1 --}}
    <section>
        <h2>Sesión 1 – PHP básico (CLI)</h2>
        <p>
            Ejemplos de arrays, programación orientada a objetos y namespaces ejecutados por consola.
        </p>
        <ul>
            <li>Carpeta: <code>sesion_1</code> (subcarpetas <code>arrays</code>, <code>poo</code>, <code>namespaces</code>).</li>
            <li>Ejemplo: <code>php sesion_1/arrays/demo_listados.php</code></li>
        </ul>
    </section>

    {{-- Sesión 2 --}}
    <section>
        <h2>Sesión 2 – Laravel básico</h2>
        <p>Rutas, controladores y vistas usando datos en memoria.</p>
        <ul>
            <li><a href="{{ url('/demo/alumnos') }}">Demo: listado de alumnos (en memoria)</a></li>
            <li><a href="{{ url('/demo/practicas') }}">Demo: listado de prácticas (en memoria)</a></li>
        </ul>
    </section>

    {{-- Sesión 3 --}}
    <section>
        <h2>Sesión 3 – Acceso a datos (Query Builder)</h2>
        <p>Base de datos MySQL, migraciones, seeders y consultas con Query Builder.</p>
        <ul>
            <li><a href="{{ route('db.alumnos') }}">Listado de alumnos desde la base de datos</a></li>
            <li><a href="{{ route('db.practicas') }}">Listado de prácticas (joins alumno, empresa, tutor)</a></li>
        </ul>
    </section>

    {{-- Sesión 4 --}}
    <section>
        <h2>Sesión 4 – Eloquent ORM y relaciones</h2>
        <p>Mapeo objeto–relacional de Alumno, Empresa, Tutor y Práctica con Eloquent.</p>
        <ul>
            <li><a href="{{ route('eloquent.alumnos') }}">Alumnos con número de prácticas (Eloquent)</a></li>
            <li><a href="{{ route('eloquent.practicas') }}">Prácticas con sus relaciones (Eloquent)</a></li>
        </ul>
    </section>

    <section>
    <h2>Administración</h2>
    <ul>
        <li><a href="{{ route('admin.alumnos.index') }}">Gestión de alumnos</a></li>
        <li><a href="{{ route('admin.empresas.index') }}">Gestión de empresas</a></li>
        <li><a href="{{ route('admin.tutores.index') }}">Gestión de tutores</a></li>
        <li><a href="{{ route('admin.practicas.index') }}">Gestión de prácticas</a></li>
    </ul>
    </section>

    <footer>
        Gestión de Prácticas · Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        (PHP v{{ PHP_VERSION }})
    </footer>
</main>
</body>
</html>

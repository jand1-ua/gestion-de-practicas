<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sesiones · Gestión de Prácticas</title>

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
        header{
            display:flex;
            align-items:flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        h1 { margin: 0 0 .25rem; }
        h2 { margin-top: 1.6rem; margin-bottom: .35rem; }
        p { margin: .25rem 0 .5rem; color:#555; }

        a {
            color: #c62828;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        .btn {
            display:inline-block;
            padding: .45rem .75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            cursor: pointer;
            font-size: .95rem;
            text-decoration: none;
            color: #222;
        }
        .btn:hover { background: #fafafa; }
        .btn-primary { border-color: #c62828; color: #c62828; }

        section { margin-top: 1.2rem; }
        ul { margin: .25rem 0 .75rem 1rem; }
        li { margin: .15rem 0; }

        footer { margin-top: 2rem; font-size: .85rem; color: #666; }

        code {
            background: #eee;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: .9em;
        }

        .meta {
            font-size: .95rem;
            color:#555;
            margin-top: .25rem;
        }
        .meta a { margin-left: .35rem; }
        .actions {
            display:flex;
            gap:.6rem;
            flex-wrap:wrap;
        }
        .inline {
            display:inline;
            margin: 0;
        }
    </style>
</head>
<body>
<main>
    @php use Illuminate\Support\Facades\Auth; @endphp

    <header>
        <div>
            <h1>Sesiones</h1>
            <p>Índice del proyecto (hasta Sesión 11: mensajería interna).</p>

            @if (Auth::check())
                <div class="meta">
                    Sesión iniciada como <strong>{{ Auth::user()->name }}</strong>
                    (rol: <code>{{ Auth::user()->role }}</code>).
                    @if (Auth::user()->role === 'coordinador')
                        <a href="{{ route('admin.dashboard') }}">Ir al panel de coordinador</a>
                    @elseif (Auth::user()->role === 'alumno')
                        <a href="{{ route('area.alumno') }}">Ir a mi área de alumno</a>
                    @elseif (Auth::user()->role === 'tutor')
                        <a href="{{ route('area.tutor') }}">Ir a mi área de tutor</a>
                    @endif
                </div>
            @endif
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="{{ route('home') }}">Ir a inicio</a>

            @if (Auth::check())
                <form class="inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn" type="submit">Cerrar sesión</button>
                </form>
            @else
                <a class="btn" href="{{ route('login') }}">Login</a>
            @endif
        </div>
    </header>

    <section>
        <h2>Sesión 2 – Laravel básico (datos en memoria)</h2>
        <ul>
            <li><a href="{{ route('demo.alumnos') }}">Demo: alumnos (memoria)</a></li>
            <li><a href="{{ route('demo.practicas') }}">Demo: prácticas (memoria)</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 3 – Acceso a datos (Query Builder)</h2>
        <ul>
            <li><a href="{{ route('db.alumnos') }}">Alumnos desde BD</a></li>
            <li><a href="{{ route('db.practicas') }}">Prácticas (joins)</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 4 – Eloquent ORM</h2>
        <ul>
            <li><a href="{{ route('eloquent.alumnos') }}">Alumnos (Eloquent)</a></li>
            <li><a href="{{ route('eloquent.practicas') }}">Prácticas (Eloquent)</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 5 – CRUD alumnos</h2>
        <ul>
            <li><a href="{{ route('admin.alumnos.index') }}">Gestión de alumnos</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 6 – CRUD empresas y tutores</h2>
        <ul>
            <li><a href="{{ route('admin.empresas.index') }}">Empresas</a></li>
            <li><a href="{{ route('admin.tutores.index') }}">Tutores</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 7 – CRUD prácticas</h2>
        <ul>
            <li><a href="{{ route('admin.practicas.index') }}">Prácticas</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 8 – Validación y tests</h2>
        <ul>
            <li><code>tests/Feature</code> · <code>tests/Unit</code></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 9 – Filtros de prácticas</h2>
        <ul>
            <li>Parámetros GET y consultas dinámicas</li>
        </ul>
    </section>

    <section>
        <h2>Sesión 10 – Autenticación y roles</h2>
        <p>Login, logout, middleware por roles y áreas privadas.</p>
        <ul>
            <li>Roles: <code>coordinador</code>, <code>alumno</code>, <code>tutor</code></li>
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
            <li><a href="{{ route('area.coordinador') }}">Área coordinador</a></li>
            <li><a href="{{ route('area.alumno') }}">Área alumno</a></li>
            <li><a href="{{ route('area.tutor') }}">Área tutor</a></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 11 – Mensajería interna</h2>
        <p>Comunicación entre coordinadores, alumnos y tutores dentro de la plataforma.</p>
        <ul>
            <li>
                @if (Auth::check())
                    <a href="{{ route('mensajes.index') }}">Ir a mi bandeja de mensajes</a>
                @else
                    Debes <a href="{{ route('login') }}">iniciar sesión</a> para acceder a la mensajería.
                @endif
            </li>
            <li>
                @if (Auth::check())
                    <a href="{{ route('mensajes.create') }}">Redactar un mensaje</a>
                @else
                    (Disponible tras iniciar sesión)
                @endif
            </li>
        </ul>
    </section>

    <footer>
        Gestión de Prácticas · Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        (PHP v{{ PHP_VERSION }})
    </footer>
</main>
</body>
</html>

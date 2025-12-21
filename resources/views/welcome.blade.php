<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestión de Prácticas de Alumnos</title>

    <style>
        :root{
            --bg: #0b1220;
            --card: rgba(255,255,255,.08);
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.70);
            --line: rgba(255,255,255,.14);
            --accent: #c62828;
            --accent2: #ef4444;
        }
        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(1200px 600px at 15% 10%, rgba(198,40,40,.35), transparent 60%),
                radial-gradient(900px 500px at 85% 25%, rgba(239,68,68,.22), transparent 55%),
                linear-gradient(180deg, #070b14, var(--bg));
            min-height: 100vh;
        }
        .wrap{ max-width: 1120px; margin: 0 auto; padding: 34px 20px 60px; }

        .topbar{
            display:flex; align-items:center; justify-content:space-between; gap: 12px;
            padding: 14px 16px;
            border:1px solid var(--line);
            border-radius: 14px;
            background: rgba(255,255,255,.04);
        }
        .brand{ display:flex; align-items:center; gap: 10px; }
        .logo{
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
        }
        .brand h1{ margin:0; font-size: 14px; }
        .brand p{ margin:0; font-size: 12px; color: var(--muted); }

        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            padding: 10px 12px;
            border-radius: 12px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
            color: var(--text);
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn:hover{ background: rgba(255,255,255,.07); }
        .btn-primary{
            border-color: rgba(198,40,40,.55);
            background: rgba(198,40,40,.18);
        }
        .btn-primary:hover{ background: rgba(198,40,40,.26); }

        .hero{
            margin-top: 22px;
            padding: 22px 20px;
            border-radius: 18px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
        }
        .hero h2{
            margin: 0 0 8px;
            font-size: 30px;
            letter-spacing: -0.3px;
            line-height: 1.15;
        }
        .hero p{
            margin: 0 0 14px;
            color: var(--muted);
            line-height: 1.6;
            max-width: 90ch;
        }
        .cta{ display:flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }

        .grid{
            margin-top: 14px;
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        @media (max-width: 900px){
            .grid{ grid-template-columns: 1fr; }
        }
        .card{
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,.08);
            padding: 14px 14px 12px;
        }
        .card h3{ margin:0 0 6px; font-size: 14px; }
        .card p{ margin:0; font-size: 13px; color: var(--muted); line-height: 1.45; }
        code{
            background: rgba(255,255,255,.10);
            padding: 2px 6px;
            border-radius: 6px;
            font-size: .92em;
        }

        footer{
            margin-top: 22px;
            color: rgba(255,255,255,.55);
            font-size: 12px;
            display:flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<div class="wrap">

    @php use Illuminate\Support\Facades\Auth; @endphp

    <div class="topbar">
        <div class="brand">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>Gestión de Prácticas</h1>
                <p>Sesión 10 · Autenticación y roles</p>
            </div>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end;">
            <a class="btn" href="{{ route('sesiones') }}">Sesiones</a>

            @if (Auth::check())
                <span class="btn" style="cursor:default;">
                    {{ Auth::user()->name }} · {{ Auth::user()->role }}
                </span>

                @if (Auth::user()->role === 'coordinador')
                    <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Panel (Coordinación)</a>
                @elseif (Auth::user()->role === 'alumno')
                    <a class="btn btn-primary" href="{{ route('area.alumno') }}">Área alumno</a>
                @elseif (Auth::user()->role === 'tutor')
                    <a class="btn btn-primary" href="{{ route('area.tutor') }}">Área tutor</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn" type="submit">Cerrar sesión</button>
                </form>
            @else
                <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
            @endif
        </div>
    </div>

    <section class="hero">
        <h2>Bienvenido</h2>
        <p>
            En esta sesión se incorpora autenticación y control de acceso por roles.
        </p>

        <div class="cta">
            <a class="btn btn-primary" href="{{ route('sesiones') }}">Ir al índice de sesiones</a>

            @if (Auth::check() && Auth::user()->role === 'coordinador')
                <a class="btn" href="{{ route('admin.practicas.index') }}">Gestionar prácticas</a>
                <a class="btn" href="{{ route('admin.alumnos.index') }}">Gestionar alumnos</a>
                <a class="btn" href="{{ route('admin.empresas.index') }}">Gestionar empresas</a>
                <a class="btn" href="{{ route('admin.tutores.index') }}">Gestionar tutores</a>
            @endif
        </div>

        <div class="grid">
            <div class="card">
                <h3>Login / Logout</h3>
                <p>Inicio y cierre de sesión con regeneración de sesión.</p>
            </div>
            <div class="card">
                <h3>Roles</h3>
                <p>Acceso por rol: <code>coordinador</code>, <code>alumno</code>, <code>tutor</code>.</p>
            </div>
            <div class="card">
                <h3>Middleware</h3>
                <p>Protección de rutas con <code>auth</code> y <code>role:*</code>.</p>
            </div>
        </div>
    </section>

    <footer>
        <div>Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}</div>
        <div>Home (welcome) · Sesión 10</div>
    </footer>

</div>
</body>
</html>

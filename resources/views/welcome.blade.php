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
            --card-2: rgba(255,255,255,.06);
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.70);
            --line: rgba(255,255,255,.14);
            --accent: #c62828;
            --accent2: #ef4444;
            --shadow: 0 10px 30px rgba(0,0,0,.35);
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
        a{ color:inherit; text-decoration:none; }
        a:hover{ text-decoration:underline; }

        .wrap{ max-width:1080px; margin:0 auto; padding:28px 20px 56px; }

        .topbar{
            display:flex; align-items:center; justify-content:space-between; gap:12px;
            padding:14px 16px;
            border:1px solid var(--line);
            border-radius:14px;
            background: rgba(255,255,255,.04);
            box-shadow: 0 6px 18px rgba(0,0,0,.18);
            backdrop-filter: blur(6px);
        }
        .brand{ display:flex; align-items:center; gap:10px; min-width:240px; }
        .logo{
            width:36px; height:36px; border-radius:10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            box-shadow: 0 8px 18px rgba(198,40,40,.25);
        }
        .brand h1{ margin:0; font-size:14px; letter-spacing:.2px; }
        .brand p{ margin:0; font-size:12px; color: var(--muted); }

        .nav{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:flex-end; }

        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:10px 12px;
            border-radius:12px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
            color: var(--text);
            font-size:13px;
            text-decoration:none;
            cursor:pointer;
            white-space:nowrap;
        }
        .btn:hover{ background: rgba(255,255,255,.07); text-decoration:none; }
        .btn-primary{ border-color: rgba(198,40,40,.55); background: rgba(198,40,40,.18); }
        .btn-primary:hover{ background: rgba(198,40,40,.26); }
        .btn-ghost{ background: transparent; }

        form.inline{ display:inline; margin:0; }
        form.inline button{
            all:unset;
            display:inline-flex; align-items:center; justify-content:center;
            padding:10px 12px;
            border-radius:12px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
            color: var(--text);
            font-size:13px;
            cursor:pointer;
        }
        form.inline button:hover{ background: rgba(255,255,255,.07); }

        .hero{ margin-top:26px; display:grid; grid-template-columns: 1.2fr .8fr; gap:18px; }
        @media (max-width: 900px){ .hero{ grid-template-columns:1fr; } }

        .hero-main{
            padding:22px 20px;
            border-radius:18px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
            box-shadow: var(--shadow);
        }
        .kicker{
            display:inline-flex; gap:8px; align-items:center;
            font-size:12px;
            padding:6px 10px;
            border-radius:999px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.04);
            color: var(--muted);
        }
        .dot{
            width:7px; height:7px; border-radius:999px;
            background: rgba(34,197,94,.9);
            box-shadow: 0 0 0 4px rgba(34,197,94,.12);
            display:inline-block;
        }
        .hero-title{
            margin:12px 0 8px;
            font-size:34px;
            line-height:1.12;
            letter-spacing:-0.4px;
        }
        .hero-sub{
            margin:0 0 16px;
            color: var(--muted);
            line-height:1.55;
            font-size:14px;
            max-width:62ch;
        }
        .cta-row{ display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }

        .grid{ margin-top:18px; display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; }
        @media (max-width: 900px){ .grid{ grid-template-columns:1fr; } }

        .card{ border-radius:16px; border:1px solid var(--line); background: var(--card); padding:14px 14px 12px; }
        .card h3{ margin:0 0 6px; font-size:14px; letter-spacing:.2px; }
        .card p{ margin:0; font-size:13px; color: var(--muted); line-height:1.45; }

        .hero-side{
            padding:20px;
            border-radius:18px;
            border:1px solid var(--line);
            background: rgba(255,255,255,.03);
            box-shadow: 0 10px 26px rgba(0,0,0,.28);
        }
        .panel-title{
            margin:0 0 10px;
            font-size:14px;
            color: var(--muted);
            letter-spacing:.3px;
            text-transform:uppercase;
        }
        .who{
            border:1px solid var(--line);
            background: var(--card-2);
            border-radius:16px;
            padding:14px;
        }
        .who .name{ font-weight:650; margin:0 0 2px; font-size:16px; }
        .who .meta{ margin:0; color: var(--muted); font-size:13px; }

        .quick{ display:flex; flex-direction:column; gap:8px; margin-top:12px; }
        .quick .btn{ width:100%; justify-content:space-between; }

        .hint{
            margin-top:12px;
            padding-top:12px;
            border-top: 1px dashed rgba(255,255,255,.18);
            color: var(--muted);
            font-size:12.5px;
            line-height:1.45;
        }

        footer{
            margin-top:26px;
            padding-top:16px;
            border-top:1px solid rgba(255,255,255,.10);
            color: rgba(255,255,255,.55);
            font-size:12px;
            display:flex;
            justify-content:space-between;
            gap:10px;
            flex-wrap:wrap;
        }
        .muted{ color: var(--muted); }
        .nowrap{ white-space:nowrap; }
    </style>
</head>
<body>
@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();
@endphp

<div class="wrap">

    <div class="topbar">
        <div class="brand">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>Gestión de Prácticas</h1>
                <p>Plataforma académica · alumnos, tutores y coordinadores</p>
            </div>
        </div>

        <div class="nav">
            <a class="btn btn-ghost" href="{{ route('sesiones') }}">Sesiones</a>

            @if ($user)
                <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>

                @if ($user->role === 'coordinador')
                    <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Panel coordinador</a>
                @elseif ($user->role === 'alumno')
                    <a class="btn btn-primary" href="{{ route('area.alumno') }}">Mi área (alumno)</a>
                @elseif ($user->role === 'tutor')
                    <a class="btn btn-primary" href="{{ route('area.tutor') }}">Mi área (tutor)</a>
                @endif

                <form class="inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @else
                <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
            @endif
        </div>
    </div>

    <section class="hero">
        <div class="hero-main">
            <span class="kicker"><span class="dot"></span> Sistema activo · <span class="nowrap">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span></span>

            <h2 class="hero-title">Bienvenido a la plataforma de Gestión de Prácticas de Alumnos</h2>
            <p class="hero-sub">
                Centraliza el ciclo completo de prácticas: alta de alumnos, empresas y tutores, asignación de prácticas, seguimiento y mensajería interna.
            </p>

            <div class="cta-row">
                <a class="btn btn-primary" href="{{ route('sesiones') }}">Ir a sesiones / ejemplos</a>

                @if ($user)
                    @if ($user->role === 'coordinador')
                        <a class="btn" href="{{ route('admin.practicas.index') }}">Gestionar prácticas</a>
                    @elseif ($user->role === 'alumno')
                        <a class="btn" href="{{ route('area.alumno') }}">Ver mi área</a>
                    @elseif ($user->role === 'tutor')
                        <a class="btn" href="{{ route('area.tutor') }}">Ver mi área</a>
                    @endif
                @else
                    <a class="btn" href="{{ route('login') }}">Acceder</a>
                @endif
            </div>

            <div class="grid">
                <div class="card">
                    <h3>Gestión unificada</h3>
                    <p>Alumnos, empresas, tutores y prácticas en un flujo consistente.</p>
                </div>
                <div class="card">
                    <h3>Seguimiento por rol</h3>
                    <p>Accesos y acciones adaptados a coordinador, alumno y tutor.</p>
                </div>
                <div class="card">
                    <h3>Mensajería interna</h3>
                    <p>Comunicación directa dentro de la plataforma, con bandeja y respuestas.</p>
                </div>
            </div>
        </div>

        <aside class="hero-side">
            <p class="panel-title">Estado de la cuenta</p>

            @if ($user)
                <div class="who">
                    <p class="name">{{ $user->name }}</p>
                    <p class="meta">Rol: <strong>{{ $user->role }}</strong></p>
                    <p class="meta muted">Acceso: habilitado</p>
                </div>

                <div class="quick">
                    @if ($user->role === 'coordinador')
                        <a class="btn" href="{{ route('admin.alumnos.index') }}">Gestión de alumnos <span class="muted">→</span></a>
                        <a class="btn" href="{{ route('admin.empresas.index') }}">Gestión de empresas <span class="muted">→</span></a>
                        <a class="btn" href="{{ route('admin.tutores.index') }}">Gestión de tutores <span class="muted">→</span></a>
                        <a class="btn" href="{{ route('admin.practicas.index') }}">Gestión de prácticas <span class="muted">→</span></a>
                    @elseif ($user->role === 'alumno')
                        <a class="btn" href="{{ route('area.alumno') }}">Mi panel de alumno <span class="muted">→</span></a>
                        <a class="btn" href="{{ route('mensajes.index') }}">Mis mensajes <span class="muted">→</span></a>
                    @elseif ($user->role === 'tutor')
                        <a class="btn" href="{{ route('area.tutor') }}">Mi panel de tutor <span class="muted">→</span></a>
                        <a class="btn" href="{{ route('mensajes.index') }}">Mis mensajes <span class="muted">→</span></a>
                    @endif
                </div>

                <div class="hint">
                    Acceso rápido: “Sesiones” para ver ejemplos del curso y “Mensajería” para comunicarte con el resto de perfiles.
                </div>
            @else
                <div class="who">
                    <p class="name">Acceso no iniciado</p>
                    <p class="meta">Inicia sesión para ver tu panel y funciones según rol.</p>
                </div>

                <div class="quick">
                    <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión <span class="muted">→</span></a>
                    <a class="btn" href="{{ route('sesiones') }}">Ver sesiones / ejemplos <span class="muted">→</span></a>
                </div>

                <div class="hint">
                    Si no tienes credenciales, solicita al coordinador que cree tu cuenta o habilite tu acceso.
                </div>
            @endif
        </aside>
    </section>

    <footer>
        <div>Gestión de Prácticas · PHP v{{ PHP_VERSION }}</div>
        <div class="muted">Home · Bienvenida</div>
    </footer>
</div>
</body>
</html>

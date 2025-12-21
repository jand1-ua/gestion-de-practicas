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
        .wrap{ max-width: 1080px; margin: 0 auto; padding: 34px 20px 60px; }

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
            max-width: 80ch;
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
            background: var(--card);
            padding: 14px 14px 12px;
        }
        .card h3{ margin:0 0 6px; font-size: 14px; }
        .card p{ margin:0; font-size: 13px; color: var(--muted); line-height: 1.45; }

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

    <div class="topbar">
        <div class="brand">
            <div class="logo" aria-hidden="true"></div>
            <div>
                <h1>Gestión de Prácticas</h1>
                <p>Sesión 4 · Eloquent ORM y relaciones</p>
            </div>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end;">
            <a class="btn" href="{{ route('sesiones') }}">Sesiones</a>
            <a class="btn" href="{{ route('demo.alumnos') }}">S2: alumnos</a>
            <a class="btn" href="{{ route('db.alumnos') }}">S3: BD alumnos</a>
            <a class="btn btn-primary" href="{{ route('eloquent.alumnos') }}">S4: Eloquent alumnos</a>
        </div>
    </div>

    <section class="hero">
        <h2>Bienvenido</h2>
        <p>
            En esta sesión trabajas con Eloquent ORM y relaciones: modelos, relaciones entre entidades y consultas
            orientadas a objetos. Mantienes disponibles las demos de Sesión 2 (en memoria) y Sesión 3 (Query Builder),
            y añades la capa ORM de Sesión 4.
        </p>

        <div class="cta">
            <a class="btn btn-primary" href="{{ route('sesiones') }}">Ir al índice de sesiones</a>

            <a class="btn" href="{{ route('demo.alumnos') }}">Sesión 2: alumnos (memoria)</a>
            <a class="btn" href="{{ route('demo.practicas') }}">Sesión 2: prácticas (memoria)</a>

            <a class="btn" href="{{ route('db.alumnos') }}">Sesión 3: alumnos (BD)</a>
            <a class="btn" href="{{ route('db.practicas') }}">Sesión 3: prácticas (BD)</a>

            <a class="btn" href="{{ route('eloquent.alumnos') }}">Sesión 4: alumnos (Eloquent)</a>
            <a class="btn" href="{{ route('eloquent.practicas') }}">Sesión 4: prácticas (Eloquent)</a>
        </div>

        <div class="grid">
            <div class="card">
                <h3>Modelos y relaciones</h3>
                <p>Define entidades y relaciones (hasMany, belongsTo, etc.) para navegar datos.</p>
            </div>
            <div class="card">
                <h3>Eager loading</h3>
                <p>Carga relaciones eficientemente con <code>with()</code> para evitar N+1.</p>
            </div>
            <div class="card">
                <h3>Consultas ORM</h3>
                <p>Filtra y compón consultas con sintaxis de Eloquent y colecciones.</p>
            </div>
        </div>
    </section>

    <footer>
        <div>Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}</div>
        <div>Home (welcome) · Sesión 4</div>
    </footer>

</div>
</body>
</html>

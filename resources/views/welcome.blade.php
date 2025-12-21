<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Prácticas de Alumnos</title>

    <style>
        :root{
            --bg:#0b1220; --card:rgba(255,255,255,.08);
            --text:rgba(255,255,255,.92); --muted:rgba(255,255,255,.70);
            --line:rgba(255,255,255,.14);
            --accent:#c62828; --accent2:#ef4444;
        }
        body{
            margin:0;
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            color:var(--text);
            background:
                radial-gradient(1200px 600px at 15% 10%, rgba(198,40,40,.35), transparent 60%),
                radial-gradient(900px 500px at 85% 25%, rgba(239,68,68,.22), transparent 55%),
                linear-gradient(180deg,#070b14,var(--bg));
            min-height:100vh;
        }
        .wrap{max-width:1120px;margin:0 auto;padding:34px 20px 60px;}
        .topbar{display:flex;justify-content:space-between;gap:12px;padding:14px 16px;border:1px solid var(--line);border-radius:14px;background:rgba(255,255,255,.04);}
        .brand{display:flex;gap:10px;align-items:center;}
        .logo{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent2));}
        .brand h1{margin:0;font-size:14px;}
        .brand p{margin:0;font-size:12px;color:var(--muted);}
        .btn{padding:10px 12px;border-radius:12px;border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);text-decoration:none;font-size:13px;}
        .btn:hover{background:rgba(255,255,255,.07);}
        .btn-primary{border-color:rgba(198,40,40,.55);background:rgba(198,40,40,.18);}
        .hero{margin-top:22px;padding:22px 20px;border-radius:18px;border:1px solid var(--line);background:rgba(255,255,255,.04);}
        .hero h2{margin:0 0 8px;font-size:30px;}
        .hero p{margin:0 0 14px;color:var(--muted);max-width:85ch;}
        .cta{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px;}
        .grid{margin-top:14px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
        @media(max-width:900px){.grid{grid-template-columns:1fr;}}
        .card{border-radius:16px;border:1px solid var(--line);background:var(--card);padding:14px;}
        .card h3{margin:0 0 6px;font-size:14px;}
        .card p{margin:0;font-size:13px;color:var(--muted);}
        footer{margin-top:22px;font-size:12px;color:rgba(255,255,255,.55);}
        code{background:rgba(255,255,255,.1);padding:2px 6px;border-radius:6px;}
    </style>
</head>
<body>
<div class="wrap">

    <div class="topbar">
        <div class="brand">
            <div class="logo"></div>
            <div>
                <h1>Gestión de Prácticas</h1>
                <p>Sesión 9 · Filtros de prácticas</p>
            </div>
        </div>

        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn" href="{{ route('sesiones') }}">Sesiones</a>
            <a class="btn btn-primary" href="{{ route('admin.practicas.index') }}">Prácticas</a>
        </div>
    </div>

    <section class="hero">
        <h2>Bienvenido</h2>
        <p>
            En esta sesión se incorporan <code>filtros dinámicos</code> al listado de prácticas,
            permitiendo búsquedas por alumno, empresa, tutor u otros criterios mediante parámetros
            de consulta.
        </p>

        <div class="cta">
            <a class="btn btn-primary" href="{{ route('admin.practicas.index') }}">Probar filtros</a>
            <a class="btn" href="{{ route('sesiones') }}">Ver índice de sesiones</a>
        </div>

        <div class="grid">
            <div class="card">
                <h3>Filtros</h3>
                <p>Filtrado por campos relacionados usando Query Builder o Eloquent.</p>
            </div>
            <div class="card">
                <h3>Request</h3>
                <p>Uso de parámetros GET para construir consultas dinámicas.</p>
            </div>
            <div class="card">
                <h3>UX</h3>
                <p>Mejora de la experiencia de búsqueda en listados largos.</p>
            </div>
        </div>
    </section>

    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}
    </footer>

</div>
</body>
</html>

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
        }
        .wrap{max-width:1100px;margin:0 auto;padding:32px 20px 56px;}
        .topbar{display:flex;justify-content:space-between;gap:12px;padding:14px;border:1px solid var(--line);border-radius:14px;background:rgba(255,255,255,.04);}
        .brand{display:flex;gap:10px;align-items:center;}
        .logo{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent2));}
        .btn{padding:10px 12px;border-radius:12px;border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);text-decoration:none;font-size:13px;}
        .btn:hover{background:rgba(255,255,255,.07);}
        .btn-primary{border-color:rgba(198,40,40,.55);background:rgba(198,40,40,.18);}
        .hero{margin-top:20px;padding:22px;border-radius:18px;border:1px solid var(--line);background:rgba(255,255,255,.04);}
        .cta{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px;}
    </style>
</head>
<body>
<div class="wrap">

    <div class="topbar">
        <div class="brand">
            <div class="logo"></div>
            <div>
                <strong>Gestión de Prácticas</strong><br>
                <span style="font-size:12px;color:var(--muted)">Sesión 6 · CRUD empresas y tutores</span>
            </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn" href="{{ route('sesiones') }}">Sesiones</a>
            <a class="btn" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
            <a class="btn btn-primary" href="{{ route('admin.empresas.index') }}">Empresas</a>
            <a class="btn btn-primary" href="{{ route('admin.tutores.index') }}">Tutores</a>
        </div>
    </div>

    <section class="hero">
        <h2>Bienvenido</h2>
        <p>
            En esta sesión amplías el sistema CRUD incorporando la gestión completa de
            <strong>empresas</strong> y <strong>tutores</strong>, reutilizando Eloquent,
            validaciones y vistas administrativas.
        </p>

        <div class="cta">
            <a class="btn btn-primary" href="{{ route('admin.empresas.index') }}">Gestionar empresas</a>
            <a class="btn btn-primary" href="{{ route('admin.tutores.index') }}">Gestionar tutores</a>
            <a class="btn" href="{{ route('sesiones') }}">Ver índice de sesiones</a>
        </div>
    </section>

</div>
</body>
</html>

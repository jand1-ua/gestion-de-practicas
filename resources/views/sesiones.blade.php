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
        p { margin: .25rem 0 .5rem; }
        a {
            color: #c62828;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }

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

        section { margin-top: 1.4rem; }
        ul { margin: .25rem 0 .75rem 1rem; }
        li { margin: .15rem 0; }
        footer { margin-top: 2rem; font-size: .85rem; color: #666; }
        code {
            background: #eee;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: .9em;
        }
    </style>
</head>
<body>
<main>
    <header>
        <div>
            <h1>Sesiones</h1>
            <p style="color:#555;">
                Índice de la sesión actual (Sesión 2: rutas, controladores y vistas con datos en memoria).
            </p>
        </div>

        <div style="display:flex; gap:.6rem; flex-wrap:wrap;">
            <a class="btn btn-primary" href="{{ route('home') }}">Ir a inicio</a>
            <a class="btn" href="{{ route('demo.alumnos') }}">Demo alumnos</a>
            <a class="btn" href="{{ route('demo.practicas') }}">Demo prácticas</a>
        </div>
    </header>

    <section>
        <h2>Sesión 2 – Laravel básico</h2>
        <p>
            Demos de listados usando controladores y vistas Blade con datos en memoria.
        </p>
        <ul>
            <li><a href="{{ route('demo.alumnos') }}">Listado de alumnos (en memoria)</a></li>
            <li><a href="{{ route('demo.practicas') }}">Listado de prácticas (en memoria)</a></li>
        </ul>

        <p style="color:#555;">
            Archivos relevantes:
        </p>
        <ul>
            <li><code>routes/web.php</code> (rutas)</li>
            <li><code>app/Http/Controllers/DemoPracticasController.php</code> (controlador)</li>
            <li><code>resources/views/demo/*.blade.php</code> (vistas)</li>
        </ul>
    </section>

    <footer>
        Gestión de Prácticas · Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        (PHP v{{ PHP_VERSION }})
    </footer>
</main>
</body>
</html>

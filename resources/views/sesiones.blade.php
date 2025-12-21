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
    </style>
</head>
<body>
<main>
    <header>
        <div>
            <h1>Sesiones</h1>
            <p>Índice del proyecto (hasta Sesión 6: CRUD empresas y tutores).</p>
        </div>

        <div style="display:flex; gap:.6rem; flex-wrap:wrap;">
            <a class="btn btn-primary" href="{{ route('home') }}">Ir a inicio</a>
            <a class="btn" href="{{ route('admin.alumnos.index') }}">Admin</a>
        </div>
    </header>

    <section>
        <h2>Sesión 2 – Laravel básico (datos en memoria)</h2>
        <p>Rutas, controladores y vistas usando datos “mock” en memoria.</p>
        <ul>
            <li><a href="{{ route('demo.alumnos') }}">Demo: listado de alumnos (memoria)</a></li>
            <li><a href="{{ route('demo.practicas') }}">Demo: listado de prácticas (memoria)</a></li>
        </ul>
        <ul>
            <li><code>app/Http/Controllers/DemoPracticasController.php</code></li>
            <li><code>resources/views/demo/*.blade.php</code></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 3 – Acceso a datos (Query Builder)</h2>
        <p>Base de datos, migraciones, seeders y consultas con Query Builder.</p>
        <ul>
            <li><a href="{{ route('db.alumnos') }}">Listado de alumnos desde BD</a></li>
            <li><a href="{{ route('db.practicas') }}">Listado de prácticas (joins)</a></li>
        </ul>
        <ul>
            <li><code>database/migrations</code> · <code>database/seeders</code></li>
            <li><code>app/Http/Controllers/DbPracticasController.php</code></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 4 – Eloquent ORM y relaciones</h2>
        <p>Mapeo objeto–relacional con modelos Eloquent y relaciones.</p>
        <ul>
            <li><a href="{{ route('eloquent.alumnos') }}">Alumnos con número de prácticas (Eloquent)</a></li>
            <li><a href="{{ route('eloquent.practicas') }}">Prácticas con sus relaciones (Eloquent)</a></li>
        </ul>
        <ul>
            <li><code>app/Models</code> (modelos)</li>
            <li><code>app/Http/Controllers/EloquentPracticasController.php</code></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 5 – CRUD de alumnos</h2>
        <p>Gestión administrativa de alumnos mediante <code>Route::resource</code>.</p>
        <ul>
            <li><a href="{{ route('admin.alumnos.index') }}">Listado / gestión de alumnos</a></li>
            <li><a href="{{ route('admin.alumnos.create') }}">Crear alumno</a></li>
        </ul>
        <ul>
            <li><code>app/Http/Controllers/Admin/AlumnoController.php</code></li>
            <li><code>resources/views/admin/alumnos/*.blade.php</code></li>
        </ul>
    </section>

    <section>
        <h2>Sesión 6 – CRUD de empresas y tutores</h2>
        <p>Extensión del panel admin para gestionar empresas y tutores.</p>
        <ul>
            <li><a href="{{ route('admin.empresas.index') }}">Gestión de empresas</a></li>
            <li><a href="{{ route('admin.tutores.index') }}">Gestión de tutores</a></li>
        </ul>
        <ul>
            <li><code>app/Http/Controllers/Admin/EmpresaController.php</code></li>
            <li><code>app/Http/Controllers/Admin/TutorController.php</code></li>
            <li><code>resources/views/admin/empresas/*.blade.php</code> · <code>resources/views/admin/tutores/*.blade.php</code></li>
        </ul>
    </section>

    <footer>
        Gestión de Prácticas · Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        (PHP v{{ PHP_VERSION }})
    </footer>
</main>
</body>
</html>

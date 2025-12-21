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
        h1 { margin-top: 0; }
        h2 { margin-top: 1.6rem; }
        a { color: #c62828; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<main>
    <h1>Sesiones</h1>
    <p>Índice del proyecto (hasta Sesión 7).</p>

    <ul>
        <li>S2 – <a href="{{ route('demo.alumnos') }}">Demo alumnos</a></li>
        <li>S3 – <a href="{{ route('db.alumnos') }}">BD alumnos</a></li>
        <li>S4 – <a href="{{ route('eloquent.alumnos') }}">Eloquent alumnos</a></li>
        <li>S5 – <a href="{{ route('admin.alumnos.index') }}">CRUD alumnos</a></li>
        <li>S6 – 
            <a href="{{ route('admin.empresas.index') }}">Empresas</a> ·
            <a href="{{ route('admin.tutores.index') }}">Tutores</a>
        </li>
        <li>S7 – <a href="{{ route('admin.practicas.index') }}">CRUD prácticas</a></li>
    </ul>

    <p><a href="{{ route('home') }}">Volver a inicio</a></p>
</main>
</body>
</html>

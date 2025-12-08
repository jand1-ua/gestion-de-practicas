<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Área del tutor</title>
    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; margin:0; background:#f5f5f5; }
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 24px 20px 32px;
            background:#fff;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(0,0,0,0.06);
        }
        table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #eee; }
        a { color:#c62828; text-decoration:none; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<main>
    <h1>Área del tutor</h1>

    <p>
        Bienvenido, {{ $user->name }} ({{ $user->email }}).
    </p>

    <p>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
        &nbsp;|&nbsp;
        <a href="{{ url('/') }}">Inicio</a>
    </p>

    @if ($tutor)
        <h2>Prácticas que superviso</h2>

        @if ($tutor->practicas->isEmpty())
            <p>No tienes prácticas asignadas.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Alumno</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tutor->practicas as $practica)
                    <tr>
                        <td>{{ $practica->id }}</td>
                        <td>{{ $practica->alumno?->nombre }}</td>
                        <td>{{ $practica->empresa?->nombre }}</td>
                        <td>{{ $practica->estado }}</td>
                        <td>{{ $practica->fecha_inicio }}</td>
                        <td>{{ $practica->fecha_fin ?? '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    @else
        <p>No hay tutor asociado a este usuario.</p>
    @endif
</main>
</body>
</html>

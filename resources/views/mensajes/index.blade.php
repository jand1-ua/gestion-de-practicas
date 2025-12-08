<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajería interna</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 1.5rem; }
        th, td { border: 1px solid #ccc; padding: .4rem .6rem; }
        th { background: #f2f2f2; }
        .nav a { margin-right: 1rem; }
        .flash { padding: .5rem .75rem; margin-bottom: 1rem; border-radius: 4px; }
        .flash-success { background: #e6f4ea; border: 1px solid #2e7d32; color: #2e7d32; }
        .flash-error { background: #ffebee; border: 1px solid #c62828; color: #c62828; }
    </style>
</head>
<body>
    <h1>Mensajería interna</h1>

    <div class="nav">
        <a href="{{ url('/') }}">Inicio</a>

        @if ($usuario->isAdmin())
            <a href="{{ route('admin.dashboard') }}">Área de administración</a>
        @elseif ($usuario->isAlumno())
            <a href="{{ route('area.alumno') }}">Área del alumno</a>
        @elseif ($usuario->isTutor())
            <a href="{{ route('area.tutor') }}">Área del tutor</a>
        @endif

        <a href="{{ route('mensajes.create') }}">Nuevo mensaje</a>
    </div>

    @if (session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    <h2>Bandeja de entrada</h2>

    <table>
        <thead>
        <tr>
            <th>Fecha</th>
            <th>De</th>
            <th>Asunto</th>
            <th>Práctica</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        @forelse($recibidos as $mensaje)
            <tr>
                <td>{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $mensaje->remitente->name }} ({{ $mensaje->remitente->role }})</td>
                <td>
                    <a href="{{ route('mensajes.show', $mensaje) }}">
                        {{ $mensaje->asunto ?: 'Sin asunto' }}
                    </a>
                </td>
                <td>
                    @if($mensaje->practica)
                        #{{ $mensaje->practica->id }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($mensaje->leido_en)
                        Leído
                    @else
                        <strong>No leído</strong>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No tienes mensajes recibidos.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $recibidos->links() }}

    <h2>Mensajes enviados</h2>

    <table>
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Para</th>
            <th>Asunto</th>
            <th>Práctica</th>
        </tr>
        </thead>
        <tbody>
        @forelse($enviados as $mensaje)
            <tr>
                <td>{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $mensaje->destinatario->name }} ({{ $mensaje->destinatario->role }})</td>
                <td>
                    <a href="{{ route('mensajes.show', $mensaje) }}">
                        {{ $mensaje->asunto ?: 'Sin asunto' }}
                    </a>
                </td>
                <td>
                    @if($mensaje->practica)
                        #{{ $mensaje->practica->id }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No has enviado ningún mensaje.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $enviados->links() }}
</body>
</html>

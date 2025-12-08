<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del mensaje</title>
    <style>
        .nav a { margin-right: 1rem; }
        .meta { margin-bottom: 1rem; }
        .meta div { margin-bottom: .2rem; }
        .contenido { border: 1px solid #ccc; padding: .6rem .7rem; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Mensaje</h1>

    @php
        // $usuario viene desde el controlador, pero por si acaso:
        $usuario = $usuario ?? auth()->user();

        // Si soy destinatario, responder al remitente; si soy remitente, responder al destinatario
        $respuestaId = ($usuario && $usuario->id === $mensaje->destinatario_id)
            ? $mensaje->remitente_id
            : $mensaje->destinatario_id;
    @endphp

    <div class="nav">
        <a href="{{ route('mensajes.index') }}">Volver a mensajería</a>
        {{-- Pasamos destinatario_id para que el formulario lo preseleccione --}}
        <a href="{{ route('mensajes.create', ['destinatario_id' => $respuestaId]) }}">
            Responder
        </a>
    </div>

    <div class="meta">
        <div><strong>De:</strong> {{ $mensaje->remitente->name }} ({{ $mensaje->remitente->role }})</div>
        <div><strong>Para:</strong> {{ $mensaje->destinatario->name }} ({{ $mensaje->destinatario->role }})</div>
        <div><strong>Fecha:</strong> {{ $mensaje->created_at->format('d/m/Y H:i') }}</div>
        <div><strong>Asunto:</strong> {{ $mensaje->asunto ?: 'Sin asunto' }}</div>
        @if($mensaje->practica)
            <div><strong>Práctica asociada:</strong> #{{ $mensaje->practica->id }}</div>
        @endif
    </div>

    <div class="contenido">
        {{-- El campo en la BD se llama "cuerpo" --}}
        {{ $mensaje->cuerpo }}
    </div>
</body>
</html>

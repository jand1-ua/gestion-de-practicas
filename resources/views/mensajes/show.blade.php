@extends('layouts.app')

@section('title', 'Detalle del mensaje · Gestión de Prácticas')

@section('content')
@php
    $usuario = $usuario ?? auth()->user();

    // Si soy destinatario, responder al remitente; si soy remitente, responder al destinatario
    $respuestaId = ($usuario && $usuario->id === $mensaje->destinatario_id)
        ? $mensaje->remitente_id
        : $mensaje->destinatario_id;
@endphp

<div class="pagehead">
    <div>
        <h2>Mensaje</h2>
        <p>Detalle y contenido del mensaje seleccionado.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('mensajes.index') }}">Volver a mensajería</a>
        <a class="btn btn-primary" href="{{ route('mensajes.create', ['destinatario_id' => $respuestaId]) }}">Responder</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Detalles</h3>

        <div class="stack" style="gap:8px; margin-top:12px;">
            <div><span class="muted">De:</span> <strong>{{ $mensaje->remitente->name }}</strong> <span class="muted">({{ $mensaje->remitente->role }})</span></div>
            <div><span class="muted">Para:</span> <strong>{{ $mensaje->destinatario->name }}</strong> <span class="muted">({{ $mensaje->destinatario->role }})</span></div>
            <div><span class="muted">Fecha:</span> <span class="nowrap">{{ $mensaje->created_at->format('d/m/Y H:i') }}</span></div>
            <div><span class="muted">Asunto:</span> {{ $mensaje->asunto ?: 'Sin asunto' }}</div>

            @if($mensaje->practica)
                <div><span class="muted">Práctica asociada:</span> #{{ $mensaje->practica->id }}</div>
            @endif

            <div>
                <span class="muted">Estado:</span>
                @if($mensaje->leido_en)
                    <span class="badge badge-ok">Leído</span>
                @else
                    <span class="badge badge-warn">No leído</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Contenido</h3>
        <div style="margin-top:12px; white-space: pre-wrap; line-height:1.6; color: rgba(255,255,255,.88);">
            {{ $mensaje->cuerpo }}
        </div>
    </div>
</div>
@endsection

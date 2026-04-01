@extends('layouts.app')

@section('title', 'Detalle del mensaje · Gestión de Prácticas')

@section('content')
@php
    $authUser = auth()->user();
    $backRoute = $authUser?->isCoordinator()
        ? route('admin.dashboard')
        : ($authUser?->isTutor()
            ? route('area.tutor')
            : route('area.alumno'));
    $backLabel = $authUser?->isCoordinator() ? 'Panel coordinador' : 'Mi área';
@endphp

@if($authUser?->isCoordinator())
    @include('partials.admin-subnav')
@endif
@php
    $usuario = $usuario ?? auth()->user();

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
        <a class="btn" href="{{ $backRoute }}">{{ $backLabel }}</a>
        <a class="btn" href="{{ route('mensajes.index') }}">Volver a mensajería</a>
        <a class="btn btn-primary" href="{{ route('mensajes.create', ['destinatario_id' => $respuestaId]) }}">Responder</a>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Detalles</h3>

        <div class="stack" style="gap:8px; margin-top:12px;">
            <div><span class="muted">De:</span> <strong>{{ $mensaje->remitente->profileName() }}</strong> <span class="muted">({{ $mensaje->remitente->roleLabel() }})</span></div>
            <div><span class="muted">Para:</span> <strong>{{ $mensaje->destinatario->profileName() }}</strong> <span class="muted">({{ $mensaje->destinatario->roleLabel() }})</span></div>
            <div><span class="muted">Fecha:</span> <span class="nowrap">{{ $mensaje->created_at->format('d/m/Y H:i') }}</span></div>
            <div><span class="muted">Asunto:</span> {{ $mensaje->asunto ?: 'Sin asunto' }}</div>

            @if($mensaje->practica)
                <div>
                    <span class="muted">Práctica asociada:</span>
                    {{ $mensaje->practica->alumno?->nombre ?? 'Alumno no disponible' }}
                    @if($mensaje->practica->empresa)
                        · {{ $mensaje->practica->empresa->nombre }}
                    @endif
                    @if($mensaje->practica->tutor)
                        · Tutor: {{ $mensaje->practica->tutor->nombre }}
                    @endif
                </div>
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
        <div class="message-body" style="margin-top:12px;">{{ $mensaje->cuerpo }}</div>
    </div>
</div>
@endsection

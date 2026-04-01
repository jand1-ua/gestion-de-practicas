@extends('layouts.app')

@section('title', 'Nuevo mensaje · Gestión de Prácticas')

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
<div class="pagehead">
    <div>
        <h2>Nuevo mensaje</h2>
        <p>Redacta un mensaje a un usuario permitido según tu rol.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ $backRoute }}">{{ $backLabel }}</a>
        <a class="btn" href="{{ route('mensajes.index') }}">Volver a mensajería</a>
    </div>
</div>

@include('partials.validation-errors')

<div class="grid-2">
    <div class="card">
        <h3>Redactar</h3>

        <form class="form" method="POST" action="{{ route('mensajes.store') }}">
            @csrf

            <div class="field">
                <label class="label" for="destinatario_id">Destinatario</label>
                <select class="select" name="destinatario_id" id="destinatario_id" required>
                    <option value="">-- Selecciona un usuario --</option>
                    @foreach($destinatarios as $dest)
                        <option value="{{ $dest->id }}"
                            @selected(old('destinatario_id', $destinatarioId ?? '') == $dest->id)>
                            {{ $dest->profileName() !== '' ? $dest->profileName() : $dest->email }} ({{ $dest->roleLabel() }})
                        </option>
                    @endforeach
                </select>
                @error('destinatario_id')
                    <div class="help" style="color: rgba(255,255,255,.9);">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="asunto">Asunto <span class="muted-2">(opcional)</span></label>
                <input class="control" type="text" name="asunto" id="asunto" value="{{ old('asunto') }}" maxlength="255" placeholder="Ej: Dudas sobre la práctica...">
                @error('asunto')
                    <div class="help" style="color: rgba(255,255,255,.9);">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="cuerpo">Mensaje</label>
                <textarea class="textarea" name="cuerpo" id="cuerpo" rows="7" placeholder="Escribe tu mensaje...">{{ old('cuerpo') }}</textarea>
                @error('cuerpo')
                    <div class="help" style="color: rgba(255,255,255,.9);">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Enviar</button>
                <a class="btn" href="{{ route('mensajes.index') }}">Cancelar</a>
            </div>
        </form>
    </div>

    <aside class="card">
        <h3>Reglas de destinatarios</h3>
        <p class="muted">Resumen rápido de a quién puedes escribir:</p>

        <div class="stack" style="gap:10px; margin-top:12px;">
            <div class="card" style="background: rgba(255,255,255,.06);">
                <h3>Coordinador</h3>
                <p>Puede escribir a cualquier usuario (excepto a sí mismo).</p>
            </div>
            <div class="card" style="background: rgba(255,255,255,.06);">
                <h3>Alumno</h3>
                <p>Puede escribir a coordinadores y a tutores con los que comparta práctica.</p>
            </div>
            <div class="card" style="background: rgba(255,255,255,.06);">
                <h3>Tutor</h3>
                <p>Puede escribir a coordinadores y a alumnos con los que comparta práctica.</p>
            </div>
        </div>

        <div class="alert alert-info" style="margin-top:14px;">
            Consejo: usa <strong>Responder</strong> desde un mensaje para preseleccionar el destinatario.
        </div>
    </aside>
</div>
@endsection

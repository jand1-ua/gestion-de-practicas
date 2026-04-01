@extends('layouts.app')

@section('title', 'Mensajería · Gestión de Prácticas')

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
        <h2>Mensajería interna</h2>
        <p>Consulta tus mensajes recibidos y enviados. Los no leídos aparecen marcados.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ $backRoute }}">{{ $backLabel }}</a>
        <a class="btn btn-primary" href="{{ route('mensajes.create') }}">Nuevo mensaje</a>
    </div>
</div>

<div class="stack">
    <section class="card">
        <h3>Bandeja de entrada</h3>
        <p class="muted">{{ $recibidos->total() }} mensaje(s). Puedes abrirlos pulsando en cualquier fila o en el botón “Ver”.</p>

        <div class="table-wrap" style="margin-top:12px;">
            <table class="table" id="mensajes-recibidos-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>De</th>
                        <th>Asunto</th>
                        <th>Práctica</th>
                        <th>Estado</th>
                        <th style="width:120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recibidos as $mensaje)
                        <tr class="table-row-link {{ $mensaje->leido_en ? '' : 'is-unread' }}" data-href="{{ route('mensajes.show', $mensaje) }}" tabindex="0">
                            <td class="muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $mensaje->remitente->profileName() }} <span class="muted">({{ $mensaje->remitente->roleLabel() }})</span></td>
                            <td>
                                <strong>{{ $mensaje->asunto ?: 'Sin asunto' }}</strong>
                                <div class="muted-2">{{ \Illuminate\Support\Str::limit($mensaje->cuerpo, 90) }}</div>
                            </td>
                            <td class="muted">
                                @if($mensaje->practica)
                                    {{ $mensaje->practica->alumno?->nombre ?? 'Práctica asociada' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($mensaje->leido_en)
                                    <span class="badge badge-ok">Leído</span>
                                @else
                                    <span class="badge badge-warn">No leído</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm js-stop-row-link" href="{{ route('mensajes.show', $mensaje) }}">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="muted">No tienes mensajes recibidos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $recibidos->links() }}
    </section>

    <section class="card">
        <h3>Enviados</h3>
        <p class="muted">{{ $enviados->total() }} mensaje(s). Puedes abrirlos pulsando en cualquier fila o en el botón “Ver”.</p>

        <div class="table-wrap" style="margin-top:12px;">
            <table class="table" id="mensajes-enviados-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Para</th>
                        <th>Asunto</th>
                        <th>Práctica</th>
                        <th style="width:120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enviados as $mensaje)
                        <tr class="table-row-link" data-href="{{ route('mensajes.show', $mensaje) }}" tabindex="0">
                            <td class="muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $mensaje->destinatario->profileName() }} <span class="muted">({{ $mensaje->destinatario->roleLabel() }})</span></td>
                            <td>
                                <strong>{{ $mensaje->asunto ?: 'Sin asunto' }}</strong>
                                <div class="muted-2">{{ \Illuminate\Support\Str::limit($mensaje->cuerpo, 90) }}</div>
                            </td>
                            <td class="muted">
                                @if($mensaje->practica)
                                    {{ $mensaje->practica->alumno?->nombre ?? 'Práctica asociada' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm js-stop-row-link" href="{{ route('mensajes.show', $mensaje) }}">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted">No has enviado ningún mensaje.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $enviados->links() }}
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.table-row-link').forEach((row) => {
        const href = row.dataset.href;
        if (!href) {
            return;
        }

        row.addEventListener('click', (event) => {
            if (event.target.closest('a, button, form, input, select, textarea, label')) {
                return;
            }
            window.location.href = href;
        });

        row.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                window.location.href = href;
            }
        });
    });
});
</script>
@endpush

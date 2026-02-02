@extends('layouts.app')

@section('title', 'Mensajería · Gestión de Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Mensajería interna</h2>
        <p>Consulta tus mensajes recibidos y enviados. Los no leídos aparecen marcados.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('mensajes.create') }}">Nuevo mensaje</a>
    </div>
</div>

<div class="stack">
    <section class="card">
        <h3>Bandeja de entrada</h3>
        <p class="muted">{{ $recibidos->total() }} mensaje(s).</p>

        <div class="table-wrap" style="margin-top:12px;">
            <table class="table">
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
                            <td class="muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $mensaje->remitente->name }} <span class="muted">({{ $mensaje->remitente->role }})</span></td>
                            <td>
                                <a href="{{ route('mensajes.show', $mensaje) }}">
                                    {{ $mensaje->asunto ?: 'Sin asunto' }}
                                </a>
                            </td>
                            <td class="muted">
                                @if($mensaje->practica)
                                    #{{ $mensaje->practica->id }}
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted">No tienes mensajes recibidos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $recibidos->links() }}
    </section>

    <section class="card">
        <h3>Enviados</h3>
        <p class="muted">{{ $enviados->total() }} mensaje(s).</p>

        <div class="table-wrap" style="margin-top:12px;">
            <table class="table">
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
                            <td class="muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $mensaje->destinatario->name }} <span class="muted">({{ $mensaje->destinatario->role }})</span></td>
                            <td>
                                <a href="{{ route('mensajes.show', $mensaje) }}">
                                    {{ $mensaje->asunto ?: 'Sin asunto' }}
                                </a>
                            </td>
                            <td class="muted">
                                @if($mensaje->practica)
                                    #{{ $mensaje->practica->id }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="muted">No has enviado ningún mensaje.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $enviados->links() }}
    </section>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Eloquent · Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Eloquent: prácticas</h2>
        <p>Listado obtenido con Eloquent y relaciones práctica → alumno/empresa/tutor.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('eloquent.alumnos') }}">Ver alumnos (Eloquent)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $practicas->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Empresa</th>
                <th>Tutor</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($practicas as $practica)
                @php
                    $estado = $practica->estado;
                    $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                    $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                @endphp
                <tr>
                    <td class="muted">#{{ $practica->id }}</td>
                    <td><strong>{{ $practica->alumno->nombre ?? '-' }}</strong></td>
                    <td>{{ $practica->empresa->nombre ?? '-' }}</td>
                    <td>{{ $practica->tutor->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                    <td class="muted">{{ $practica->fecha_inicio }}</td>
                    <td class="muted">{{ $practica->fecha_fin ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

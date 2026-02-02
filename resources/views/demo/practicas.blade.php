@extends('layouts.app')

@section('title', 'Demo · Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Demo: prácticas</h2>
        <p>Listado generado desde clases de dominio (sin base de datos).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('demo.alumnos') }}">Ver alumnos (demo)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ count($practicas) }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alumno</th>
                    <th>Empresa</th>
                    <th>Tutor</th>
                    <th>Duración (días)</th>
                    <th>Estado hoy</th>
                </tr>
            </thead>
            <tbody>
                @foreach($practicas as $practica)
                    @php
                        $estado = $practica->getEstado();
                        $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                    @endphp
                    <tr>
                        <td class="muted">#{{ $practica->getId() }}</td>
                        <td><strong>{{ $practica->getAlumno()->getNombre() }}</strong></td>
                        <td>{{ $practica->getEmpresa()->getNombre() }}</td>
                        <td>{{ $practica->getTutor()->getNombre() }}</td>
                        <td class="muted">{{ $practica->getDuracionEnDias() }}</td>
                        <td><span class="badge {{ $badge }}">{{ $estado }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

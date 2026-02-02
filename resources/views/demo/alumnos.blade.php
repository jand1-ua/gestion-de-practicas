@extends('layouts.app')

@section('title', 'Demo · Alumnos')

@section('content')
<div class="pagehead">
    <div>
        <h2>Demo: alumnos</h2>
        <p>Listado generado desde clases de dominio (sin base de datos).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('demo.practicas') }}">Ver prácticas (demo)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ count($alumnos) }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->getId() }}</td>
                        <td><strong>{{ $alumno->getNombre() }}</strong></td>
                        <td class="muted">{{ $alumno->getEmail() }}</td>
                        <td>{{ $alumno->getGrado() }}</td>
                        <td>{{ $alumno->getCurso() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

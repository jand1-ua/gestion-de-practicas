@extends('layouts.app')

@section('title', 'Eloquent · Alumnos')

@section('content')
<div class="pagehead">
    <div>
        <h2>Eloquent: alumnos</h2>
        <p>Listado obtenido con Eloquent y relación alumno → prácticas.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('eloquent.practicas') }}">Ver prácticas (Eloquent)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $alumnos->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                    <th>Prácticas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->id }}</td>
                        <td><strong>{{ $alumno->nombre }}</strong></td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
                        <td>
                            <span class="badge {{ $alumno->practicas->count() ? 'badge-info' : '' }}">
                                {{ $alumno->practicas->count() }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Tutores · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Tutores</h2>
        <p>Gestión de tutores de empresa y su vinculación con empresas.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.tutores.create') }}">Nuevo tutor</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.tutores.index') }}" class="search-toolbar">
        <div class="field search-toolbar__field">
            <label class="label" for="q">Buscar</label>
            <input class="control" id="q" name="q" type="search" value="{{ $search ?? request('q') }}" data-autofocus
                   placeholder="Nombre, email, teléfono o empresa">
            <div class="help">La búsqueda consulta toda la base de datos y se mantiene al paginar.</div>
        </div>

        <div class="actions search-toolbar__actions">
            <button class="btn btn-primary" type="submit">Buscar</button>
            <a class="btn" href="{{ route('admin.tutores.index') }}">Limpiar</a>
        </div>

        <div class="muted search-toolbar__meta">{{ $tutores->total() }} registro(s)</div>
    </form>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acceso portal</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutores as $tutor)
                    <tr>
                        <td><a href="{{ route('admin.tutores.show', $tutor) }}"><strong>{{ $tutor->nombre }}</strong></a></td>
                        <td>{{ $tutor->empresa->nombre ?? '-' }}</td>
                        <td class="muted">{{ $tutor->email }}</td>
                        <td class="muted">{{ $tutor->telefono }}</td>
                        <td>
                            @if($tutor->user)
                                <span class="status-pill is-active">Activo</span>
                            @else
                                <span class="status-pill">No generado</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.tutores.edit', $tutor) }}">Editar</a>
                                <form action="{{ route('admin.tutores.destroy', $tutor) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este tutor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">No se han encontrado tutores con los criterios indicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tutores->links() }}
</div>
@endsection

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
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="tutores-search">Buscar</label>
            <input class="control" id="tutores-search" type="search" data-autofocus data-table-filter="tutores-table"
                   placeholder="Nombre, email, empresa...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $tutores->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="tutores-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutores as $tutor)
                    <tr>
                        <td class="muted">#{{ $tutor->id }}</td>
                        <td><a href="{{ route('admin.tutores.show', $tutor) }}"><strong>{{ $tutor->nombre }}</strong></a></td>
                        <td>{{ $tutor->empresa->nombre ?? '-' }}</td>
                        <td class="muted">{{ $tutor->email }}</td>
                        <td class="muted">{{ $tutor->telefono }}</td>
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
                        <td colspan="6" class="muted">No hay tutores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tutores->links() }}
</div>
@endsection

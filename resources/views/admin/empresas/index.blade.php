@extends('layouts.app')

@section('title', 'Empresas · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Empresas</h2>
        <p>Gestión de empresas colaboradoras y sus datos de contacto.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.empresas.create') }}">Nueva empresa</a>
    </div>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="empresas-search">Buscar</label>
            <input class="control" id="empresas-search" type="search" data-autofocus data-table-filter="empresas-table"
                   placeholder="Nombre, CIF, sector, ciudad...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $empresas->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="empresas-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>CIF</th>
                    <th>Sector</th>
                    <th>Ciudad</th>
                    <th>Contacto</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresas as $empresa)
                    <tr>
                        <td class="muted">#{{ $empresa->id }}</td>
                        <td><a href="{{ route('admin.empresas.show', $empresa) }}"><strong>{{ $empresa->nombre }}</strong></a></td>
                        <td class="muted">{{ $empresa->cif }}</td>
                        <td>{{ $empresa->sector }}</td>
                        <td>{{ $empresa->ciudad }}</td>
                        <td class="muted">
                            {{ $empresa->email_contacto }}<br>
                            {{ $empresa->telefono_contacto }}
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a>
                                <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar esta empresa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted">No hay empresas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $empresas->links() }}
</div>
@endsection

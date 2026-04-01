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
    <form method="GET" action="{{ route('admin.empresas.index') }}" class="search-toolbar">
        <div class="field search-toolbar__field">
            <label class="label" for="q">Buscar</label>
            <input class="control" id="q" name="q" type="search" value="{{ $search ?? request('q') }}" data-autofocus
                   placeholder="Nombre, CIF, sector, ciudad o contacto">
            <div class="help">La búsqueda consulta toda la base de datos y se mantiene al paginar.</div>
        </div>

        <div class="actions search-toolbar__actions">
            <button class="btn btn-primary" type="submit">Buscar</button>
            <a class="btn" href="{{ route('admin.empresas.index') }}">Limpiar</a>
        </div>

        <div class="muted search-toolbar__meta">{{ $empresas->total() }} registro(s)</div>
    </form>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
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
                        <td colspan="6" class="muted">No se han encontrado empresas con los criterios indicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $empresas->links() }}
</div>
@endsection

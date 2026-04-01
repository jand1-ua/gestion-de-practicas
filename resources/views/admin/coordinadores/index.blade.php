@extends('layouts.app')

@section('title', 'Coordinadores · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Coordinadores</h2>
        <p>Gestión de cuentas de coordinación. En esta opción A puede existir más de un coordinador activo.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.coordinadores.create') }}">Nuevo coordinador</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.coordinadores.index') }}" class="search-toolbar">
        <div class="field search-toolbar__field">
            <label class="label" for="q">Buscar</label>
            <input class="control" id="q" name="q" type="search" value="{{ $search ?? request('q') }}" data-autofocus
                   placeholder="Nombre o email de acceso">
            <div class="help">La búsqueda consulta toda la base de datos y se mantiene al paginar.</div>
        </div>

        <div class="actions search-toolbar__actions">
            <button class="btn btn-primary" type="submit">Buscar</button>
            <a class="btn" href="{{ route('admin.coordinadores.index') }}">Limpiar</a>
        </div>

        <div class="muted search-toolbar__meta">{{ $coordinadores->total() }} cuenta(s)</div>
    </form>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email de acceso</th>
                    <th>Rol</th>
                    <th>Estado contraseña</th>
                    <th style="width:220px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coordinadores as $coordinador)
                    <tr>
                        <td><strong>{{ $coordinador->profileName() }}</strong></td>
                        <td class="muted">{{ $coordinador->email }}</td>
                        <td><span class="status-pill is-active">{{ $coordinador->roleLabel() }}</span></td>
                        <td>
                            @if($coordinador->must_change_password)
                                <span class="badge badge-warn">Cambio pendiente</span>
                            @else
                                <span class="badge badge-ok">Operativa</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.coordinadores.edit', $coordinador) }}">Editar</a>
                                <form action="{{ route('admin.coordinadores.destroy', $coordinador) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar esta cuenta de coordinación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">No se han encontrado cuentas de coordinación con los criterios indicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $coordinadores->links() }}
</div>
@endsection

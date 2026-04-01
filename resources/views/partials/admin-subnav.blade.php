@php
    $user = auth()->user();
    $isActive = static fn (...$patterns) => request()->routeIs(...$patterns) ? ' is-active' : '';
@endphp

@if($user && $user->isCoordinator())
    <div class="subnav card">
        <div class="actions">
            <a class="btn btn-ghost{{ $isActive('admin.coordinadores.*') }}" href="{{ route('admin.coordinadores.index') }}">Coordinadores</a>
            <a class="btn btn-ghost{{ $isActive('admin.alumnos.*') }}" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
            <a class="btn btn-ghost{{ $isActive('admin.empresas.*') }}" href="{{ route('admin.empresas.index') }}">Empresas</a>
            <a class="btn btn-ghost{{ $isActive('admin.tutores.*') }}" href="{{ route('admin.tutores.index') }}">Tutores</a>
            <a class="btn btn-ghost{{ $isActive('admin.practicas.*') }}" href="{{ route('admin.practicas.index') }}">Prácticas</a>
            <a class="btn{{ $isActive('mensajes.*') }}" href="{{ route('mensajes.index') }}">Mensajería</a>
        </div>
        <div class="muted" style="font-size:12px;">Panel de coordinación</div>
    </div>
@endif

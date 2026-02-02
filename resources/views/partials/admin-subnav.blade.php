@php
    $user = auth()->user();
@endphp

@if($user && $user->role === 'coordinador')
    <div class="subnav card">
        <div class="actions">
            <a class="btn btn-ghost" href="{{ route('admin.alumnos.index') }}">Alumnos</a>
            <a class="btn btn-ghost" href="{{ route('admin.empresas.index') }}">Empresas</a>
            <a class="btn btn-ghost" href="{{ route('admin.tutores.index') }}">Tutores</a>
            <a class="btn btn-ghost" href="{{ route('admin.practicas.index') }}">Prácticas</a>
            <a class="btn" href="{{ route('mensajes.index') }}">Mensajería</a>
        </div>
        <div class="muted" style="font-size:12px;">Panel de coordinación</div>
    </div>
@endif

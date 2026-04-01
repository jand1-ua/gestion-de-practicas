@php
    $coordinador = $coordinador ?? new \App\Models\User();
@endphp

@csrf

<div class="field">
    <label class="label" for="name">Nombre</label>
    <input class="control" type="text" id="name" name="name" value="{{ old('name', $coordinador->name ?? '') }}" required>
</div>

<div class="field">
    <label class="label" for="email">Email de acceso</label>
    <input class="control" type="email" id="email" name="email" value="{{ old('email', $coordinador->email ?? '') }}" required>
    <div class="help">En la opción A la cuenta de coordinación vive en <code>users</code> y no se vincula a alumno ni tutor.</div>
</div>

<div class="portal-access-box">
    <h3>Acceso de coordinación</h3>
    @if($coordinador->exists)
        <div class="portal-access-status is-active">
            <strong>Cuenta ya creada</strong>
            <div class="muted">Puedes actualizar su email o regenerar su contraseña temporal cuando sea necesario.</div>
        </div>

        <label class="checkline">
            <input type="checkbox" name="reset_portal_access" value="1" {{ old('reset_portal_access') ? 'checked' : '' }}>
            Regenerar contraseña temporal
        </label>
        <div class="help">Se mostrará una nueva contraseña temporal una única vez y el coordinador deberá cambiarla al entrar.</div>
    @else
        <div class="portal-access-status is-active">
            <strong>Cuenta de acceso obligatoria</strong>
            <div class="muted">Al guardar se generará automáticamente una contraseña temporal.</div>
        </div>
    @endif
</div>

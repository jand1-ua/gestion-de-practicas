@php
    $tutor = $tutor ?? new \App\Models\Tutor();
    $portalUser = $portalUser ?? ($tutor->relationLoaded('user') ? $tutor->user : null);
@endphp

@csrf

<div class="field">
    <label class="label" for="empresa_id">Empresa</label>
    <select class="select" id="empresa_id" name="empresa_id" required>
        <option value="">-- Selecciona una empresa --</option>
        @foreach($empresas as $empresa)
            <option value="{{ $empresa->id }}" @selected((int) old('empresa_id', $tutor->empresa_id ?? 0) === (int) $empresa->id)>
                {{ $empresa->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="field">
    <label class="label" for="nombre">Nombre</label>
    <input class="control" type="text" id="nombre" name="nombre" value="{{ old('nombre', $tutor->nombre ?? '') }}" required>
</div>

<div class="field-row">
    <div class="field">
        <label class="label" for="email">Email</label>
        <input class="control" type="email" id="email" name="email" value="{{ old('email', $tutor->email ?? '') }}" required>
    </div>

    <div class="field">
        <label class="label" for="telefono">Teléfono</label>
        <input
            class="control"
            type="tel"
            id="telefono"
            name="telefono"
            value="{{ old('telefono', $tutor->telefono ?? '') }}"
            inputmode="tel"
            pattern="^\+?[0-9\s\-()]{9,20}$"
            placeholder="Ej. 600111222 o +34600111222"
            required
        >
        <div class="help">Se admiten 9 a 15 dígitos. Puedes escribir espacios o guiones; el sistema los normaliza.</div>
    </div>
</div>

<div class="portal-access-box">
    <h3>Acceso al portal</h3>
    <p class="muted">La ficha del tutor y la cuenta de acceso se gestionan de forma explícita. Puedes crear o regenerar el acceso desde aquí.</p>

    @if($portalUser)
        <div class="portal-access-status is-active">
            <strong>Acceso ya disponible</strong>
            <div class="muted">El tutor puede entrar con el email <strong>{{ $portalUser->email }}</strong>.</div>
        </div>

        <label class="checkline">
            <input type="checkbox" name="reset_portal_access" value="1" {{ old('reset_portal_access') ? 'checked' : '' }}>
            Regenerar contraseña temporal
        </label>
        <div class="help">Al guardar, se mostrará la nueva contraseña temporal y el tutor tendrá que cambiarla en el siguiente acceso.</div>
    @else
        <div class="portal-access-status">
            <strong>Sin acceso generado</strong>
            <div class="muted">El tutor puede existir en la base de datos sin cuenta mientras no se le habilite el portal.</div>
        </div>

        <label class="checkline">
            <input type="checkbox" name="create_portal_access" value="1" {{ old('create_portal_access', '1') ? 'checked' : '' }}>
            Crear acceso al portal con contraseña temporal
        </label>
        <div class="help">La contraseña temporal se mostrará una sola vez tras guardar y el tutor deberá cambiarla en su primer acceso.</div>
    @endif
</div>

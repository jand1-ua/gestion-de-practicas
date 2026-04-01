@php
    $alumno = $alumno ?? new \App\Models\Alumno();
    $gradosDisponibles = \App\Models\Alumno::gradosDisponibles();
    $cursosDisponibles = \App\Models\Alumno::cursosDisponibles();
    $portalUser = $portalUser ?? ($alumno->relationLoaded('user') ? $alumno->user : null);
@endphp

@csrf

<div class="field">
    <label class="label" for="nombre">Nombre</label>
    <input class="control" type="text" id="nombre" name="nombre" value="{{ old('nombre', $alumno->nombre ?? '') }}" required>
</div>

<div class="field-row">
    <div class="field">
        <label class="label" for="email">Email</label>
        <input class="control" type="email" id="email" name="email" value="{{ old('email', $alumno->email ?? '') }}" required>
    </div>

    <div class="field">
        <label class="label" for="grado">Grado</label>
        <select class="select" id="grado" name="grado" required>
            <option value="">-- Selecciona un grado --</option>
            @foreach($gradosDisponibles as $grado)
                <option value="{{ $grado }}" @selected(old('grado', $alumno->grado ?? '') === $grado)>
                    {{ $grado }}
                </option>
            @endforeach
        </select>
        <div class="help">Usa una lista predefinida para evitar errores de escritura.</div>
    </div>
</div>

<div class="field">
    <label class="label" for="curso">Curso</label>
    <select class="select" id="curso" name="curso" required>
        <option value="">-- Selecciona un curso --</option>
        @foreach($cursosDisponibles as $curso)
            <option value="{{ $curso }}" @selected(old('curso', $alumno->curso ?? '') === $curso)>
                {{ $curso }}
            </option>
        @endforeach
    </select>
    <div class="help">Se evita el texto libre para no depender de cómo se teclee 1º, 2º, 3º o 4º.</div>
</div>

<div class="portal-access-box">
    <h3>Acceso al portal</h3>
    <p class="muted">Crear la ficha del alumno no implica necesariamente crear su cuenta. Puedes generar el acceso ahora o más adelante.</p>

    @if($portalUser)
        <div class="portal-access-status is-active">
            <strong>Acceso ya disponible</strong>
            <div class="muted">El alumno puede entrar con el email <strong>{{ $portalUser->email }}</strong>.</div>
        </div>

        <label class="checkline">
            <input type="checkbox" name="reset_portal_access" value="1" {{ old('reset_portal_access') ? 'checked' : '' }}>
            Regenerar contraseña temporal
        </label>
        <div class="help">Si la marcas, el sistema generará una nueva contraseña temporal y obligará a cambiarla en el siguiente inicio de sesión.</div>
    @else
        <div class="portal-access-status">
            <strong>Sin acceso generado</strong>
            <div class="muted">La ficha puede existir sin credenciales. Así el coordinador controla cuándo se habilita el acceso.</div>
        </div>

        <label class="checkline">
            <input type="checkbox" name="create_portal_access" value="1" {{ old('create_portal_access', '1') ? 'checked' : '' }}>
            Crear acceso al portal con contraseña temporal
        </label>
        <div class="help">La contraseña temporal se mostrará una sola vez tras guardar y el usuario deberá cambiarla en su primer acceso.</div>
    @endif
</div>

@php
    $empresa = $empresa ?? new \App\Models\Empresa();
    $sectoresDisponibles = \App\Models\Empresa::sectoresDisponibles();
@endphp

@csrf

<div class="field">
    <label class="label" for="nombre">Nombre</label>
    <input class="control" type="text" id="nombre" name="nombre" value="{{ old('nombre', $empresa->nombre ?? '') }}" required>
</div>

<div class="field-row">
    <div class="field">
        <label class="label" for="cif">CIF</label>
        <input class="control" type="text" id="cif" name="cif" value="{{ old('cif', $empresa->cif ?? '') }}" required>
    </div>

    <div class="field">
        <label class="label" for="sector">Sector</label>
        <select class="select" id="sector" name="sector" required>
            <option value="">-- Selecciona un sector --</option>
            @foreach($sectoresDisponibles as $sector)
                <option value="{{ $sector }}" @selected(old('sector', $empresa->sector ?? '') === $sector)>
                    {{ $sector }}
                </option>
            @endforeach
        </select>
        <div class="help">Se usa una lista cerrada para evitar errores por texto libre.</div>
    </div>
</div>

<div class="field">
    <label class="label" for="ciudad">Ciudad</label>
    <input class="control" type="text" id="ciudad" name="ciudad" value="{{ old('ciudad', $empresa->ciudad ?? '') }}" required>
</div>

<div class="field-row">
    <div class="field">
        <label class="label" for="email_contacto">Email de contacto</label>
        <input class="control" type="email" id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $empresa->email_contacto ?? '') }}" required>
    </div>

    <div class="field">
        <label class="label" for="telefono_contacto">Teléfono de contacto</label>
        <input
            class="control"
            type="tel"
            id="telefono_contacto"
            name="telefono_contacto"
            value="{{ old('telefono_contacto', $empresa->telefono_contacto ?? '') }}"
            inputmode="tel"
            pattern="^\+?[0-9\s\-()]{9,20}$"
            placeholder="Ej. 965000111 o +34965000111"
            required
        >
        <div class="help">Se admiten 9 a 15 dígitos. Puedes escribir espacios o guiones; el sistema los normaliza.</div>
    </div>
</div>

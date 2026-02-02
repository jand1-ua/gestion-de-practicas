@php
    $empresa = $empresa ?? new \App\Models\Empresa();
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
        <input class="control" type="text" id="sector" name="sector" value="{{ old('sector', $empresa->sector ?? '') }}" required>
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
        <input class="control" type="text" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $empresa->telefono_contacto ?? '') }}" required>
    </div>
</div>

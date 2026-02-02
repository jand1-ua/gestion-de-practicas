@php
    $tutor = $tutor ?? new \App\Models\Tutor();
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
        <input class="control" type="text" id="telefono" name="telefono" value="{{ old('telefono', $tutor->telefono ?? '') }}" required>
    </div>
</div>

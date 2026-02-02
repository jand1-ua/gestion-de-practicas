@php
    $alumno = $alumno ?? new \App\Models\Alumno();
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
        <input class="control" type="text" id="grado" name="grado" value="{{ old('grado', $alumno->grado ?? '') }}" required>
    </div>
</div>

<div class="field">
    <label class="label" for="curso">Curso</label>
    <input class="control" type="text" id="curso" name="curso" value="{{ old('curso', $alumno->curso ?? '') }}" required>
    <div class="help">Ejemplo: 3º, 4º, Máster…</div>
</div>

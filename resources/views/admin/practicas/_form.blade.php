@php
    $practica = $practica ?? new \App\Models\Practica();
@endphp

@if ($errors->any())
    <div style="border:1px solid red; padding:10px; margin-bottom:15px;">
        <p><strong>Se han encontrado errores:</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="margin-bottom: 10px;">
    <label for="alumno_id">Alumno:</label><br>
    <select name="alumno_id" id="alumno_id" required>
        <option value="">-- Selecciona un alumno --</option>
        @foreach ($alumnos as $alumno)
            <option value="{{ $alumno->id }}"
                {{ old('alumno_id', $practica->alumno_id) == $alumno->id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom: 10px;">
    <label for="empresa_id">Empresa:</label><br>
    <select name="empresa_id" id="empresa_id" required>
        <option value="">-- Selecciona una empresa --</option>
        @foreach ($empresas as $empresa)
            <option value="{{ $empresa->id }}"
                {{ old('empresa_id', $practica->empresa_id) == $empresa->id ? 'selected' : '' }}>
                {{ $empresa->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom: 10px;">
    <label for="tutor_id">Tutor:</label><br>
    <select name="tutor_id" id="tutor_id">
        <option value="">-- Sin tutor asignado --</option>
        @foreach ($tutores as $tutor)
            <option value="{{ $tutor->id }}"
                {{ old('tutor_id', $practica->tutor_id) == $tutor->id ? 'selected' : '' }}>
                {{ $tutor->nombre }}
                @if($tutor->empresa)
                    ({{ $tutor->empresa->nombre }})
                @endif
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom: 10px;">
    <label for="estado">Estado:</label><br>
    @php
        $estados = ['pendiente', 'en curso', 'finalizada'];
    @endphp

    <select name="estado" id="estado" required>
        @foreach ($estados as $estado)
            <option value="{{ $estado }}"
                {{ old('estado', $practica->estado ?? 'pendiente') == $estado ? 'selected' : '' }}>
                {{ ucfirst($estado) }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-bottom: 10px;">
    <label for="fecha_inicio">Fecha inicio:</label><br>
    <input type="date" name="fecha_inicio" id="fecha_inicio"
           value="{{ old('fecha_inicio', $practica->fecha_inicio) }}" required>
</div>

<div style="margin-bottom: 10px;">
    <label for="fecha_fin">Fecha fin:</label><br>
    <input type="date" name="fecha_fin" id="fecha_fin"
           value="{{ old('fecha_fin', $practica->fecha_fin) }}">
</div>

<div style="margin-bottom: 10px;">
    <label for="observaciones">Observaciones:</label><br>
    <textarea name="observaciones" id="observaciones" rows="4" style="width:100%;">{{ old('observaciones', $practica->observaciones) }}</textarea>
</div>

<div style="margin-top: 15px;">
    <button type="submit">Guardar</button>
</div>

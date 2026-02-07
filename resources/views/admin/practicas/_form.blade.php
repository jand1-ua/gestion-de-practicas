@php
    $practica = $practica ?? new \App\Models\Practica();

    $estados = [
        'pendiente'  => 'Pendiente',
        'en_curso'   => 'En curso',
        'finalizada' => 'Finalizada',
    ];
@endphp

@csrf

<div class="field-row">
    <div class="field">
        <label class="label" for="alumno_id">Alumno</label>
        <select class="select" name="alumno_id" id="alumno_id" required>
            <option value="">-- Selecciona un alumno --</option>
            @foreach ($alumnos as $alumno)
                <option value="{{ $alumno->id }}" @selected((string) old('alumno_id', $practica->alumno_id) === (string) $alumno->id)>
                    {{ $alumno->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label class="label" for="empresa_id">Empresa</label>
        <select class="select" id="empresa_id" disabled>
            <option value="">-- Selecciona una empresa --</option>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}" @selected((string) old('empresa_id', $practica->empresa_id) === (string) $empresa->id)>
                    {{ $empresa->nombre }}
                </option>
            @endforeach
        </select>
        <input type="hidden" name="empresa_id" id="empresa_id_hidden" value="{{ old('empresa_id', $practica->empresa_id) }}">
    </div>
</div>

<div class="field">
    <label class="label" for="tutor_id">Tutor</label>
    <select class="select" name="tutor_id" id="tutor_id" required>
        <option value="">-- Selecciona un tutor --</option>
        @foreach ($tutores as $tutor)
            <option value="{{ $tutor->id }}"
                    data-empresa-id="{{ $tutor->empresa_id }}"
                    @selected((string) old('tutor_id', $practica->tutor_id) === (string) $tutor->id)>
                {{ $tutor->nombre }}@if($tutor->empresa) ({{ $tutor->empresa->nombre }})@endif
            </option>
        @endforeach
    </select>
</div>

<div class="field-row">
    <div class="field">
        <label class="label" for="estado">Estado</label>
        <select class="select" name="estado" id="estado" required>
            @foreach ($estados as $value => $label)
                <option value="{{ $value }}" @selected(old('estado', $practica->estado ?? 'pendiente') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label class="label" for="fecha_inicio">Fecha inicio</label>
        <input class="control" type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $practica->fecha_inicio) }}" required>
    </div>
</div>

<div class="field">
    <label class="label" for="fecha_fin">Fecha fin <span class="muted-2">(opcional)</span></label>
    <input class="control" type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $practica->fecha_fin) }}">
</div>

<div class="field">
    <label class="label" for="observaciones">Observaciones <span class="muted-2">(opcional)</span></label>
    <textarea class="textarea" name="observaciones" id="observaciones" rows="4" placeholder="Notas, situación del convenio, etc.">{{ old('observaciones', $practica->observaciones) }}</textarea>
    <div class="help">Máximo 1000 caracteres.</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tutorSelect = document.getElementById('tutor_id');
  const empresaSelect = document.getElementById('empresa_id');
  const empresaHidden = document.getElementById('empresa_id_hidden');

  if (!tutorSelect || !empresaSelect || !empresaHidden) return;

  const syncEmpresa = () => {
    const opt = tutorSelect.options[tutorSelect.selectedIndex];
    const empresaId = opt ? opt.dataset.empresaId : '';
    if (empresaId) {
      empresaSelect.value = empresaId;
      empresaHidden.value = empresaId;
    } else {
      empresaSelect.value = '';
      empresaHidden.value = '';
    }
  };

  tutorSelect.addEventListener('change', syncEmpresa);
  syncEmpresa();
});
</script>
@endpush

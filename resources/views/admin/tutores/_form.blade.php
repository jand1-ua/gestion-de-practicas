@csrf

<div>
    <label>Empresa</label><br>
    <select name="empresa_id" style="width:100%;">
        <option value="">-- Selecciona una empresa --</option>
        @foreach($empresas as $empresa)
            <option value="{{ $empresa->id }}"
                {{ (int) old('empresa_id', $tutor->empresa_id ?? 0) === $empresa->id ? 'selected' : '' }}>
                {{ $empresa->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div style="margin-top:8px;">
    <label>Nombre</label><br>
    <input type="text" name="nombre" style="width:100%;"
           value="{{ old('nombre', $tutor->nombre ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Email</label><br>
    <input type="email" name="email" style="width:100%;"
           value="{{ old('email', $tutor->email ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Teléfono</label><br>
    <input type="text" name="telefono" style="width:100%;"
           value="{{ old('telefono', $tutor->telefono ?? '') }}">
</div>

@if ($errors->any())
    <div style="margin-top:10px;color:darkred;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

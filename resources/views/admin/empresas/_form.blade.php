@csrf

<div>
    <label>Nombre</label><br>
    <input type="text" name="nombre" style="width:100%;"
           value="{{ old('nombre', $empresa->nombre ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>CIF</label><br>
    <input type="text" name="cif" style="width:100%;"
           value="{{ old('cif', $empresa->cif ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Sector</label><br>
    <input type="text" name="sector" style="width:100%;"
           value="{{ old('sector', $empresa->sector ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Ciudad</label><br>
    <input type="text" name="ciudad" style="width:100%;"
           value="{{ old('ciudad', $empresa->ciudad ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Email de contacto</label><br>
    <input type="email" name="email_contacto" style="width:100%;"
           value="{{ old('email_contacto', $empresa->email_contacto ?? '') }}">
</div>

<div style="margin-top:8px;">
    <label>Teléfono de contacto</label><br>
    <input type="text" name="telefono_contacto" style="width:100%;"
           value="{{ old('telefono_contacto', $empresa->telefono_contacto ?? '') }}">
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

@csrf

<div>
    <label>Nombre</label><br>
    <input type="text" name="nombre" style="width: 100%;"
           value="{{ old('nombre', $alumno->nombre ?? '') }}">
</div>

<div style="margin-top: 8px;">
    <label>Email</label><br>
    <input type="email" name="email" style="width: 100%;"
           value="{{ old('email', $alumno->email ?? '') }}">
</div>

<div style="margin-top: 8px;">
    <label>Grado</label><br>
    <input type="text" name="grado" style="width: 100%;"
           value="{{ old('grado', $alumno->grado ?? '') }}">
</div>

<div style="margin-top: 8px;">
    <label>Curso</label><br>
    <input type="text" name="curso" style="width: 100%;"
           value="{{ old('curso', $alumno->curso ?? '') }}">
</div>

@if ($errors->any())
    <div style="margin-top: 10px; color: darkred;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

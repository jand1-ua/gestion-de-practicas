<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje</title>
</head>
<body>
    <h1>Nuevo mensaje</h1>

    <p><a href="{{ route('mensajes.index') }}">Volver a mensajería</a></p>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Se han encontrado errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mensajes.store') }}">
        @csrf

        {{-- Destinatario --}}
        <div>
            <label for="destinatario_id">Destinatario</label><br>
            <select name="destinatario_id" id="destinatario_id">
                <option value="">-- Selecciona un usuario --</option>
                @foreach($destinatarios as $dest)
                    <option value="{{ $dest->id }}"
                        @selected(old('destinatario_id', $destinatarioId ?? '') == $dest->id)>
                        {{ $dest->name }} ({{ $dest->role }})
                    </option>
                @endforeach
            </select>
            @error('destinatario_id')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Asunto (opcional) --}}
        <div style="margin-top: 10px;">
            <label for="asunto">Asunto (opcional)</label><br>
            <input type="text"
                   name="asunto"
                   id="asunto"
                   value="{{ old('asunto') }}"
                   style="width: 100%;">
            @error('asunto')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Cuerpo / Mensaje --}}
        <div style="margin-top: 10px;">
            <label for="cuerpo">Mensaje</label><br>
            <textarea name="cuerpo"
                      id="cuerpo"
                      rows="6"
                      style="width: 100%;">{{ old('cuerpo') }}</textarea>
            @error('cuerpo')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Enviar mensaje</button>
        </div>
    </form>
</body>
</html>

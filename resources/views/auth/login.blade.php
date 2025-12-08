<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar sesión</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f5f5;
            margin: 0;
        }
        main {
            max-width: 420px;
            margin: 60px auto;
            padding: 24px 20px 32px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        h1 { margin-top: 0; }
        label { display: block; margin-top: 12px; }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 6px 8px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        .error {
            color: #b71c1c;
            font-size: .9rem;
            margin-top: 4px;
        }
        button {
            margin-top: 16px;
            padding: 8px 14px;
            background: #c62828;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #b71c1c;
        }
        a {
            color: #c62828;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<main>
    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
        >

        <label for="password">Contraseña</label>
        <input
            id="password"
            type="password"
            name="password"
            required
        >

        <label style="margin-top:8px;">
            <input type="checkbox" name="remember" value="1">
            Recordar sesión
        </label>

        <button type="submit">Entrar</button>
    </form>

    <p style="margin-top: 1rem;">
        <a href="{{ url('/') }}">Volver a inicio</a>
    </p>
</main>
</body>
</html>

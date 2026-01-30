<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $route = $this->redirectRouteFor(Auth::user()->role);

            // Si el rol no está reconocido, evitamos bucle: cerramos sesión y mostramos login
            if ($route === 'login') {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return view('auth.login')->withErrors([
                    'email' => 'Tu rol no está configurado correctamente. Contacta con el coordinador.'
                ]);
            }

            return redirect()->route($route);
        }

        return view('auth.login');
    }

    /**
     * Procesar login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Las credenciales no son válidas.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $role = Auth::user()->role;
        $route = $this->redirectRouteFor($role);

        // Si el rol no está reconocido, evitamos bucle y damos feedback
        if ($route === 'login') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Tu rol no está configurado correctamente. Contacta con el coordinador.'
            ]);
        }

        return redirect()->route($route);
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function redirectRouteFor(string $role): string
    {
        return 'home';
    }
}
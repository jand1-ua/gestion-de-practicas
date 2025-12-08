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
            return redirect()->route($this->redirectRouteFor(Auth::user()->role));
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
                ->withErrors([
                    'email' => 'Las credenciales no son válidas.',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $role = Auth::user()->role;

        return redirect()->route($this->redirectRouteFor($role));
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Obtener la ruta de redirección según el rol.
     */
    protected function redirectRouteFor(string $role): string
    {
        return match ($role) {
            'admin'  => 'admin.dashboard',
            'alumno' => 'area.alumno',
            'tutor'  => 'area.tutor',
            default  => 'login',
        };
    }
}

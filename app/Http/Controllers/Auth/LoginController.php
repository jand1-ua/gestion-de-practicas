<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->must_change_password) {
                return redirect()->route('password.setup.edit');
            }

            $route = $this->redirectRouteFor((string) Auth::user()->role);

            if ($route === 'login') {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return view('auth.login')->withErrors([
                    'email' => 'Tu rol no está configurado correctamente. Contacta con el coordinador.',
                ]);
            }

            return redirect()->route($route);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Las credenciales no son válidas.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        if (Auth::user()->must_change_password) {
            return redirect()
                ->route('password.setup.edit')
                ->with('info', 'Tu acceso se ha generado con una contraseña temporal. Debes cambiarla ahora.');
        }

        $route = $this->redirectRouteFor((string) Auth::user()->role);

        if ($route === 'login') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Tu rol no está configurado correctamente. Contacta con el coordinador.',
            ]);
        }

        return redirect()->route($route);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function redirectRouteFor(string $role): string
    {
        return match ($role) {
            'coordinador', 'admin' => 'area.coordinador',
            'alumno' => 'area.alumno',
            'tutor' => 'area.tutor',
            default => 'login',
        };
    }
}

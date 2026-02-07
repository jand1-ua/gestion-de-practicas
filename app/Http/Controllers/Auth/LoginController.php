<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        if (Auth::check()) {
            $route = $this->redirectRouteFor(Auth::user()->role);

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
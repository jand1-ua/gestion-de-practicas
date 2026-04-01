<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordSetupController extends Controller
{
    public function edit(): View
    {
        return view('auth.password-setup');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'password.required' => 'Debes indicar una nueva contraseña.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $user = $request->user();
        $user->password = $data['password'];
        $user->must_change_password = false;
        $user->save();

        return redirect()
            ->route($this->redirectRouteFor((string) $user->role))
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    private function redirectRouteFor(string $role): string
    {
        return match ($role) {
            'coordinador', 'admin' => 'area.coordinador',
            'alumno' => 'area.alumno',
            'tutor' => 'area.tutor',
            default => 'home',
        };
    }
}

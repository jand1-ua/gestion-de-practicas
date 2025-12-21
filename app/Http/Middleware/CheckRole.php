<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Uso en rutas:
     *   ->middleware('role:coordinador')
     *   ->middleware('role:coordinador,alumno')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Si no se han definido roles en el middleware, 403 por seguridad
        if (empty($roles)) {
            abort(403);
        }

        $userRole = $user->role === 'admin' ? 'coordinador' : $user->role;

        // Si el rol del usuario no está dentro de los permitidos → 403
        if (! in_array($userRole, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}

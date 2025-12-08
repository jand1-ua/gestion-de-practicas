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
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,alumno')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Sin usuario autenticado → 403
        if (! $user) {
            abort(403);
        }

        // Si no se han definido roles en el middleware, también 403 por seguridad
        if (empty($roles)) {
            abort(403);
        }

        // Si el rol del usuario no está dentro de los permitidos → 403
        if (! in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}

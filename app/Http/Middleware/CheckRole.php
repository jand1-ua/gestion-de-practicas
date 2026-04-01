<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (empty($roles)) {
            abort(403);
        }

        $userRole = $user->role === User::ROLE_ADMIN ? User::ROLE_COORDINADOR : $user->role;

        if (! in_array($userRole, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cet espace.');
        }

        if (! in_array($request->user()->role, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé à cet espace d\'administration.');
        }

        return $next($request);
    }
}

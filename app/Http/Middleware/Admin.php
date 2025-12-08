<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas connecté → redirection vers login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Vérifie si l'utilisateur a le rôle Admin
        if (!$user->role || strtolower($user->role->nom) !== 'admin') {
            abort(403, 'Accès refusé. Vous n’êtes pas administrateur.');
        }

        return $next($request);
    }
}

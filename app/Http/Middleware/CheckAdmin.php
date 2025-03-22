<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et est un administrateur
        if (Auth::guard('admin')->check()) {
            return $next($request); // Si c'est un admin, continuer
        }

        // Si ce n'est pas un admin, rediriger avec un message d'erreur
        return redirect()->route('welcome')->with('error', 'Accès interdit. Vous devez être un administrateur pour accéder à cette page.');
    }
}


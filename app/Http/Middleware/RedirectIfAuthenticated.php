<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('welcome'); // Modifiez '/home' selon votre logique de redirection.
            }
        }

        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            $user = Auth::user();
            dd($user->role, $user->stagiaire, $user->stagiaire ? $user->stagiaire->date_de_naissance : null);
            Log::info('Utilisateur authentifié : ', ['role' => $user->role]);

            // Si l'utilisateur est un stagiaire
            if ($user->role === 'stagiaire') {
                Log::info('Utilisateur stagiaire détecté.');
                if (!$user->stagiaire) {
                    Log::warning('Aucune relation Stagiaire trouvée pour cet utilisateur.');
                } elseif (!$user->stagiaire->date_de_naissance) {
                    Log::info('Date de naissance non définie. Redirection...');
                    return redirect()->route('stagiaire.affiche');
                }
            }
        }

        return $next($request);
    }
}

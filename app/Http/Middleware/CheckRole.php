<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, ...$roles): Response
    {
        Log::info("Middleware CheckRole appelé avec rôle : $role");
        
        $user = Auth::user();

        if (!$user)
        {
            return redirect()->route('welcome')->with('error', "Veuillez vous connecter.");
        }

        // Vérifie si le rôle de l'utilisateur correspond à l'un des rôles autorisés
        if (!in_array($user->role, array_merge([$role, $roles])))
        {
            return redirect()->route('welcome')->with('error', "Vous n'avez pas les permissions necessaires pour accéder à cette page.");
        }

        // Vérifie si l'utilisateur est un stagiaire et si la date de naissance est manquante
        if ($user->role === 'stagiaire' && !$user->stagiaire) {
            return redirect()->route('stagiaire.affiche')->with('error', "Veuillez compléter vos informations avant de continuer.");
        }

        // Si l'utilisateur est un stagiaire et que la date de naissance est manquante
        if ($user->role === 'stagiaire' && !$user->stagiaire->date_de_naissance) {
            return redirect()->route('stagiaire.affiche')->with('error', "Veuillez ajouter votre date de naissance avant de continuer.");
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PreventRequestsDuringMaintenance
{
    public function handle(Request $request, \Closure $next)
    {
        // Logique de vérification pendant la maintenance
        return $next($request);
    }
}

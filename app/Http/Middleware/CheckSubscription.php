<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        // AJOUT : Si l'utilisateur essaie d'aller sur la page tarifs ou login, on le laisse passer !
        if ($request->routeIs('tarifs') || $request->routeIs('login') || $request->routeIs('register')) {
            return $next($request);
        }

        // Si l'utilisateur n'est pas connecté ou n'est pas actif
        if (!auth()->check() || !auth()->user()->is_active) {
            return redirect()->route('tarifs')->with('error', 'Vous devez avoir un abonnement actif.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckRole Middleware
 *
 * Vérifie que l'utilisateur a le rôle requis
 *
 * Utilisation:
 * Route::middleware(['auth', 'role:admin'])->group(function () { ... })
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Vérifier que l'user est connecté
        if (!auth()->check()) {
            return redirect('/login')->withError('Authentification requise');
        }

        // Vérifier le rôle
        if (auth()->user()->role !== $role) {
            return redirect('/dashboard')
                ->withError('Vous n\'avez pas accès à cette page (rôle: ' . $role . ')');
        }

        return $next($request);
    }
}

?>

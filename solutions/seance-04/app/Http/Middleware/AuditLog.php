<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * AuditLog Middleware
 *
 * Enregistre les actions sensibles dans les logs
 * Utile pour suivre les tentatives de connexion, suppressions, etc
 */
class AuditLog
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Logger les actions sensibles
        $sensitivePaths = ['login', 'delete', 'update-role', 'profile'];

        foreach ($sensitivePaths as $path) {
            if (str_contains($request->path(), $path)) {
                Log::channel('audit')->info('Sensitive action', [
                    'user_id' => auth()->id() ?? 'guest',
                    'action' => $request->method() . ' ' . $request->path(),
                    'ip' => $request->ip(),
                    'status' => $response->status(),
                ]);
                break;
            }
        }

        return $response;
    }
}

?>

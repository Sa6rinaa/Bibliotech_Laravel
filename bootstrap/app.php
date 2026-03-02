<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Faire confiance à tous les proxies (nécessaire pour Codespaces)
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Configuration URL pour GitHub Codespaces
$app->booted(function () {
    // Détecter Codespaces depuis la variable d'environnement
    $codespaceName = getenv('CODESPACE_NAME') ?: $_SERVER['CODESPACE_NAME'] ?? null;

    if ($codespaceName) {
        $codespaceUrl = 'https://' . $codespaceName . '-8000.app.github.dev';
        URL::forceRootUrl($codespaceUrl);
        URL::forceScheme('https');
    }
});

return $app;

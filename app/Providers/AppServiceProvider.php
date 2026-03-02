<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forcer HTTPS sur Codespaces et production
        if (
            $this->app->environment('production') ||
            isset($_SERVER['CODESPACE_NAME']) ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        ) {
            URL::forceScheme('https');
        }

        // Détecter automatiquement l'URL sur Codespaces
        if (isset($_SERVER['CODESPACE_NAME'])) {
            $codespaceUrl = 'https://' . $_SERVER['CODESPACE_NAME'] . '-8000.app.github.dev';
            URL::forceRootUrl($codespaceUrl);
        }
    }
}

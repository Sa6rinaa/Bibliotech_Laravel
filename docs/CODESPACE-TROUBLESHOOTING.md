# 🚨 Dépannage Codespaces - URLs et Redirections

## 🔍 Problème Rencontré

Lors de l'utilisation de GitHub Codespaces, les liens de l'application Laravel pointaient vers `http://localhost:8000` au lieu de l'URL Codespaces `https://[votre-codespace]-8000.app.github.dev`.

### Symptômes
- ✅ Le serveur Laravel fonctionne
- ✅ L'application est accessible via l'onglet PORTS
- ❌ Les liens internes (navigation, boutons) redirigent vers `localhost:8000`
- ❌ Erreur "Ce site est inaccessible" lors des clics sur les liens

---

## 🛠️ Solution Complète

### 1️⃣ Modifier le fichier `.env`

**Problème** : `APP_URL` était configuré pour localhost

**Avant** :
```dotenv
APP_URL=http://localhost:8000
```

**Après** :
```dotenv
APP_URL=https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev
```

> ⚠️ **Important** : Remplacez `cuddly-eureka-9jw7r7j4jwhpr5` par le nom de **votre** Codespace (visible dans `$CODESPACE_NAME`)

### 2️⃣ Configurer `bootstrap/app.php`

**Problème** : Laravel ne détectait pas automatiquement l'URL Codespaces

**Solution** : Ajouter la détection automatique de Codespaces et la configuration du proxy trust

```php
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
```

**Éléments clés** :
- `$middleware->trustProxies(at: '*')` : Laravel fait confiance aux headers de proxy (X-Forwarded-*)
- Détection automatique via `$_SERVER['CODESPACE_NAME']`
- Force l'URL racine et le schéma HTTPS

### 3️⃣ Configurer `app/Providers/AppServiceProvider.php`

**Complément** : Configuration alternative dans le service provider

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
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
```

### 4️⃣ Redémarrer le Serveur Proprement

**Problème** : Le serveur continuait à utiliser l'ancienne configuration en cache

**Solution** : Script de redémarrage `restart-server.sh`

```bash
#!/bin/bash

echo "🔄 Redémarrage du serveur Laravel sur le port 8000..."

# Tuer tous les processus PHP artisan
pkill -9 -f "artisan serve" 2>/dev/null
sleep 2

# Vérifier que le port est libre
if ss -ltnp | grep -q ":8000"; then
    lsof -ti:8000 | xargs kill -9 2>/dev/null
    sleep 1
fi

# Nettoyer les caches Laravel
php artisan config:clear
php artisan cache:clear

# Démarrer le serveur sur le port 8000
php artisan serve --host=0.0.0.0 --port=8000 > /tmp/laravel-server.log 2>&1 &
SERVER_PID=$!

sleep 2

# Vérifier que le serveur est démarré
if ss -ltnp | grep -q ":8000"; then
    echo "✅ Serveur démarré avec succès sur le port 8000 (PID: $SERVER_PID)"
    echo ""
    echo "📋 Accédez à votre application via l'onglet PORTS (port 8000)"
fi
```

**Utilisation** :
```bash
chmod +x restart-server.sh
bash restart-server.sh
```

---

## 📋 Checklist de Dépannage

Suivez ces étapes dans l'ordre si les URLs ne fonctionnent pas :

- [ ] **1. Vérifier le `.env`**
  ```bash
  grep APP_URL .env
  # Doit afficher : APP_URL=https://[votre-codespace]-8000.app.github.dev
  ```

- [ ] **2. Vérifier le nom du Codespace**
  ```bash
  echo $CODESPACE_NAME
  # Affiche : cuddly-eureka-9jw7r7j4jwhpr5 (ou similaire)
  ```

- [ ] **3. Nettoyer les caches**
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan optimize:clear
  ```

- [ ] **4. Redémarrer le serveur sur le PORT 8000**
  ```bash
  pkill -9 -f "artisan serve"
  php artisan serve --host=0.0.0.0 --port=8000
  ```

- [ ] **5. Vérifier que le port écoute sur 0.0.0.0**
  ```bash
  ss -ltnp | grep :8000
  # Doit afficher : 0.0.0.0:8000 (PAS 127.0.0.1:8000)
  ```

- [ ] **6. Accéder via l'onglet PORTS**
  - Ouvrir l'onglet **PORTS** en bas de VS Code
  - Cliquer sur l'icône 🌐 du port 8000
  - **OU** copier l'URL de la colonne "Forwarded Address"

- [ ] **7. Vérifier les URLs générées**
  ```bash
  curl -sS http://127.0.0.1:8000/livres | grep -oP 'href="[^"]*(/livres|/livre/[0-9]+)"' | head -3
  ```

---

## 🔧 Comprendre le Problème

### Comment Laravel génère les URLs

Laravel utilise plusieurs sources pour déterminer l'URL de base :

1. **Headers HTTP** (priorité maximale) :
   - `X-Forwarded-Host` : Le domaine original (envoyé par Codespaces)
   - `X-Forwarded-Proto` : Le protocole (https)
   - `X-Forwarded-Port` : Le port original

2. **Configuration `.env`** :
   - `APP_URL` : URL de base par défaut

3. **Détection automatique** :
   - Laravel lit `$_SERVER['HTTP_HOST']` et `$_SERVER['REQUEST_SCHEME']`

### Pourquoi ça ne fonctionnait pas ?

1. **Pas de trust des proxies** : Laravel ignorait les headers `X-Forwarded-*` de Codespaces
2. **APP_URL localhost** : Valeur par défaut incorrecte
3. **Serveur sur 127.0.0.1** : Au lieu de `0.0.0.0`, empêchant le port forwarding
4. **Cache Laravel** : Ancienne configuration en mémoire

### Comment la solution fonctionne ?

```
Navigateur
    ↓
    URL: https://cuddly-eureka-[...]-8000.app.github.dev/livres
    ↓
Proxy Codespaces (ajoute headers X-Forwarded-*)
    ↓
    X-Forwarded-Host: cuddly-eureka-[...]-8000.app.github.dev
    X-Forwarded-Proto: https
    X-Forwarded-Port: 8000
    ↓
Laravel (avec trustProxies activé)
    ↓
    URL::current() retourne : https://cuddly-eureka-[...]-8000.app.github.dev/livres
    route('livres.show', 1) génère : https://cuddly-eureka-[...]-8000.app.github.dev/livre/1
    ↓
Vue Blade (les liens sont corrects)
```

---

## 🎯 Tests de Validation

### Test 1 : Vérifier l'URL de base
```bash
php artisan tinker --execute="echo url('/');"
# Devrait afficher : https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev
```

### Test 2 : Vérifier une route
```bash
php artisan tinker --execute="echo route('livres.show', 1);"
# Devrait afficher : https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev/livre/1
```

### Test 3 : Vérifier le serveur
```bash
ss -ltnp | grep :8000
# Devrait afficher : 0.0.0.0:8000 (PAS 127.0.0.1:8000)
```

### Test 4 : Tester depuis le navigateur
1. Ouvrir : `https://[votre-codespace]-8000.app.github.dev/livres`
2. Inspecter un lien (clic droit > Inspecter)
3. Vérifier que `href` contient l'URL Codespaces complète

---

## 🚀 Script de Démarrage Automatique

Pour éviter ce problème à l'avenir, ajoutez ce script dans `.devcontainer/setup.sh` :

```bash
#!/bin/bash

# Configuration automatique pour Codespaces
if [ -n "$CODESPACE_NAME" ]; then
    echo "🌐 Codespace détecté : $CODESPACE_NAME"
    
    # Mettre à jour APP_URL dans .env
    CODESPACE_URL="https://${CODESPACE_NAME}-8000.app.github.dev"
    
    if [ -f .env ]; then
        sed -i "s|APP_URL=.*|APP_URL=$CODESPACE_URL|g" .env
        echo "✅ APP_URL mis à jour : $CODESPACE_URL"
    fi
fi

# Installation et démarrage standard
composer install
php artisan key:generate --force
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
```

Et dans `.devcontainer/devcontainer.json` :

```json
{
  "postCreateCommand": "bash .devcontainer/setup.sh"
}
```

---

## 📚 Ressources

- [Laravel URL Generation](https://laravel.com/docs/urls)
- [Laravel Trusted Proxies](https://laravel.com/docs/requests#configuring-trusted-proxies)
- [GitHub Codespaces Port Forwarding](https://docs.github.com/en/codespaces/developing-in-codespaces/forwarding-ports-in-your-codespace)

---

## ❓ FAQ

### Pourquoi `localhost` ne fonctionne pas sur Codespaces ?

Codespaces expose votre application via un proxy avec une URL publique. `localhost` n'existe que dans le conteneur.

### Dois-je changer l'URL à chaque nouveau Codespace ?

Non ! Avec la configuration dans `bootstrap/app.php`, Laravel détecte automatiquement le nom du Codespace depuis `$CODESPACE_NAME`.

### Pourquoi utiliser `0.0.0.0` au lieu de `127.0.0.1` ?

- `127.0.0.1` : Écoute uniquement sur localhost (pas accessible depuis l'extérieur)
- `0.0.0.0` : Écoute sur toutes les interfaces réseau (permet le port forwarding)

### Les URLs fonctionnent en local mais pas sur Codespaces

Vérifiez que `trustProxies(at: '*')` est bien configuré dans `bootstrap/app.php`.

---

**✅ Avec ces modifications, vos URLs Laravel fonctionnent automatiquement sur Codespaces !**

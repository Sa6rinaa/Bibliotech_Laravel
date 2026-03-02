# 🛠️ Guide de Résolution de Problèmes - BiblioTech Laravel

> 🆘 Solutions aux erreurs les plus fréquentes

## 🚨 Erreurs d'Installation

### ❌ "php: command not found"
**Cause :** PHP n'est pas installé ou pas dans le PATH

**Solutions :**
```bash
# Windows - Installer XAMPP
# Télécharger : https://www.apachefriends.org/
# Ajouter au PATH : C:\xampp\php

# Ou installer PHP directement
# Télécharger : https://windows.php.net/download/
```

### ❌ "composer: command not found"  
**Cause :** Composer n'est pas installé

**Solutions :**
```bash
# Windows
# Télécharger : https://getcomposer.org/Composer-Setup.exe

# Vérification
composer --version    # Doit afficher Composer 2.x
```

### ❌ "Could not open input file: artisan"
**Cause :** Vous n'êtes pas dans le bon répertoire

**Solutions :**
```bash
# Vérifier le répertoire courant
pwd
ls -la    # Unix/Mac
dir       # Windows

# Aller dans le bon répertoire
cd bibliotech-laravel

# Vérifier la présence d'artisan
ls -la artisan    # Unix/Mac  
dir artisan       # Windows
```

---

## 🗄️ Erreurs de Base de Données

### ❌ "Database file does not exist"
**Cause :** Le fichier SQLite n'a pas été créé

**Solutions :**
```bash
# Windows
type nul > database\database.sqlite

# Unix/Mac
touch database/database.sqlite

# Vérifier la création
ls -la database/database.sqlite
```

### ❌ "SQLSTATE[HY000]: General error: 1 no such table"
**Cause :** Les migrations n'ont pas été exécutées

**Solutions :**
```bash
# Exécuter les migrations
php artisan migrate

# Si problème, recreer la base
del database\database.sqlite    # Windows
rm database/database.sqlite     # Unix/Mac

type nul > database\database.sqlite    # Windows
touch database/database.sqlite         # Unix/Mac

php artisan migrate
```

### ❌ "Database is locked"
**Cause :** Un processus utilise encore la base SQLite

**Solutions :**
```bash
# Arrêter le serveur Laravel
Ctrl+C

# Attendre 5 secondes, puis redémarrer
php artisan serve
```

---

## 🔑 Erreurs de Configuration

### ❌ "No application encryption key has been specified"
**Cause :** Clé d'application non générée

**Solutions :**
```bash
# Générer la clé
php artisan key:generate

# Vérifier dans .env
cat .env | grep APP_KEY    # Unix/Mac
findstr APP_KEY .env       # Windows
```

### ❌ "The stream or file could not be opened"
**Cause :** Problème de permissions sur storage/

**Solutions :**
```bash
# Windows (en tant qu'administrateur)
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T

# Unix/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### ❌ "Class 'App\Http\Controllers\...' not found"
**Cause :** Problème d'autoloading

**Solutions :**
```bash
# Régénérer l'autoloader
composer dump-autoload

# Nettoyer le cache
php artisan optimize:clear
```

---

## 🌐 Erreurs du Serveur Web

### ❌ "Address already in use (port 8000)"
**Cause :** Le port 8000 est déjà utilisé

**Solutions :**
```bash
# Utiliser un autre port
php artisan serve --port=8001
php artisan serve --port=8080
php artisan serve --port=3000

# Ou trouver qui utilise le port 8000
# Windows
netstat -ano | findstr :8000

# Unix/Mac  
lsof -i :8000

# Arrêter le processus puis redémarrer normalement
php artisan serve
```

### ❌ Page blanche ou erreur 500
**Cause :** Erreur PHP non affichée

**Solutions :**
```bash
# 1. Activer le debug dans .env
APP_DEBUG=true

# 2. Nettoyer le cache
php artisan optimize:clear

# 3. Vérifier les logs
# Windows
type storage\logs\laravel.log

# Unix/Mac
tail -f storage/logs/laravel.log

# 4. Vérifier les permissions
# (voir section permissions ci-dessus)
```

### ❌ "The page isn't working" (navigateur)
**Cause :** Serveur Laravel non démarré

**Solutions :**
```bash
# Vérifier que le serveur tourne
php artisan serve

# Doit afficher quelque chose comme :
# Laravel development server started: http://127.0.0.1:8000

# Tester l'URL exacte affichée
```

---

## 🎨 Erreurs d'Interface

### ❌ "Bootstrap ne s'affiche pas"
**Cause :** CDN Bootstrap non chargé

**Solutions :**
```html
<!-- Vérifier dans resources/views/layouts/app.blade.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
```

### ❌ "Font Awesome icons ne s'affichent pas"
**Cause :** CDN Font Awesome non chargé

**Solutions :**
```html
<!-- Ajouter dans <head> de layouts/app.blade.php -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
```

### ❌ "Illustrations CSS des livres absentes"
**Cause :** Styles CSS manquants dans layouts/app.blade.php

**Solutions :**
Vérifier la présence de ces styles dans `<head>` :
```html
<style>
.book-cover {
    width: 100%;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.book-cover-laravel {
    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
}

/* ... autres styles ... */
</style>
```

---

## ⚡ Erreurs de Performance

### ❌ "Serveur très lent"
**Cause :** Cache ou debug excessif

**Solutions :**
```bash
# Nettoyer tous les caches
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Désactiver le debug en production
# Dans .env
APP_DEBUG=false
```

### ❌ "Composer install très lent"
**Cause :** Connexion internet ou miroirs Composer

**Solutions :**
```bash
# Utiliser un miroir plus rapide
composer config -g repos.packagist composer https://packagist.org

# Ou installer sans dev dependencies
composer install --no-dev

# Ou utiliser le cache local
composer install --prefer-dist
```

---

## 🔍 Outils de Diagnostic

### 🛠️ Script de Diagnostic Automatique

Créer `diagnostic.bat` dans le dossier `scripts/` :
```batch
@echo off
echo =================================
echo   DIAGNOSTIC BIBLIOTECH LARAVEL
echo =================================
echo.

echo [1/8] Verification PHP...
php --version
if errorlevel 1 (
    echo ERREUR: PHP non trouve
    exit /b 1
)

echo [2/8] Verification Composer...  
composer --version
if errorlevel 1 (
    echo ERREUR: Composer non trouve
    exit /b 1
)

echo [3/8] Verification fichier artisan...
if not exist artisan (
    echo ERREUR: Fichier artisan absent
    echo Vous devez etre dans le repertoire bibliotech-laravel
    exit /b 1
)

echo [4/8] Verification .env...
if not exist .env (
    echo ERREUR: Fichier .env absent
    echo Executez: copy .env.example .env
    exit /b 1
)

echo [5/8] Verification base de donnees SQLite...
if not exist database\database.sqlite (
    echo ERREUR: Base SQLite absente
    echo Executez: type nul > database\database.sqlite
    exit /b 1
)

echo [6/8] Verification permissions storage...
dir storage >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Probleme acces storage
    exit /b 1
)

echo [7/8] Test routes...
php artisan route:list | findstr "livres"
if errorlevel 1 (
    echo ERREUR: Routes non configurees
    exit /b 1
)

echo [8/8] Test serveur...
echo Demarrage serveur test...
start /min php artisan serve --port=8888
timeout /t 3 >nul
curl -s http://127.0.0.1:8888 >nul
if errorlevel 1 (
    echo ATTENTION: Serveur peut avoir des problemes
) else (
    echo OK: Serveur fonctionne
)
taskkill /f /im php.exe >nul 2>&1

echo.
echo =================================
echo   DIAGNOSTIC TERMINE
echo =================================
```

### 🔧 Commandes de Debug Utiles

```bash
# Informations système
php -v
composer -V
php -m | grep pdo    # Extensions PDO

# État de Laravel
php artisan --version
php artisan route:list
php artisan config:show database

# Logs en temps réel
tail -f storage/logs/laravel.log    # Unix/Mac
Get-Content storage/logs/laravel.log -Wait    # PowerShell

# Test de connectivité base
php artisan tinker
# Puis dans tinker:
DB::connection()->getPdo();
```

---

## 📞 Ressources d'Aide

### 📖 Documentation Officielle
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Troubleshooting](https://laravel.com/docs/troubleshooting)
- [PHP Manual](https://www.php.net/manual/)

### 🌐 Communautés
- [Laravel Forums](https://laracasts.com/discuss)
- [Stack Overflow Laravel](https://stackoverflow.com/questions/tagged/laravel)
- [Reddit r/Laravel](https://www.reddit.com/r/laravel)

### 🛠️ Outils Debug
- **Laravel Debugbar** : `composer require barryvdh/laravel-debugbar`
- **Laravel Telescope** : `composer require laravel/telescope`
- **Xdebug** : Extension PHP pour debugging avancé

---

## 🆘 Aide d'Urgence

### 🚨 Réinitialisation Complète
Si tout va mal, script de réinitialisation complète :

```bash
# ATTENTION: Efface tout !
rm -rf vendor/          # Dépendances
rm -rf node_modules/    # Assets
rm database/database.sqlite  # Base de données
rm .env                 # Configuration

# Réinstaller
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

---

**🎯 La plupart des problèmes sont résolus en suivant ces étapes dans l'ordre.**

*N'hésitez pas à utiliser le script de diagnostic automatique !*
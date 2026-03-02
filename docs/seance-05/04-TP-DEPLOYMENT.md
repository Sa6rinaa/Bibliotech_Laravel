# 🚀 TP 2 - Déploiement en Production

**Durée estimée:** 120 minutes

---

## Étape 1: Préparer l'Application

### Checklist pré-déploiement

```bash
# ✅ Tester localement
php artisan test

# ✅ Nettoyer
php artisan optimize:clear
rm -rf storage/logs/*

# ✅ Vérifier .env
APP_DEBUG=false
APP_ENV=production

# ✅ Vérifier config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Créer .env.production

```env
APP_NAME=BiblioTech
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bibliotech.example.com

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/bibliotech/database/database.sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=warning
```

---

## Étape 2: Déployer sur VPS (DigitalOcean, Linode, etc.)

### 1. Setup Serveur

```bash
# SSH sur serveur
ssh root@your_server_ip

# Update système
apt update && apt upgrade -y

# Installer dépendances
apt install -y php8.3-fpm php8.3-sqlite3 php8.3-zip nginx git

# Créer user deployment
useradd -m deploy
su - deploy
```

### 2. Cloner et configurer

```bash
# Cloner repository
cd /var/www
git clone https://github.com/username/bibliotech.git
cd bibliotech

# Installer dépendances
composer install --no-dev --optimize-autoloader

# Générer key
php artisan key:generate

# Créer database
touch database/database.sqlite

# Migrations
php artisan migrate --force

# Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 3. Configurer Nginx

**Fichier:** `/etc/nginx/sites-available/bibliotech`

```nginx
server {
    listen 80;
    server_name bibliotech.example.com;
    root /var/www/bibliotech/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Activer site
sudo ln -s /etc/nginx/sites-available/bibliotech /etc/nginx/sites-enabled/

# Recharger Nginx
sudo systemctl reload nginx
```

### 4. SSL Certificate (Let's Encrypt)

```bash
# Installer Certbot
sudo apt install certbot python3-certbot-nginx -y

# Générer certificat
sudo certbot --nginx -d bibliotech.example.com

# Auto-renew
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

---

## Étape 3: Déployer sur Heroku (Plus simple)

### 1. Créer Account Heroku

```bash
# Installer Heroku CLI
curl https://cli-assets.heroku.com/install.sh | sh

# Login
heroku login

# Créer app
heroku create bibliotech-app
```

### 2. Configurer

```bash
# Ajouter buildpack PHP
heroku buildpacks:add heroku/php

# Configurer variables
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set LOG_CHANNEL=stderr

# Database SQLite sur Heroku n'est pas ideal
# Utiliser PostgreSQL à la place
heroku addons:create heroku-postgresql:hobby-dev
```

### 3. Déployer

```bash
# Push sur Heroku
git push heroku main

# Migrations
heroku run php artisan migrate

# Vérifier logs
heroku logs --tail
```

---

## Étape 4: Monitoring & Health Checks

### Créer endpoint health check

**Fichier:** `routes/web.php`

```php
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
        'app' => config('app.name'),
    ]);
});
```

### GitHub Actions: Deploy après tests

**Fichier:** `.github/workflows/deploy.yml`

```yaml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Run tests
      run: composer test
    
    - name: Deploy to Heroku
      if: success()
      uses: AkhileshThite/heroku-deploy@v3.12.12
      with:
        heroku_api_key: ${{secrets.HEROKU_API_KEY}}
        heroku_app_name: ${{secrets.HEROKU_APP_NAME}}
        heroku_email: ${{secrets.HEROKU_EMAIL}}
```

---

## Étape 5: Vérifier Déploiement

```bash
# Test endpoint
curl https://bibliotech.example.com/health

# Vérifier logs
# Pour Heroku: heroku logs --tail
# Pour VPS: tail -f /var/log/nginx/error.log

# Test fonctionnalité
# Ouvrir https://bibliotech.example.com
# Créer compte
# Se connecter
# Consulter livres
```

---

## ✅ Checklist Déploiement

- [ ] Tests passent
- [ ] APP_DEBUG=false
- [ ] Database crée et migrated
- [ ] SSL/HTTPS configuré
- [ ] Domain pointant vers serveur
- [ ] Health check retourne 200 OK
- [ ] Logs accessibles
- [ ] Backups configurés

---

Prêt pour les exercices ? 💪 → [05-TP-PRATIQUE-EXERCICES.md](05-TP-PRATIQUE-EXERCICES.md)

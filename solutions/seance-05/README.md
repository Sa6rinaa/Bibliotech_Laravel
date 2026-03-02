# 🎓 Solution - Séance 5: Production & Déploiement

**Durée:** 7 heures  
**Compétences:** Tests automatisés, CI/CD, Déploiement, Monitoring, Sécurité production  

---

## 📁 Structure des Solutions

```
solutions/seance-05/
├── README.md (ce fichier)
├── tests/
│   ├── Feature/
│   │   ├── LivreTest.php (Tests routes livres)
│   │   ├── CategorieTest.php (Tests routes catégories)
│   │   └── AuthTest.php (Tests authentification)
│   └── Unit/
│       ├── LivreModelTest.php (Tests modèle)
│       └── UserModelTest.php (Tests utilisateur)
├── .github/
│   └── workflows/
│       └── laravel.yml (CI/CD pipeline)
├── deployment/
│   ├── deploy.sh (Script déploiement)
│   ├── .env.production (Config production template)
│   └── nginx.conf (Config serveur web)
└── monitoring/
    ├── sentry-setup.md (Configuration Sentry)
    └── logs-config.md (Configuration logs)
```

---

## 🎯 Concepts Clés Appliqués

### 1️⃣ Tests Automatisés
- Tests unitaires avec PHPUnit
- Tests Feature pour routes et contrôleurs
- Factories et Seeders pour données de test
- Assertions : `assertStatus()`, `assertSee()`, `assertDatabaseHas()`
- Coverage de code

### 2️⃣ CI/CD avec GitHub Actions
- Pipeline automatisé sur push
- Exécution des tests
- Vérification code quality
- Déploiement automatique si tests passent

### 3️⃣ Configuration Production
- Variables d'environnement `.env`
- Optimisations : `php artisan optimize`
- Caches : config, routes, views
- `APP_DEBUG=false` en production
- HTTPS obligatoire

### 4️⃣ Déploiement
- Préparation serveur (LAMP/LEMP)
- Configuration nginx/Apache
- Migrations en production
- Rollback strategy
- Zero-downtime deployment

### 5️⃣ Monitoring & Logging
- Logs Laravel (storage/logs)
- Error tracking avec Sentry
- Performance monitoring
- Alertes automatiques
- Métriques applicatives

---

## ✅ Auto-Évaluation

### Niveau 1 - Tests Basiques (Essentiel)
- [ ] Je sais créer un test avec `php artisan make:test`
- [ ] Je comprends la différence entre Unit et Feature tests
- [ ] Je sais tester une route avec `$this->get('/route')`
- [ ] Je sais vérifier le status HTTP avec `assertStatus(200)`
- [ ] Je sais vérifier le contenu avec `assertSee('texte')`
- [ ] Je sais tester la base de données avec `assertDatabaseHas()`
- [ ] Je sais exécuter les tests avec `php artisan test`
- [ ] Je comprends le concept de coverage

**Validation:** Écrire 5 tests Feature pour les routes principales

### Niveau 2 - Production & CI/CD (Important)
- [ ] Je sais configurer GitHub Actions pour Laravel
- [ ] Je sais créer un workflow qui exécute les tests
- [ ] Je comprends les variables d'environnement de production
- [ ] Je sais désactiver APP_DEBUG en production
- [ ] Je sais optimiser l'application avec `optimize`
- [ ] Je sais créer les caches (config, routes, views)
- [ ] Je sais déployer sur un serveur (FTP, SSH, Git)
- [ ] Je comprends la différence entre staging et production

**Validation:** Configurer un pipeline CI/CD complet avec GitHub Actions

### Niveau 3 - Monitoring & Sécurité (Bonus)
- [ ] Je sais intégrer Sentry pour l'error tracking
- [ ] Je comprends comment monitorer les performances
- [ ] Je sais configurer les logs par channel
- [ ] Je sais mettre en place des sauvegardes automatiques
- [ ] Je comprends le versioning avec Git tags
- [ ] Je sais créer un processus de rollback
- [ ] Je sais configurer HTTPS avec Let's Encrypt
- [ ] Je comprends les stratégies de déploiement avancées

**Validation:** Déployer en production avec monitoring et HTTPS

---

## 🧪 Exemples de Tests

### Test Feature - Route Index
```php
<?php

namespace Tests\Feature;

use App\Models\Livre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_displays_livres_index_page()
    {
        // Arrange
        $livre = Livre::factory()->create([
            'titre' => 'Test Laravel'
        ]);
        
        // Act
        $response = $this->get(route('livres.index'));
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Test Laravel');
        $response->assertViewIs('livres.index');
    }
    
    /** @test */
    public function it_can_create_a_livre()
    {
        // Arrange
        $data = [
            'titre' => 'Nouveau Livre',
            'auteur' => 'Auteur Test',
            'annee_publication' => 2024,
            'categorie_id' => 1
        ];
        
        // Act
        $response = $this->post(route('livres.store'), $data);
        
        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('livres', [
            'titre' => 'Nouveau Livre'
        ]);
    }
    
    /** @test */
    public function it_validates_required_fields()
    {
        // Arrange
        $data = ['titre' => '']; // Titre vide
        
        // Act
        $response = $this->post(route('livres.store'), $data);
        
        // Assert
        $response->assertSessionHasErrors(['titre', 'auteur']);
    }
}
```

### Test Unit - Model
```php
<?php

namespace Tests\Unit;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreModelTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_livre_belongs_to_a_categorie()
    {
        $categorie = Categorie::factory()->create();
        $livre = Livre::factory()->create([
            'categorie_id' => $categorie->id
        ]);
        
        $this->assertInstanceOf(Categorie::class, $livre->categorie);
        $this->assertEquals($categorie->id, $livre->categorie->id);
    }
    
    /** @test */
    public function it_can_get_titre_en_majuscules()
    {
        $livre = Livre::factory()->create([
            'titre' => 'test livre'
        ]);
        
        $this->assertEquals('TEST LIVRE', $livre->titre_majuscules);
    }
}
```

---

## 🚀 CI/CD avec GitHub Actions

### Fichier `.github/workflows/laravel.yml`
```yaml
name: Laravel Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, pdo, pdo_sqlite
        
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
      
    - name: Install Dependencies
      run: composer install --prefer-dist --no-progress
      
    - name: Generate key
      run: php artisan key:generate
      
    - name: Create Database
      run: |
        mkdir -p database
        touch database/database.sqlite
        
    - name: Run Migrations
      run: php artisan migrate
      
    - name: Execute tests
      run: php artisan test --coverage
      
    - name: Upload coverage
      uses: codecov/codecov-action@v3
      with:
        files: ./coverage.xml
```

---

## 📦 Script de Déploiement

### `deployment/deploy.sh`
```bash
#!/bin/bash

echo "🚀 Déploiement BiblioTech"

# 1. Mode maintenance
php artisan down

# 2. Git pull
git pull origin main

# 3. Installer dépendances
composer install --no-dev --optimize-autoloader

# 4. Migrations
php artisan migrate --force

# 5. Clear & Recache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Optimisations
php artisan optimize

# 7. Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 8. Désactiver mode maintenance
php artisan up

echo "✅ Déploiement terminé !"
```

### Utilisation
```bash
chmod +x deployment/deploy.sh
./deployment/deploy.sh
```

---

## 🔐 Configuration Production

### `.env.production` (Template)
```env
APP_NAME="BiblioTech"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://bibliotech.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotech_prod
DB_USERNAME=bibliotech_user
DB_PASSWORD=STRONG_PASSWORD_HERE

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@bibliotech.com"
MAIL_FROM_NAME="${APP_NAME}"

# Sentry Error Tracking
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@sentry.io/12345
```

---

## 🌐 Configuration Nginx

### `deployment/nginx.conf`
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name bibliotech.com www.bibliotech.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name bibliotech.com www.bibliotech.com;
    root /var/www/bibliotech/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/bibliotech.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/bibliotech.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🚀 Extensions Possibles

### Extension 1: Tests End-to-End avec Laravel Dusk
**Objectif:** Tester l'application avec un navigateur automatisé

**Installation:**
```bash
composer require --dev laravel/dusk
php artisan dusk:install
```

**Exemple de test:**
```php
<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LivreTest extends DuskTestCase
{
    /** @test */
    public function user_can_create_a_livre()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/livres/create')
                    ->type('titre', 'Nouveau Livre Dusk')
                    ->type('auteur', 'Auteur Dusk')
                    ->press('Enregistrer')
                    ->assertPathIs('/livres')
                    ->assertSee('Nouveau Livre Dusk');
        });
    }
}
```

---

### Extension 2: Monitoring avec Sentry
**Objectif:** Tracker les erreurs en production automatiquement

**Installation:**
```bash
composer require sentry/sentry-laravel
php artisan sentry:publish --dsn=YOUR_SENTRY_DSN
```

**Configuration (config/sentry.php):**
```php
'dsn' => env('SENTRY_LARAVEL_DSN'),
'environment' => env('APP_ENV', 'production'),
'release' => env('SENTRY_RELEASE'),
'send_default_pii' => true,
```

**Utilisation:**
```php
try {
    // Code risqué
} catch (\Exception $e) {
    \Sentry\captureException($e);
    throw $e;
}
```

---

### Extension 3: Déploiement Blue-Green
**Objectif:** Déploiement sans interruption de service

**Concept:**
```
Production actuelle : /var/www/app-blue (actif)
Nouvelle version    : /var/www/app-green (préparation)

1. Déployer dans app-green
2. Tester app-green
3. Basculer le serveur web vers app-green
4. app-green devient actif
5. app-blue reste en backup (rollback facile)
```

**Script:**
```bash
#!/bin/bash

CURRENT=$(readlink /var/www/app)
if [ "$CURRENT" == "/var/www/app-blue" ]; then
    NEW="/var/www/app-green"
else
    NEW="/var/www/app-blue"
fi

echo "Déploiement dans $NEW"

# Déployer dans NEW
cd $NEW
git pull
composer install --no-dev
php artisan migrate --force
php artisan optimize

# Basculer
ln -sfn $NEW /var/www/app
sudo systemctl reload nginx

echo "✅ Déploiement terminé vers $NEW"
```

---

### Extension 4: Performance Monitoring
**Objectif:** Monitorer les performances en temps réel

**Installation Laravel Telescope:**
```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

**Configuration (app/Providers/TelescopeServiceProvider.php):**
```php
protected function gate()
{
    Gate::define('viewTelescope', function ($user) {
        return in_array($user->email, [
            'admin@bibliotech.com',
        ]);
    });
}
```

**Accès:** https://bibliotech.com/telescope

---

### Extension 5: Docker & Containerisation
**Objectif:** Packager l'application dans un container

**Dockerfile:**
```dockerfile
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
```

**docker-compose.yml:**
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: bibliotech_app
    volumes:
      - .:/var/www
    networks:
      - bibliotech

  nginx:
    image: nginx:alpine
    container_name: bibliotech_nginx
    ports:
      - "80:80"
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - .:/var/www
    networks:
      - bibliotech

  db:
    image: mysql:8.0
    container_name: bibliotech_db
    environment:
      MYSQL_DATABASE: bibliotech
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - bibliotech

networks:
  bibliotech:
    driver: bridge

volumes:
  dbdata:
```

---

## 📊 Checklist Finale

**Tests:**
- [ ] Tests Feature pour toutes les routes principales
- [ ] Tests Unit pour les modèles
- [ ] Coverage > 70%
- [ ] Tests passent localement et en CI

**CI/CD:**
- [ ] GitHub Actions configuré
- [ ] Pipeline exécute les tests automatiquement
- [ ] Déploiement automatique après succès des tests
- [ ] Notifications en cas d'échec

**Production:**
- [ ] APP_DEBUG=false
- [ ] HTTPS configuré (Let's Encrypt)
- [ ] Caches optimisés (config, routes, views)
- [ ] Variables d'environnement sécurisées
- [ ] Permissions correctes (755 storage)

**Monitoring:**
- [ ] Logs accessibles et organisés
- [ ] Error tracking configuré (Sentry)
- [ ] Alertes automatiques en cas d'erreur
- [ ] Métriques de performance suivies

**Bonus:**
- [ ] Tests E2E avec Dusk
- [ ] Blue-Green deployment
- [ ] Docker containerisation
- [ ] Performance monitoring (Telescope)
- [ ] Sauvegardes automatiques

---

## 🎓 Ressources Complémentaires

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [GitHub Actions for Laravel](https://github.com/marketplace/actions/setup-php-action)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Nginx Configuration for Laravel](https://laravel.com/docs/deployment#nginx)
- [Laravel Forge](https://forge.laravel.com/) - Déploiement simplifié
- [Sentry for Laravel](https://docs.sentry.io/platforms/php/guides/laravel/)
- [Laravel Telescope](https://laravel.com/docs/telescope)

---

**🎉 Félicitations ! Vous maîtrisez maintenant le déploiement d'une application Laravel en production.**

**Vous savez désormais :**
- ✅ Écrire des tests automatisés
- ✅ Configurer un pipeline CI/CD
- ✅ Déployer en production de manière sécurisée
- ✅ Monitorer et maintenir une application
- ✅ Gérer le cycle de vie complet d'une application Laravel

**Le parcours BiblioTech est terminé ! 🚀**

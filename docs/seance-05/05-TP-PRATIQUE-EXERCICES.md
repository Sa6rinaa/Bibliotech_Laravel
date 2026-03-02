# 💪 TP 3 - Exercices Pratiques Finaux

**Durée estimée:** 120 minutes

---

## 🎯 Exercice 1: Suite de Tests Complète

Créer une suite de 50+ tests couvrant toute l'app

### Fichiers à générer

```
tests/Feature/
  ├── AuthTest.php (8 tests)
  ├── LivreTest.php (10 tests)
  ├── CategorieTest.php (5 tests)
  └── DashboardTest.php (7 tests)

tests/Unit/
  ├── UserTest.php (8 tests)
  └── LivreTest.php (6 tests)
```

### Code exemple complet

**tests/Feature/LivreTest.php**

```php
<?php

namespace Tests\Feature;

use App\Models\Livre;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_livre_index_loads(): void
    {
        Livre::factory(5)->create();
        $response = $this->get('/livres');
        $response->assertStatus(200);
    }

    public function test_livre_show_displays_details(): void
    {
        $livre = Livre::factory()->create(['titre' => 'Test Book']);
        $response = $this->get("/livre/{$livre->id}");
        $response->assertStatus(200);
        $response->assertSee('Test Book');
    }

    public function test_search_returns_results(): void
    {
        Livre::factory()->create(['titre' => 'Laravel Guide']);
        $response = $this->get('/recherche?q=Laravel');
        $response->assertStatus(200);
    }

    public function test_fake_livre_id_returns_404(): void
    {
        $response = $this->get('/livre/9999');
        $response->assertStatus(404);
    }

    public function test_authenticated_user_can_borrow(): void
    {
        $user = Utilisateur::factory()->create();
        $livre = Livre::factory()->create();

        $response = $this->actingAs($user)->post("/livre/{$livre->id}/borrow");
        $response->assertRedirect();
        $this->assertDatabaseHas('emprunts', [
            'user_id' => $user->id,
            'livre_id' => $livre->id,
        ]);
    }
}
```

---

## 🎯 Exercice 2: GitHub Actions Pipeline

Configurer CI/CD complète

### Étapes:
1. ✅ Tests automatiques
2. ✅ Code coverage
3. ✅ Build artifacts
4. ✅ Deploy to staging
5. ✅ Smoke tests
6. ✅ Deploy to production

**Fichier:** `.github/workflows/ci-cd.yml`

```yaml
name: CI/CD Pipeline

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      
      - name: Install dependencies
        run: composer install
      
      - name: Run tests
        run: php artisan test --coverage
      
      - name: Upload coverage
        uses: codecov/codecov-action@v3

  deploy:
    needs: test
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main' && github.event_name == 'push'
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Deploy to production
        run: |
          # Script déploiement
          curl -X POST ${{ secrets.DEPLOY_WEBHOOK }}
```

---

## 🎯 Exercice 3: Monitoring & Alertes

Setup monitoring complet

### Sentry (Error Tracking)

```bash
# 1. Créer compte: https://sentry.io

# 2. Installer
composer require sentry/sentry-laravel

# 3. Configurer .env
SENTRY_LARAVEL_DSN=https://xxxxx@sentry.io/xxxxx

# 4. Test
\Sentry\captureMessage('Test message', 'info');
```

### Logs Aggregation

```bash
# Avec Papertrail (SaaS)
# 1. Créer account
# 2. Configurer syslog
# 3. Logs automatiquement envoyés

# Ou ELK Stack (self-hosted)
# Elasticsearch + Logstash + Kibana
```

### Health Check Script

```php
// routes/web.php
Route::get('/health/deep', function () {
    $checks = [
        'database' => \DB::connection()->pdo ? 'OK' : 'FAILED',
        'cache' => \Cache::put('health', 'ok') ? 'OK' : 'FAILED',
        'storage' => is_writable(storage_path()) ? 'OK' : 'FAILED',
    ];
    
    $status = collect($checks)->every(fn($v) => $v === 'OK') ? 200 : 500;
    return response()->json($checks, $status);
});
```

---

## 🎯 Exercice 4: Documentation Complète

Créer README production-ready

### README.md structure

```md
# BiblioTech - Laravel Application

## Installation
## Configuration
## Running Tests
## Deployment
## Monitoring
## Troubleshooting
## Contributing
```

### DEPLOYMENT.md

```md
# Deployment Guide

## Prerequisites
## Setup
## CI/CD Pipeline
## Rollback Procedure
## Monitoring
## Support
```

---

## 🎯 Exercice 5: Perf & Optimization

Optimiser performance production

### Optimisations

```bash
# 1. Cache config
php artisan config:cache

# 2. Cache routes
php artisan route:cache

# 3. Cache views
php artisan view:cache

# 4. Autoloader optimize
composer install --optimize-autoloader --no-dev

# 5. Queue jobs async
php artisan queue:work
```

### Benchmarks

```php
// Tester performance
php artisan tinker

>>> foreach(range(1, 100) as $i) {
  Livre::create(['titre' => "Livre $i"]);
}

>>> $start = microtime(true);
>>> Livre::all();
>>> $end = microtime(true);
>>> dd($end - $start); // Afficher temps
```

---

## ✅ Checklist Finale

- [ ] 50+ tests écrits
- [ ] 80%+ code coverage
- [ ] GitHub Actions configuré
- [ ] Staging environment setup
- [ ] Production deployment réussi
- [ ] Monitoring actif
- [ ] Alertes configurées
- [ ] Documentation complète
- [ ] Rollback procedure testée
- [ ] Performance benchmarks

---

Prêt pour l'évaluation finale ? 📊 → [06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md)

# 🧪 TP 1 - Tests Automatisés & CI/CD

**Durée estimée:** 90 minutes

---

## Étape 1: Configuration Tests

### Tests Directory Structure
```
tests/
├── Feature/        # Route tests
│   ├── AuthTest.php
│   ├── LivreTest.php
│   └── DashboardTest.php
└── Unit/           # Model tests
    ├── UserTest.php
    └── LivreTest.php
```

### phpunit.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/bin/phpunit.xsd"
         bootstrap="tests/Pest.php"
         colors="true">
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="DB_CONNECTION" value="sqlite"/>
    </php>
</phpunit>
```

---

## Étape 2: Feature Tests

### Test Authentication

**Fichier:** `tests/Feature/AuthTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => 'Password123']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
```

### Test Routes

**Fichier:** `tests/Feature/LivreTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\Livre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_livres_page_loads(): void
    {
        $response = $this->get('/livres');
        $response->assertStatus(200);
    }

    public function test_livre_detail_loads(): void
    {
        $livre = Livre::factory()->create();
        
        $response = $this->get("/livre/{$livre->id}");
        $response->assertStatus(200);
        $response->assertSee($livre->titre);
    }

    public function test_can_search_livres(): void
    {
        Livre::factory(3)->create(['titre' => 'Laravel']);
        
        $response = $this->get('/recherche?q=Laravel');
        $response->assertStatus(200);
    }
}
```

---

## Étape 3: Unit Tests

### Test Model

**Fichier:** `tests/Unit/UserTest.php`

```php
<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_admin_method(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());
    }

    public function test_user_has_bibliothecaire_method(): void
    {
        $biblio = User::create([
            'name' => 'Biblio',
            'email' => 'biblio@test.com',
            'password' => 'password',
            'role' => 'bibliothécaire',
        ]);

        $this->assertTrue($biblio->isBibliothécaire());
    }
}
```

---

## Étape 4: GitHub Actions Pipeline

### Créer workflow

**Fichier:** `.github/workflows/tests.yml`

```yaml
name: Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: sqlite

    - name: Install dependencies
      run: composer install --no-progress --prefer-dist

    - name: Generate app key
      run: php artisan key:generate

    - name: Run tests
      run: php artisan test --coverage

    - name: Upload coverage reports
      uses: codecov/codecov-action@v3
```

---

## Étape 5: Exécuter Tests Localement

```bash
# Tous les tests
php artisan test

# Tests Feature seulement
php artisan test tests/Feature

# Tests spécifique
php artisan test --filter test_user_can_login

# Avec coverage
php artisan test --coverage

# Verbose (plus de détails)
php artisan test -v
```

---

## Résultats Attendus

```
PASS  Tests/Feature/AuthTest
  ✓ user can register
  ✓ user can login
  ✓ user cannot login with wrong password

PASS  Tests/Feature/LivreTest
  ✓ livres page loads
  ✓ livre detail loads
  ✓ can search livres

PASS  Tests/Unit/UserTest
  ✓ user has admin method
  ✓ user has bibliothecaire method

Tests:  8 passed (47ms)
Coverage: 85%
```

---

Prêt pour le déploiement ? 🚀 → [04-TP-DEPLOYMENT.md](04-TP-DEPLOYMENT.md)

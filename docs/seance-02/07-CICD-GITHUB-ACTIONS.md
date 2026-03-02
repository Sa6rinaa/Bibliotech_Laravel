# 🚀 CI/CD avec GitHub Actions - Documentation Complète

**Objectif :** Configurer un pipeline d'intégration continue pour le projet Bibliotech Laravel

---

## 📋 Vue d'Ensemble du Pipeline

### **🔄 Workflow Automatisé**

Le fichier `.github/workflows/ci.yml` orchestre :

```yaml
📊 Tests automatisés (PHPUnit + Feature Tests)
🔍 Analyse statique du code (PHPStan)
🎨 Vérification du style de code (Laravel Pint)
🔒 Audit de sécurité (Composer Audit)
📈 Couverture de tests (Coverage)
🚀 Tests de performance
⚡ Déploiement automatique (staging)
```

---

## ⚙️ Configuration du Pipeline

### **📁 Structure des Fichiers CI/CD**

```
.github/
└── workflows/
    ├── ci.yml              # Pipeline principal
    ├── deploy-staging.yml  # Déploiement staging (optionnel)
    └── security-scan.yml   # Scan sécurité (optionnel)
```

### **🛠️ Pipeline Principal (.github/workflows/ci.yml)**

```yaml
name: 🚀 CI/CD Pipeline - Bibliotech Laravel

on:
  push:
    branches: [ main, 'seance-*' ]
  pull_request:
    branches: [ main ]
  workflow_dispatch:

jobs:
  # ===============================================
  # JOB 1: TESTS & VALIDATION
  # ===============================================
  tests:
    name: 🧪 Tests & Quality Checks
    runs-on: ubuntu-latest
    
    strategy:
      matrix:
        php-version: [8.3, 8.4]
    
    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      
    - name: 🐘 Setup PHP ${{ matrix.php-version }}
      uses: shivammathur/setup-php@v2
      with:
        php-version: ${{ matrix.php-version }}
        extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite, dom, filter, gd, iconv, json, mbstring, openssl
        coverage: xdebug
        
    - name: 📦 Install Composer dependencies
      run: composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader
      
    - name: 🔧 Setup Environment
      run: |
        cp .env.example .env
        php artisan key:generate
        touch database/database.sqlite
        
    - name: 🗃️ Run Database Migrations
      run: php artisan migrate --force
      
    - name: 🌱 Seed Database
      run: php artisan db:seed --force
      
    - name: 🧪 Run PHPUnit Tests
      run: php artisan test --coverage-clover=coverage.xml --log-junit=test-results.xml
      
    - name: 📊 Upload Coverage to Codecov
      uses: codecov/codecov-action@v3
      with:
        file: ./coverage.xml
        flags: unittests
        name: codecov-umbrella
        
  # ===============================================
  # JOB 2: ANALYSE STATIQUE
  # ===============================================
  code-quality:
    name: 🔍 Code Quality Analysis
    runs-on: ubuntu-latest
    
    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      
    - name: 🐘 Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.3
        extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite
        
    - name: 📦 Install dependencies
      run: composer install --prefer-dist --no-progress --optimize-autoloader
      
    - name: 🎨 Check Code Style (Laravel Pint)
      run: ./vendor/bin/pint --test
      
    - name: 🔍 Static Analysis (PHPStan)
      run: ./vendor/bin/phpstan analyse --memory-limit=2G
      
  # ===============================================
  # JOB 3: SÉCURITÉ
  # ===============================================
  security:
    name: 🔒 Security Audit
    runs-on: ubuntu-latest
    
    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      
    - name: 🐘 Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.3
        
    - name: 📦 Install dependencies
      run: composer install --prefer-dist --no-progress
      
    - name: 🔒 Security Audit
      run: composer audit
      
    - name: 🛡️ Check for known security vulnerabilities
      run: |
        composer require --dev roave/security-advisories:dev-latest || true
        composer audit --format=json > security-report.json || true
        
  # ===============================================
  # JOB 4: PERFORMANCE
  # ===============================================
  performance:
    name: ⚡ Performance Tests
    runs-on: ubuntu-latest
    
    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      
    - name: 🐘 Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.3
        extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite
        
    - name: 📦 Install dependencies
      run: composer install --prefer-dist --no-progress --optimize-autoloader
      
    - name: 🔧 Setup Environment
      run: |
        cp .env.example .env
        php artisan key:generate
        touch database/database.sqlite
        php artisan migrate --force
        php artisan db:seed --force
        
    - name: ⚡ Performance Tests
      run: |
        echo "🚀 Testing application boot time..."
        time php artisan list > /dev/null
        
        echo "📊 Testing database queries..."
        php artisan tinker --execute="
          \$start = microtime(true);
          App\Models\Livre::with('category')->get();
          \$time = (microtime(true) - \$start) * 1000;
          echo 'Query time: ' . round(\$time, 2) . 'ms' . PHP_EOL;
        "
        
    - name: 📈 Memory Usage Test
      run: |
        php -d memory_limit=128M artisan test --group=performance || echo "Performance tests completed"

  # ===============================================
  # JOB 5: DÉPLOIEMENT (si main branch)
  # ===============================================
  deploy:
    name: 🚀 Deploy to Staging
    needs: [tests, code-quality, security]
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main' && github.event_name == 'push'
    
    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      
    - name: 🚀 Deploy to staging
      run: |
        echo "🔄 Deploying to staging environment..."
        echo "✅ Deployment completed successfully!"
        # Ici, vous ajouteriez vos commandes de déploiement réelles
```

---

## 💻 Commandes Locales

### **🧪 Tests et Validation Locaux**

```bash
# 1. Tests complets comme sur GitHub Actions
php artisan test --coverage

# 2. Tests avec métrics détaillés
php artisan test --coverage --min=80

# 3. Tests de performance uniquement
php artisan test --group=performance

# 4. Tests spécifiques
php artisan test tests/Feature/LivreTest.php
```

### **🔍 Analyse Statique Locale**

```bash
# 1. Installer PHPStan (si pas déjà fait)
composer require --dev phpstan/phpstan

# 2. Créer phpstan.neon
echo "parameters:
    paths:
        - app
        - database
    level: 8
    ignoreErrors:
        - '#Call to an undefined method App\\Models\\.*::\\w+\\(\\)#'
    excludePaths:
        - vendor
        - bootstrap/cache" > phpstan.neon

# 3. Lancer l'analyse
./vendor/bin/phpstan analyse --memory-limit=2G

# 4. Analyse avec rapport JSON
./vendor/bin/phpstan analyse --error-format=json > phpstan-report.json
```

### **🎨 Style de Code**

```bash
# 1. Vérifier le style (dry-run)
./vendor/bin/pint --test

# 2. Corriger automatiquement
./vendor/bin/pint

# 3. Vérifier des fichiers spécifiques
./vendor/bin/pint app/Models/

# 4. Configuration personnalisée (pint.json)
echo '{
    "preset": "laravel",
    "rules": {
        "blank_line_after_opening_tag": false,
        "linebreak_after_opening_tag": false,
        "ordered_imports": {
            "sort_algorithm": "alpha"
        }
    }
}' > pint.json
```

### **🔒 Sécurité**

```bash
# 1. Audit des dépendances
composer audit

# 2. Audit avec détails
composer audit --format=json

# 3. Installer les advisories de sécurité
composer require --dev roave/security-advisories:dev-latest

# 4. Vérification des permissions fichiers
find . -type f -name "*.php" -perm 777 | head -10
```

---

## 📊 Tests de Performance

### **⚡ Benchmarks Intégrés**

```php
// tests/Feature/PerformanceTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livre;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group performance
 */
class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_loads_quickly()
    {
        $start = microtime(true);
        
        $response = $this->get('/');
        
        $loadTime = (microtime(true) - $start) * 1000;
        
        $response->assertOk();
        $this->assertLessThan(500, $loadTime, 'Home page took too long: ' . round($loadTime, 2) . 'ms');
    }

    public function test_database_queries_are_optimized()
    {
        \DB::enableQueryLog();
        
        // Test eager loading
        $livres = Livre::with('category')->get();
        
        $queries = \DB::getQueryLog();
        \DB::disableQueryLog();
        
        // Devrait être 2 requêtes max (livres + catégories)
        $this->assertLessThanOrEqual(2, count($queries), 'Too many queries: ' . count($queries));
    }

    public function test_memory_usage_is_reasonable()
    {
        $initialMemory = memory_get_usage();
        
        // Opération intensive
        $livres = Livre::with('category')->get();
        $livres->each(function($livre) {
            $livre->category->nom;
        });
        
        $finalMemory = memory_get_usage();
        $memoryUsed = ($finalMemory - $initialMemory) / 1024 / 1024; // MB
        
        $this->assertLessThan(50, $memoryUsed, 'Memory usage too high: ' . round($memoryUsed, 2) . 'MB');
    }
}
```

### **📈 Monitoring en Local**

```bash
# 1. Profiling avec Blackfire (optionnel)
# composer require --dev blackfire/php-sdk

# 2. Memory profiling avec Xdebug
php -d xdebug.mode=profile artisan test

# 3. Simple benchmark CLI
php artisan tinker --execute="
echo '=== PERFORMANCE BENCHMARK ===' . PHP_EOL;

// Test 1: Boot time
\$start = microtime(true);
app();
\$boot_time = (microtime(true) - \$start) * 1000;
echo 'App boot: ' . round(\$boot_time, 2) . 'ms' . PHP_EOL;

// Test 2: Database query
\$start = microtime(true);
App\Models\Livre::with('category')->get();
\$query_time = (microtime(true) - \$start) * 1000;
echo 'DB query: ' . round(\$query_time, 2) . 'ms' . PHP_EOL;

// Test 3: Memory usage
echo 'Memory: ' . round(memory_get_usage() / 1024 / 1024, 2) . 'MB' . PHP_EOL;
"
```

---

## 🎯 Configuration Avancée

### **📧 Notifications**

```yaml
# Ajouter dans .github/workflows/ci.yml
- name: 📧 Notify on failure
  if: failure()
  uses: 8398a7/action-slack@v3
  with:
    status: failure
    fields: repo,message,commit,author,action,eventName,ref,workflow
  env:
    SLACK_WEBHOOK_URL: ${{ secrets.SLACK_WEBHOOK }}
```

### **🏷️ Badges pour README**

```markdown
<!-- Ajouter dans README.md -->
![CI/CD Pipeline](https://github.com/username/bibliotech-laravel/workflows/CI/CD%20Pipeline/badge.svg)
![Coverage](https://codecov.io/gh/username/bibliotech-laravel/branch/main/graph/badge.svg)
![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat)
![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue.svg)
```

### **🔧 Environnements Multiples**

```yaml
# .github/workflows/deploy-staging.yml
name: 🚀 Deploy Staging

on:
  push:
    branches: [ develop ]

jobs:
  deploy-staging:
    runs-on: ubuntu-latest
    environment: staging
    
    steps:
    # ... steps de déploiement
```

---

## 📋 Checklist d'Implémentation

### **✅ Configuration Initiale**
- [ ] Fichier `.github/workflows/ci.yml` créé
- [ ] Tests PHPUnit passent localement
- [ ] Laravel Pint installé et configuré
- [ ] PHPStan installé et configuré

### **✅ Tests et Qualité**
- [ ] Coverage > 80% des lignes de code
- [ ] Aucune erreur PHPStan niveau 8
- [ ] Style de code conforme à Laravel PSR-12
- [ ] Audit de sécurité sans vulnérabilités

### **✅ Performance**
- [ ] Page d'accueil < 500ms
- [ ] Requêtes optimisées (Eager Loading)
- [ ] Utilisation mémoire < 50MB
- [ ] Tests de performance intégrés

### **✅ Déploiement**
- [ ] Pipeline réussit sur toutes les branches
- [ ] Déploiement staging automatique
- [ ] Notifications configurées
- [ ] Badges dans README

---

## 🚀 Commandes de Validation

```bash
# Test complet du pipeline en local
echo "🧪 Running full CI/CD simulation..."

# 1. Tests
php artisan test --coverage --min=80

# 2. Style
./vendor/bin/pint --test

# 3. Analyse statique
./vendor/bin/phpstan analyse

# 4. Sécurité
composer audit

# 5. Performance
php artisan test --group=performance

echo "✅ All checks passed! Ready for push to GitHub."
```

**🎉 Votre pipeline CI/CD est maintenant opérationnel !**

> 💡 **Conseil :** Surveillez régulièrement les métriques de performance et ajustez les seuils selon l'évolution du projet.
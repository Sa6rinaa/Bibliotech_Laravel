# 📊 Évaluation de Compétences - Séance 5

**Durée estimée:** 2 heures (auto-évaluation + exercices)

---

## 🎯 Objectifs Évalués

- ✅ Vérifier compréhension des tests automatisés
- ✅ Vérifier mise en place CI/CD
- ✅ Vérifier configuration production
- ✅ Tester monitoring et déploiement

---

## 🚦 Auto-Évaluation (Avant l'évaluation formelle)

### Niveau 1️⃣ - Tests Automatisés (Essentiel)

**Je dois pouvoir faire :**
- [ ] Expliquer la différence entre Unit Test et Feature Test
- [ ] Créer un test avec `php artisan make:test`
- [ ] Tester une route avec `$this->get('/route')`
- [ ] Vérifier le status HTTP avec `assertStatus(200)`
- [ ] Vérifier la base de données avec `assertDatabaseHas()`

**Si vous avez ❌ à plus de 2 questions:**
→ Relire [01-CONCEPTS-PRODUCTION.md](01-CONCEPTS-PRODUCTION.md) et [03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md)

---

### Niveau 2️⃣ - Production & CI/CD (Important)

**Je dois pouvoir faire :**
- [ ] Configurer GitHub Actions pour Laravel
- [ ] Désactiver `APP_DEBUG` en production
- [ ] Utiliser `php artisan optimize` pour optimiser l'app
- [ ] Créer les caches (config, routes, views)
- [ ] Déployer sur un serveur (VPS, Heroku, etc.)

**Si vous avez ❌ à plus de 2 questions:**
→ Relire [02-GLOSSAIRE-DEPLOYMENT.md](02-GLOSSAIRE-DEPLOYMENT.md) et [04-TP-DEPLOYMENT.md](04-TP-DEPLOYMENT.md)

---

### Niveau 3️⃣ - Monitoring & Sécurité (Bonus)

**Je dois pouvoir faire :**
- [ ] Intégrer Sentry pour l'error tracking
- [ ] Configurer les logs par channel
- [ ] Mettre en place HTTPS avec Let's Encrypt
- [ ] Créer un processus de rollback
- [ ] Monitorer les performances de l'application

**Si vous avez ❌ à plus de 3 questions:**
→ Extensions optionnelles, pour aller plus loin

---

## 📝 Partie 1: Questions Théoriques (30 min)

### Question 1 - Tests (4 points)
**Expliquez la différence entre un Unit Test et un Feature Test**

Réponse attendue:
- Unit Test = teste une classe isolée (ex: un modèle)
- Feature Test = teste une route complète (contrôleur + vue)
- Unit = rapide et ciblé, Feature = intégration complète

### Question 2 - CI/CD (4 points)
**Qu'est-ce qu'un pipeline CI/CD et à quoi sert-il ?**

Réponse attendue:
- CI = Continuous Integration = tests automatiques à chaque push
- CD = Continuous Deployment = déploiement automatique si tests OK
- GitHub Actions exécute les tests et déploie automatiquement

### Question 3 - Production (4 points)
**Pourquoi désactiver APP_DEBUG en production ?**

Réponse attendue:
- Évite d'exposer des informations sensibles (stack trace, config)
- Meilleure performance (pas de debug toolbar)
- Sécurité : n'affiche pas la structure du code aux visiteurs

### Question 4 - Optimisations (4 points)
**Quelles commandes utiliser pour optimiser une application Laravel en production ?**

Réponse attendue:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
composer install --optimize-autoloader --no-dev
```

### Question 5 - Sécurité (4 points)
**Pourquoi utiliser HTTPS en production ?**

Réponse attendue:
- Chiffrement des données (passwords, cookies)
- Protection contre man-in-the-middle
- Confiance des utilisateurs (cadenas vert)
- SEO : Google favorise HTTPS

---

## 💻 Partie 2: Exercices Pratiques (1h30)

### Exercice 1: Tests Feature (20 points)

**Objectif:** Écrire des tests Feature pour les routes principales

**Fichier:** `tests/Feature/LivreTest.php`

**Critères d'évaluation:**
- [ ] (4 pts) Test que la page `/livres` affiche la liste
- [ ] (4 pts) Test que `/livres/create` affiche le formulaire
- [ ] (4 pts) Test qu'on peut créer un livre avec POST
- [ ] (4 pts) Test que `/livres/{id}` affiche les détails
- [ ] (4 pts) Test de validation (titre requis)

**Code attendu:**
```php
<?php

namespace Tests\Feature;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_displays_livres_index_page()
    {
        $livre = Livre::factory()->create(['titre' => 'Test Livre']);
        
        $response = $this->get(route('livres.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Test Livre');
    }
    
    /** @test */
    public function it_can_create_a_livre()
    {
        $categorie = Categorie::factory()->create();
        
        $data = [
            'titre' => 'Nouveau Livre',
            'auteur' => 'Auteur Test',
            'annee_publication' => 2024,
            'categorie_id' => $categorie->id
        ];
        
        $response = $this->post(route('livres.store'), $data);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('livres', ['titre' => 'Nouveau Livre']);
    }
    
    /** @test */
    public function it_validates_titre_is_required()
    {
        $response = $this->post(route('livres.store'), [
            'titre' => ''
        ]);
        
        $response->assertSessionHasErrors(['titre']);
    }
}
```

---

### Exercice 2: GitHub Actions CI/CD (20 points)

**Objectif:** Configurer un pipeline CI/CD avec GitHub Actions

**Fichier:** `.github/workflows/laravel.yml`

**Critères d'évaluation:**
- [ ] (4 pts) Configuration PHP 8.3
- [ ] (4 pts) Installation des dépendances Composer
- [ ] (4 pts) Création de la base SQLite
- [ ] (4 pts) Exécution des migrations
- [ ] (4 pts) Exécution des tests

**Code attendu:**
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
      run: php artisan test
```

---

### Exercice 3: Configuration Production (15 points)

**Objectif:** Préparer l'application pour la production

**Fichier:** Script de déploiement

**Critères d'évaluation:**
- [ ] (3 pts) Mode maintenance activé
- [ ] (3 pts) Git pull
- [ ] (3 pts) Composer install (production)
- [ ] (3 pts) Migrations
- [ ] (3 pts) Caches et optimisations

**Code attendu:**
```bash
#!/bin/bash

echo "🚀 Déploiement BiblioTech"

# Mode maintenance
php artisan down

# Mise à jour code
git pull origin main

# Installation dépendances
composer install --no-dev --optimize-autoloader

# Migrations
php artisan migrate --force

# Optimisations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Permissions
chmod -R 775 storage bootstrap/cache

# Fin maintenance
php artisan up

echo "✅ Déploiement terminé"
```

---

### Exercice 4: Monitoring avec Logs (10 points)

**Objectif:** Configurer les logs par channel

**Fichier:** `config/logging.php` + Utilisation

**Critères d'évaluation:**
- [ ] (3 pts) Comprendre les channels (single, daily, slack)
- [ ] (3 pts) Logger une erreur avec `Log::error()`
- [ ] (2 pts) Logger une info avec `Log::info()`
- [ ] (2 pts) Consulter les logs `storage/logs/laravel.log`

**Code attendu:**
```php
// Dans un contrôleur
use Illuminate\Support\Facades\Log;

public function store(Request $request)
{
    try {
        $livre = Livre::create($request->all());
        
        Log::info('Livre créé', [
            'livre_id' => $livre->id,
            'user_id' => auth()->id()
        ]);
        
        return redirect()->route('livres.show', $livre);
        
    } catch (\Exception $e) {
        Log::error('Erreur création livre', [
            'error' => $e->getMessage(),
            'user_id' => auth()->id()
        ]);
        
        return back()->with('error', 'Erreur lors de la création');
    }
}
```

---

### Exercice 5 (Bonus): Déploiement Réel (10 points)

**Objectif:** Déployer l'application sur un serveur public

**Plateformes suggérées:**
- Heroku (gratuit)
- Railway (gratuit)
- Render (gratuit)
- VPS (DigitalOcean, AWS, etc.)

**Critères d'évaluation:**
- [ ] (3 pts) Application accessible via URL publique
- [ ] (2 pts) Base de données en production (MySQL/PostgreSQL)
- [ ] (2 pts) HTTPS configuré
- [ ] (2 pts) Variables d'environnement configurées
- [ ] (1 pt) Documentation du processus de déploiement

**Livrable:** 
- URL de l'application déployée
- Document décrivant les étapes de déploiement

---

## 📊 Grille de Notation Finale

| Section | Points Max | Obtenu | Notes |
|---------|-----------|--------|-------|
| **Questions Théoriques** | 20 | | Questions 1-5 |
| **Tests Feature** | 20 | | Exercice 1 |
| **CI/CD GitHub Actions** | 20 | | Exercice 2 |
| **Config Production** | 15 | | Exercice 3 |
| **Monitoring Logs** | 10 | | Exercice 4 |
| **Bonus Déploiement** | 10 | | Exercice 5 |
| **TOTAL** | **/95** | | |

---

## 🎓 Barème

- **85-95 :** Excellent ⭐⭐⭐ (Maîtrise complète)
- **75-84 :** Très Bien ⭐⭐ (Très bonne compréhension)
- **65-74 :** Bien ⭐ (Bonne maîtrise)
- **55-64 :** Satisfaisant ✅ (Compétences acquises)
- **< 55 :** À revoir 📚 (Revoir les concepts)

---

## 🚀 Après l'Évaluation

### Si vous avez 85+ 
**Félicitations !** 🎉 Vous maîtrisez le déploiement Laravel.

**Prochaines étapes :**
1. Contribuer à des projets open-source Laravel
2. Créer votre propre projet Laravel de A à Z
3. Explorer des sujets avancés (GraphQL, WebSockets, Microservices)

### Si vous avez 65-84
**Très bien !** 👍 Quelques points à améliorer.

**Conseils :**
- Pratiquer l'écriture de tests régulièrement
- Tester différentes plateformes de déploiement
- Approfondir le monitoring et la sécurité

### Si vous avez < 65
**Continuez !** 💪 Certains concepts à revoir.

**Actions :**
1. Relire les documents de la séance 5
2. Refaire les TPs pas à pas
3. Demander de l'aide sur les points bloquants
4. Pratiquer avec des projets simples

---

## 📚 Ressources pour Réviser

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [PHPUnit Documentation](https://phpunit.de/)
- [Video: Laravel Testing for Beginners](https://laracasts.com/series/phpunit-testing-in-laravel)

---

## ⚠️ Erreurs Courantes à Éviter

### Tests
- ❌ Ne pas utiliser `RefreshDatabase`
- ❌ Oublier de créer les factories
- ❌ Ne pas tester les cas d'erreur
- ✅ Tester aussi bien les succès que les échecs

### CI/CD
- ❌ Oublier de copier `.env.example`
- ❌ Ne pas générer la clé d'application
- ❌ Ne pas créer la base de données SQLite
- ✅ Vérifier que le pipeline passe localement d'abord

### Production
- ❌ Laisser `APP_DEBUG=true`
- ❌ Ne pas optimiser l'application
- ❌ Oublier les permissions storage
- ✅ Toujours tester en staging avant production

---

**🎉 Bonne chance pour votre évaluation !**

**N'oubliez pas :** La pratique régulière est la clé de la maîtrise. Continuez à coder, à tester et à déployer !

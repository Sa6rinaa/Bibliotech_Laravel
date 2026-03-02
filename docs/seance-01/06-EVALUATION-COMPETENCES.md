# ✅ ÉVALUATION - SÉANCE 1 : Fondations Laravel + Docker

## 🎯 Objectifs d'Évaluation

Cette grille d'évaluation permet de vérifier l'acquisition des compétences fondamentales de la Séance 1 :
- Architecture MVC et organisation du code Laravel
- Système de routage et paramètres
- Vues Blade et templates
- Environnement Docker et Codespace

⏱️ Durée : 2 heures (auto-évaluation + exercices + tests)

---

## 🚦 Auto-Évaluation (Avant l'évaluation formelle)

### Niveau 1️⃣ - MVC & Routage Basique (Essentiel)

**Je dois pouvoir faire :**
- [ ] Expliquer les 3 couches du pattern MVC avec exemples
- [ ] Créer une route simple (`GET /about`)
- [ ] Créer une route paramétrée (`GET /livre/{id}`)
- [ ] Créer un contrôleur avec une action
- [ ] Créer une vue et la retourner du contrôleur

**Si vous avez ❌ à plus de 2 questions :**
→ Relire [01-CONCEPTS-MVC.md](01-CONCEPTS-MVC.md) et [04-TP-ROUTES-SIMPLES.md](04-TP-ROUTES-SIMPLES.md)

---

### Niveau 2️⃣ - Vues Blade & Navigation (Important)

**Je dois pouvoir faire :**
- [ ] Utiliser les variables en Blade (`{{ $var }}`)
- [ ] Utiliser une boucle (`@foreach`)
- [ ] Utiliser une condition (`@if`)
- [ ] Utiliser un layout avec `@extends` et `@section`
- [ ] Créer un lien avec `route()` helper

**Si vous avez ❌ à plus de 2 questions :**
→ Relire [02-GLOSSAIRE-LARAVEL.md](02-GLOSSAIRE-LARAVEL.md) et [03-TP-DECOUVERTE-APP.md](03-TP-DECOUVERTE-APP.md)

---

### Niveau 3️⃣ - Avancé (Bonus)

**Je dois pouvoir faire :**
- [ ] Utiliser `withCount()` pour compter les relations
- [ ] Paginer des données avec `paginate()`
- [ ] Utiliser Eager loading (`.with()`)
- [ ] Créer des partials réutilisables
- [ ] Organiser les vues dans des dossiers

**Si vous avez ❌ à plus de 2 questions :**
→ Extensions optionnelles pour aller plus loin

---

### 🏗️ PARTIE 1 : Architecture MVC (6 points)

#### Compétence 1.1 : Compréhension du pattern MVC (2 points)
- ⭐⭐ Excellent (2pts) : Explique clairement le rôle de chaque composant (Model, View, Controller) avec des exemples concrets de BiblioTech
- ⭐ Satisfaisant (1pt) : Comprend les concepts de base mais manque de précision dans les exemples
- ❌ Insuffisant (0pt) : Confus sur la séparation des responsabilités

**Questions d'évaluation :**
- "Expliquez le rôle du LivreController dans l'architecture MVC"
- "Où se trouve la logique métier dans BiblioTech ?"

#### Compétence 1.2 : Organisation des fichiers Laravel (2 points)
- ⭐⭐ Excellent (2pts) : Navigue facilement dans l'arborescence Laravel, sait où créer/modifier les fichiers
- ⭐ Satisfaisant (1pt) : Comprend la structure générale mais hésite parfois
- ❌ Insuffisant (0pt) : Perdu dans l'organisation des dossiers

**Test pratique :**
- "Où ajouteriez-vous une nouvelle page 'Services' ?"
- "Montrez-moi le fichier qui gère l'affichage des livres"

#### Compétence 1.3 : Flux de données (2 points)
- ⭐⭐ Excellent (2pts) : Trace correctement le chemin d'une requête de la route jusqu'à l'affichage
- ⭐ Satisfaisant (1pt) : Comprend le principe général mais manque quelques étapes
- ❌ Insuffisant (0pt) : Ne peut pas expliquer le flux complet

**Exercice :** 
- "Décrivez ce qui se passe quand un utilisateur clique sur 'Voir détails' d'un livre"

---

### 🛣️ PARTIE 2 : Routage Laravel (5 points)

#### Compétence 2.1 : Routes simples (2 points)
- ⭐⭐ Excellent (2pts) : Crée une nouvelle route simple sans erreur et l'explique
- ⭐ Satisfaisant (1pt) : Y arrive avec quelques indications
- ❌ Insuffisant (0pt) : N'arrive pas à créer une route fonctionnelle

**Test pratique :**
```php
// Créer une route pour la page "Mentions légales"
// Route : /mentions
// Vue : mentions.blade.php
// Nom : legal.mentions
```

#### Compétence 2.2 : Paramètres de routes (2 points)
- ⭐⭐ Excellent (2pts) : Maîtrise les paramètres obligatoires ET optionnels, utilise les contraintes
- ⭐ Satisfaisant (1pt) : Comprend les paramètres de base mais confus sur les optionnels
- ❌ Insuffisant (0pt) : Ne comprend pas l'utilisation des paramètres

**Test pratique :**
```php
// Expliquer la différence entre :
Route::get('/user/{id}', ...);
Route::get('/user/{id?}', ...);
Route::get('/user/{id}', ...)->where('id', '[0-9]+');
```

#### Compétence 2.3 : Routes nommées et navigation (1 point)
- ⭐ Excellent (1pt) : Utilise correctement `route()` et comprend l'intérêt des noms
- ❌ Insuffisant (0pt) : Utilise les URLs en dur ou ne comprend pas les routes nommées

**Test pratique :**
- "Comment créer un lien vers la page de détail du livre ID 3 ?"

---

## 📚 Ressources Complémentaires

### Auto-Évaluation
👉 **[07-AUTO-EVALUATION.md](07-AUTO-EVALUATION.md)** - Checklist complète pour vous auto-évaluer

### Solution Complète
👉 **[solutions/seance-01/README.md](../../solutions/seance-01/README.md)**
- Code source commenté
- Extensions à implémenter
- Exemples concrets

### Fichiers Source
- Routes: [solutions/seance-01/routes/web.php](../../solutions/seance-01/routes/web.php)
- Controllers: [solutions/seance-01/app/Http/Controllers/](../../solutions/seance-01/app/Http/Controllers/)
- Views: [solutions/seance-01/resources/views/](../../solutions/seance-01/resources/views/)

---

**Prêt pour l'évaluation ?** ✅ Consultez d'abord [07-AUTO-EVALUATION.md](07-AUTO-EVALUATION.md)



# 📋 Synthèse Cas d'Utilisation - BiblioTech Séance 3

**État d'Avancement avec Numéros d'Exercices et Code Actuel**

---

## ⚠️ IMPORTANT : Ce qui existe DÉJÀ dans le code actuel

Selon le document `03-DECOUVERTE-CONTROLLERS.md`, le code de départ contient :

| Élément | État Actuel | Détails |
|---------|-------------|---------|
| `LivreController` | ✅ **EXISTE** | Contrôleur basique avec quelques méthodes simples |
| `routes/web.php` | ✅ **EXISTE** | Routes de base configurées |
| `livres/index.blade.php` | ✅ **EXISTE** | Vue liste basique |
| `livres/show.blade.php` | ✅ **EXISTE** | Vue détail basique |
| `SearchController` | ✅ **EXISTE** | Fonctionnel avec scope de recherche |
| `AccueilController` | ✅ **EXISTE** | Page d'accueil fonctionnelle |
| Modèles (Livre, Categorie) | ✅ **EXISTE** | Depuis séance 02 (SQLite) |
| Base de données | ✅ **EXISTE** | SQLite avec données (séance 02) |

> **💡 Pendant le TP guidé** : Les étudiants vont **COMPLÉTER/REMPLACER** ce code de base avec un CRUD complet.

---

## 📚 FONCTIONNALITÉS EXISTANTES (Code Actuel - Avant TP)

### UC01 : Voir Page d'Accueil
- **État** : ✅ **DÉJÀ IMPLÉMENTÉ**
- **Fichiers** : `WelcomeController`, `welcome.blade.php`
- **Référence Doc** : Aucune (fonctionnel depuis séance 01)
- **Action** : ❌ Rien à faire

### UC02 : Consulter Liste des Livres (Version Basique)
- **État** : ⚠️ **PARTIELLEMENT IMPLÉMENTÉ** (version simple)
- **Fichiers actuels** : 
  - `LivreController@index()` - méthode simple existante
  - `livres/index.blade.php` - vue basique existante
- **Référence Doc** : `03-DECOUVERTE` Étapes 2.2 et 3.3
- **Ce qui manque** : Pagination, filtres, interface Bootstrap moderne
- **Action** : ✅ **À AMÉLIORER** dans TP Guidé Module 1

### UC03 : Voir Détails d'un Livre (Version Basique)
- **État** : ⚠️ **PARTIELLEMENT IMPLÉMENTÉ** (version simple)
- **Fichiers actuels** :
  - `LivreController@show()` - méthode simple existante
  - `livres/show.blade.php` - vue basique existante
- **Référence Doc** : `03-DECOUVERTE` Étapes 2.2 et 3.3
- **Ce qui manque** : Boutons d'action, modal suppression, design moderne
- **Action** : ✅ **À AMÉLIORER** dans TP Guidé Module 2

### UC04 : Rechercher des Livres
- **État** : ✅ **DÉJÀ IMPLÉMENTÉ**
- **Fichiers** : `SearchController`, scope dans modèle `Livre`
- **Référence Doc** : `03-DECOUVERTE` Étape 4.1
- **Action** : ❌ Rien à faire (peut être amélioré en bonus)

---

## 🛠️ TP GUIDÉ - Fichier: `04-TP-PRATIQUE-CONTROLLERS.md`

### 📦 MODULE 1 : Contrôleur CRUD Complet (30 min)

> **⚠️ IMPORTANT** : Le LivreController existe déjà mais avec des méthodes basiques. L'Étape 1.3 dit : **"Remplacer le contenu de `app/Http/Controllers/LivreController.php`"**

| ID | Cas d'Utilisation | Exercice | État Code | Action TP | Ligne Doc |
|----|-------------------|----------|-----------|-----------|-----------|
| **UC05** | Créer un livre | **Étape 1.5-1.6** | ❌ N'EXISTE PAS | Ajouter `create()` + `store()` | ~130-170 |
| **UC06** | Modifier un livre | **Étape 1.7-1.8** | ❌ N'EXISTE PAS | Ajouter `edit()` + `update()` | ~180-220 |
| **UC07** | Supprimer un livre | **Étape 1.9** | ❌ N'EXISTE PAS | Ajouter `destroy()` | ~230 |
| **UC08** | Liste avec pagination | **Étape 1.3** | ⚠️ index() SIMPLE | Améliorer `index()` avec paginate(12) | ~100 |

**Fichier modifié** : `app/Http/Controllers/LivreController.php`

**Routes** : Étape 1.2 - Ajouter `Route::resource('livres', LivreController::class);`

---

### 🎨 MODULE 2 : Vues Blade Complètes (30 min)

> **💡 ASTUCE** : Templates fournis dans `resources/views/templates/` (peut gagner 15-20 min)

| ID | Cas d'Utilisation | Exercice | État Vues Actuelles | Action TP | Ligne Doc |
|----|-------------------|----------|---------------------|-----------|-----------|
| **UC09** | Formulaire création | **Étape 2.4** | ❌ PAS DE `create.blade.php` | Créer vue complète avec form | ~280 |
| **UC10** | Formulaire édition | **Étape 2.5** | ❌ PAS DE `edit.blade.php` | Créer vue avec form pré-rempli | ~350 |
| **UC11** | Modal confirmation | **Étape 2.3** | ❌ PAS DANS show.blade.php | Ajouter modal Bootstrap dans show | ~250 |
| **UC12** | Interface Bootstrap | **Étapes 2.1-2.6** | ⚠️ Vues BASIQUES existent | Améliorer toutes vues + layout | ~200-400 |

**Améliorer** : `index.blade.php` et `show.blade.php` (déjà existants mais simples)  
**Créer** : `create.blade.php` et `edit.blade.php` (n'existent pas)  
**Modifier** : `layouts/app.blade.php` (ajouter messages flash)

---

### ✅ MODULE 3 : Validation et Messages (30 min)

| ID | Cas d'Utilisation | Exercice | État Code | Action TP | Ligne Doc |
|----|-------------------|----------|-----------|-----------|-----------|
| **UC13** | Valider création | **Étape 1.6** | ❌ PAS DE VALIDATION | Ajouter rules dans `store()` | ~160 |
| **UC14** | Valider modification | **Étape 1.8** | ❌ PAS DE VALIDATION | Ajouter rules dans `update()` | ~210 |
| **UC15** | Messages flash succès | **Étape 2.1** | ❌ PAS DE FLASH | `with('success', ...)` + affichage | ~200 |
| **UC16** | Erreurs validation | **Étape 2.4** | ❌ PAS D'AFFICHAGE | `@error` dans formulaires | ~300 |

**Validation dans** : Méthodes `store()` et `update()` du contrôleur  
**Affichage dans** : Layout `app.blade.php` + formulaires `create` et `edit`

---

## 💪 TP AUTONOME - Fichier: `05-TP-PRATIQUE-EXERCICES.md`

> **⚠️ Ces exercices sont OPTIONNELS** - Pour étudiants confirmés ou travail à la maison

### Module 1 : Recherche Avancée (15 min)

| ID | Cas d'Utilisation | Exercice | État | Fichier | Ligne Doc |
|----|-------------------|----------|------|---------|-----------|
| **UC17** | Recherche multi-critères | **Exercice 1.1** | ❌ À FAIRE | `LivreController@index()` | Recherche amélio | ~50 |
| **UC18** | Filtre par catégorie | **Exercice 1.1** | ❌ À FAIRE | Ajout paramètre `where()` | ~50 |
| **UC19** | Tri dynamique | **Exercice 1.2** | ❌ À FAIRE | `orderBy()` avec paramètre | ~80 |

### Module 2 : Composants Blade (15 min)

| ID | Cas d'Utilisation | Exercice | État | Fichier à Créer | Ligne Doc |
|----|-------------------|----------|------|-----------------|-----------|
| **UC20** | Composant livre-card | **Exercice 2.1** | ❌ À FAIRE | `components/livre-card.blade.php` | ~150 |
| **UC21** | Composant alerte | **Exercice 2.2** | ❌ À FAIRE | `components/alert.blade.php` | ~180 |
| **UC22** | Pagination custom | **Exercice 2.3** | ❌ À FAIRE | Personnaliser pagination | ~200 |

### Module 3 : Form Requests (15 min)

| ID | Cas d'Utilisation | Exercice | État | Fichier | Ligne Doc |
|----|-------------------|----------|------|---------|-----------|
| **UC23** | StoreLivreRequest | **Exercice 3.1** | ❌ À FAIRE | `app/Http/Requests/StoreLivreRequest.php` | ~250 |
| **UC24** | UpdateLivreRequest | **Exercice 3.2** | ❌ À FAIRE | `app/Http/Requests/UpdateLivreRequest.php` | ~280 |
| **UC25** | Règle ISBN custom | **Exercice 3.3** | ❌ À FAIRE | Custom validation rule | ~320 |

### Module 4 & 5 : Mobile + Performance (Optionnel)

| ID | Cas d'Utilisation | Module | État |
|----|-------------------|--------|------|
| UC26-UC28 | Interface responsive | Module 4 | ❌ Bonus |
| UC29-UC31 | Optimisations | Module 5 | ❌ Bonus |

---

## ✅ ÉVALUATION - Fichier: `06-EVALUATION-COMPETENCES.md` (50 min)

> **⚠️ NOUVEAU SYSTÈME** : Gestion des **Auteurs** (prépare séance 4)

### Partie 1 : Structure (10 min) - 4 points

| Question | Exercice | État | Points |
|----------|----------|------|--------|
| **Q1.1** | Créer migration `auteurs` | ❌ À FAIRE | 2 pts |
| **Q1.2** | Créer modèle `Auteur` + relations | ❌ À FAIRE | 2 pts |

### Partie 2 : Contrôleur (15 min) - 6 points

| Question | Exercice | État | Points |
|----------|----------|------|--------|
| **Q2.1** | Générer `AuteurController --resource` | ❌ À FAIRE | 2 pts |
| **Q2.2** | Implémenter 7 méthodes CRUD | ❌ À FAIRE | 4 pts |

### Partie 3 : Vues (20 min) - 6 points

| Question | Exercice | État | Points |
|----------|----------|------|--------|
| **Q3.1** | Vue `index.blade.php` | ❌ À FAIRE | 3 pts |
| **Q3.2** | Vue `create.blade.php` | ❌ À FAIRE | 3 pts |

**Note** : Vues `show` et `edit` sont **OPTIONNELLES** (bonus +2 pts)

### Partie 4 : Validation (5 min) - 4 points

| Question | Exercice | État | Points |
|----------|----------|------|--------|
| **Q4.1** | Validation formulaires | ❌ À FAIRE | 2 pts |
| **Q4.2** | Messages flash | ❌ À FAIRE | 2 pts |

---

## 📊 Récapitulatif Global

### Statistiques des UC

| Catégorie | Nombre UC | État Initial | À Faire |
|-----------|-----------|--------------|---------|
| **Code Existant** | 4 UC | ✅ 2 fait, ⚠️ 2 partiels | Améliorer 2 |
| **TP Guidé Module 1** | 4 UC | ❌ À faire | Méthodes contrôleur |
| **TP Guidé Module 2** | 4 UC | ❌ À faire | 4 vues Blade |
| **TP Guidé Module 3** | 4 UC | ❌ À faire | Validation |
| **TP Autonome (opt.)** | 15 UC | ❌ Optionnel | Bonus avancés |
| **Évaluation** | 4 questions | ❌ Test final | Auteurs CRUD |
| **TOTAL** | **35 UC + 4 Q** | - | - |

### Répartition Temporelle (3h)

| Phase | Document | Durée | UC Couvertes |
|-------|----------|-------|--------------|
| Théorie | 01+02-CONCEPTS | 30 min | - |
| Découverte | 03-DECOUVERTE | 45 min | UC01-UC04 (explorer) |
| TP Guidé | 04-TP-PRATIQUE | 90 min | UC05-UC16 (12 UC) |
| TP Autonome | 05-TP-EXERCICES | Optionnel | UC17-UC31 (bonus) |
| Évaluation | 06-EVALUATION | 50 min | 4 questions |

---

## 🎯 Légende des États

| Symbole | Signification | Action Requise |
|---------|---------------|----------------|
| ✅ **FAIT** | Code fonctionnel complet | Aucune |
| ⚠️ **PARTIEL** | Code basique existant | Améliorer/Compléter |
| ❌ **À FAIRE** | N'existe pas | Créer entièrement |
| 💡 **OPTIONNEL** | Bonus avancé | Si temps disponible |

---

**Dernière mise à jour** : Corrigé avec vérification précise du code existant

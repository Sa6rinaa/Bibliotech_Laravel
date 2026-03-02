# 💻 TP Pratique : Exercices Complets - Séance 2

**Objectif :** Maîtriser SQLite, Eloquent ORM et les relations entre tables à travers 5 modules progressifs

---

## 🎯 Module 1 : Migrations SQLite (45 min)

### **🔧 Exercice 1.1 : Analyse des Migrations (15 min)**

**Contexte :** Comprendre la structure créée par les migrations Laravel

```bash
# 1. Vérifier les migrations dans le projet
ls -la database/migrations/

# 2. Examiner les migrations existantes
php artisan migrate:status

# 3. Analyser une migration spécifique
cat database/migrations/*_create_categories_table.php
```

**Questions à résoudre :**
- 📝 Combien de migrations sont présentes dans le projet ?
- 📝 Quelles tables seront créées après `php artisan migrate` ?
- 📝 Quels types de colonnes sont utilisés pour la table `categories` ?

### **🔧 Exercice 1.2 : Exécution des Migrations (15 min)**

```bash
# 1. Créer le fichier SQLite (si n'existe pas)
touch database/database.sqlite

# 2. Lancer les migrations
php artisan migrate

# 3. Vérifier que tout s'est bien passé
php artisan migrate:status

# 4. Examiner la structure créée
php artisan tinker
>>> Schema::getColumnListing('livres')
>>> Schema::getColumnListing('categories')
>>> exit
```

**Résultat attendu :**
```bash
+------+--------------------------------------------------+-------+
| Ran? | Migration                                        | Batch |
+------+--------------------------------------------------+-------+
| Yes  | 0001_01_01_000000_create_users_table             | 1     |
| Yes  | 0001_01_01_000001_create_cache_table             | 1     |
| Yes  | 0001_01_01_000002_create_jobs_table              | 1     |
| Yes  | 2025_09_26_113440_create_livres_table            | 1     |
| Yes  | 2025_09_26_113507_create_utilisateurs_table      | 1     |
| Yes  | [timestamp]_create_categories_table              | 1     |
| Yes  | [timestamp]_add_category_id_to_livres_table      | 1     |
+------+--------------------------------------------------+-------+
```

### **🔧 Exercice 1.3 : Rollback et Fresh (15 min)**

```bash
# 1. Faire un rollback de la dernière migration
php artisan migrate:rollback

# 2. Vérifier l'état
php artisan migrate:status

# 3. Re-migrer
php artisan migrate

# 4. Alternative : fresh (reset complet)
php artisan migrate:fresh
```

**💡 Conseil :** Utilisez `migrate:fresh` pendant le développement, `migrate:rollback` en production.

---

## 🏗️ Module 2 : Modèles Eloquent (60 min)

### **🔧 Exercice 2.1 : Test du Modèle Category (20 min)**

**Contexte :** Vérifier que le modèle Category fonctionne correctement

```bash
php artisan tinker
```

```php
// 1. Créer une catégorie avec new + save
$cat = new App\Models\Categorie();
$cat->nom = "Test Développement";
$cat->description = "Livres sur la programmation";
$cat->couleur = "#28a745";
$cat->save();

// 2. Vérifier le slug automatique
echo "Slug généré: " . $cat->slug . PHP_EOL;

// 3. Tester la méthode create (mass assignment)
$cat2 = App\Models\Categorie::create([
    'nom' => 'Design Web',
    'description' => 'Livres sur le design et UX/UI',
    'couleur' => '#007bff'
]);

// 4. Compter les catégories
echo "Nombre de catégories: " . App\Models\Categorie::count() . PHP_EOL;

// 5. Lister toutes les catégories
App\Models\Categorie::all()->pluck('nom');
```

**Résultats attendus :**
- ✅ Slug généré automatiquement : "test-developpement"
- ✅ 2 catégories créées
- ✅ Scope `actives()` fonctionne

### **🔧 Exercice 2.2 : Test du Modèle Livre (20 min)**

```php
// Dans Tinker
// 1. Récupérer une catégorie existante
$cat = App\Models\Categorie::first();

// 2. Créer un livre lié à cette catégorie
$livre = App\Models\Livre::create([
    'titre' => 'Laravel pour les Nuls',
    'auteur' => 'John Doe',
    'annee' => 2024,
    'nb_pages' => 350,
    'isbn' => '978-2-123456-78-9',
    'resume' => 'Guide complet pour apprendre Laravel',
    'disponible' => true,
    'category_id' => $cat->id
]);

// 3. Tester les scopes
App\Models\Livre::disponible()->count();
App\Models\Livre::recherche('Laravel')->get();

// 4. Vérifier la relation
echo "Livre: " . $livre->titre . PHP_EOL;
echo "Catégorie: " . $livre->categorie->nom . PHP_EOL;
```

### **🔧 Exercice 2.3 : Relations Bidirectionnelles (20 min)**

```php
// Dans Tinker
// 1. Relation Categorie -> Livres (hasMany)
$cat = App\Models\Categorie::first();
echo "Catégorie: " . $cat->nom . PHP_EOL;
echo "Nombre de livres: " . $cat->livres()->count() . PHP_EOL;
$cat->livres->pluck('titre');

// 2. Relation Livre -> Categorie (belongsTo)
$livre = App\Models\Livre::first();
echo "Livre: " . $livre->titre . PHP_EOL;
echo "Catégorie: " . $livre->categorie->nom . PHP_EOL;

// 3. Eager Loading (optimisation)
$livres = App\Models\Livre::with('categorie')->get();
foreach($livres as $livre) {
    echo $livre->titre . " (" . $livre->categorie->nom . ")" . PHP_EOL;
}

// 4. Créer des livres pour une catégorie
$cat->livres()->create([
    'titre' => 'PHP 8 Avancé',
    'auteur' => 'Marie Expert',
    'disponible' => true
]);
```

**❗ Point d'attention :** Notez la différence entre `livres()` (query builder) et `livres` (collection).

---

## 🌱 Module 3 : Seeders et Données de Test (45 min)

### **🔧 Exercice 3.1 : Reset et Seed Complet (15 min)**

```bash
# 1. Vider complètement la base
php artisan migrate:fresh

# 2. Lancer tous les seeders
php artisan migrate:fresh --seed

# 3. Vérifier les données créées
php artisan tinker
>>> "Catégories: " . App\Models\Categorie::count()
>>> "Livres: " . App\Models\Livre::count()
>>> App\Models\Categorie::all()->pluck('nom')
>>> exit
```

**Résultat attendu :**
- ✅ 6 catégories créées (Laravel, Vue.js, PHP, JavaScript, etc.)
- ✅ 6 livres créés avec relations correctes
- ✅ Couleurs et icônes cohérentes par catégorie

### **🔧 Exercice 3.2 : Seeders Individuels (15 min)**

```bash
# 1. Reset sans seeders
php artisan migrate:fresh

# 2. Lancer uniquement CategorySeeder
php artisan db:seed --class=CategorySeeder

# 3. Vérifier
php artisan tinker
>>> App\Models\Categorie::all()->pluck('nom', 'couleur')

# 4. Lancer LivreSeeder (dépend des catégories)
php artisan db:seed --class=LivreSeeder

# 5. Tester les relations
>>> App\Models\Livre::with('categorie')->get()->map(function($livre) {
    return $livre->titre . ' -> ' . $livre->categorie->nom;
});
```

### **🔧 Exercice 3.3 : Analyse des Données Créées (15 min)**

```php
// Dans Tinker - Analyse des données seedées

// 1. Statistiques générales
echo "=== STATISTIQUES BIBLIOTECH ===" . PHP_EOL;
echo "Catégories: " . App\Models\Categorie::count() . PHP_EOL;
echo "Livres: " . App\Models\Livre::count() . PHP_EOL;
echo "Livres disponibles: " . App\Models\Livre::disponible()->count() . PHP_EOL;

// 2. Répartition par catégorie
echo PHP_EOL . "=== RÉPARTITION PAR CATÉGORIE ===" . PHP_EOL;
App\Models\Categorie::withCount('livres')->get()->each(function($cat) {
    echo "• " . $cat->nom . ": " . $cat->livres_count . " livre(s)" . PHP_EOL;
});

// 3. Livres par catégorie détaillés
echo PHP_EOL . "=== LIVRES PAR CATÉGORIE ===" . PHP_EOL;
App\Models\Categorie::with('livres')->get()->each(function($cat) {
    echo PHP_EOL . "📚 " . $cat->nom . " (" . $cat->couleur . ")" . PHP_EOL;
    $cat->livres->each(function($livre) {
        echo "  • " . $livre->titre . " - " . $livre->auteur;
        echo $livre->disponible ? " ✅" : " ❌";
        echo PHP_EOL;
    });
});
```

---

## 🔍 Module 4 : Requêtes Eloquent Avancées (45 min)

### **🔧 Exercice 4.1 : Recherches et Filtres (15 min)**

```php
// Dans Tinker
// 1. Recherche textuelle
echo "=== RECHERCHE 'Laravel' ===" . PHP_EOL;
App\Models\Livre::recherche('Laravel')->get()->pluck('titre');

// 2. Filtrage par disponibilité
echo "=== LIVRES DISPONIBLES ===" . PHP_EOL;
App\Models\Livre::disponible()->get()->pluck('titre');

// 3. Filtrage par catégorie (via relation)
echo "=== LIVRES PHP ===" . PHP_EOL;
App\Models\Livre::whereHas('category', function($query) {
    $query->where('slug', 'php');
})->get()->pluck('titre');

// 4. Combinaison de filtres
echo "=== LIVRES PHP DISPONIBLES ===" . PHP_EOL;
App\Models\Livre::disponible()
    ->whereHas('category', function($query) {
        $query->where('slug', 'php');
    })->get()->pluck('titre');
```

### **🔧 Exercice 4.2 : Requêtes avec Relations (15 min)**

```php
// Dans Tinker
// 1. Comptage des livres par catégorie
echo "=== COMPTAGE PAR CATÉGORIE ===" . PHP_EOL;
App\Models\Categorie::withCount('livres')->get()->each(function($cat) {
    echo $cat->nom . ": " . $cat->livres_count . " livres" . PHP_EOL;
});

// 2. Catégories avec au moins un livre
echo "=== CATÉGORIES AVEC LIVRES ===" . PHP_EOL;
App\Models\Categorie::has('livres')->get()->pluck('nom');

// 3. Livres avec leurs catégories (Eager Loading)
echo "=== LIVRES + CATÉGORIES ===" . PHP_EOL;
App\Models\Livre::with('categorie')->get()->each(function($livre) {
    echo $livre->titre . " [" . $livre->categorie->nom . "]" . PHP_EOL;
});

// 4. Catégories ordonnées par nombre de livres
echo "=== TOP CATÉGORIES ===" . PHP_EOL;
App\Models\Categorie::withCount('livres')
    ->orderBy('livres_count', 'desc')
    ->get()
    ->pluck('nom', 'livres_count');
```

### **🔧 Exercice 4.3 : Requêtes SQL Brutes (15 min)**

```php
// Dans Tinker - Comparaison Eloquent vs SQL brut

// 1. Eloquent ORM
$livres_orm = App\Models\Livre::with('categorie')
    ->where('disponible', true)
    ->get();
echo "Eloquent: " . $livres_orm->count() . " livres" . PHP_EOL;

// 2. Query Builder Laravel
$livres_qb = DB::table('livres')
    ->join('categories', 'livres.category_id', '=', 'categories.id')
    ->where('livres.disponible', true)
    ->select('livres.*', 'categories.nom as categorie_nom')
    ->get();
echo "Query Builder: " . $livres_qb->count() . " livres" . PHP_EOL;

// 3. SQL brut (pour comprendre ce qui se passe)
$sql = "SELECT l.*, c.nom as categorie_nom 
        FROM livres l 
        JOIN categories c ON l.category_id = c.id 
        WHERE l.disponible = 1";
$livres_raw = DB::select($sql);
echo "SQL brut: " . count($livres_raw) . " livres" . PHP_EOL;

// 4. Analyser les requêtes générées
DB::enableQueryLog();
App\Models\Livre::with('categorie')->disponible()->get();
collect(DB::getQueryLog())->pluck('query');
DB::disableQueryLog();
```

---

## ✅ Module 5 : Validation et Tests (30 min)

### **🔧 Exercice 5.1 : Tests d'Intégrité (10 min)**

```php
// Dans Tinker - Vérifications d'intégrité
echo "=== TESTS D'INTÉGRITÉ ===" . PHP_EOL;

// Test 1: Toutes les catégories ont un slug
$cats_sans_slug = App\Models\Categorie::whereNull('slug')->count();
echo "Catégories sans slug: " . $cats_sans_slug . " (doit être 0)" . PHP_EOL;

// Test 2: Tous les livres ont une catégorie
$livres_sans_cat = App\Models\Livre::whereNull('category_id')->count();
echo "Livres sans catégorie: " . $livres_sans_cat . " (doit être 0)" . PHP_EOL;

// Test 3: Toutes les relations fonctionnent
$total_relations = App\Models\Livre::with('categorie')->get()
    ->filter(function($livre) {
        return $livre->category !== null;
    })->count();
echo "Relations fonctionnelles: " . $total_relations . "/" . App\Models\Livre::count() . PHP_EOL;

// Test 4: Contraintes de validation
try {
    // Essayer de créer sans données requises
    App\Models\Categorie::create([]);
} catch (Exception $e) {
    echo "✅ Contrainte respectée: " . substr($e->getMessage(), 0, 50) . "..." . PHP_EOL;
}
```

### **🔧 Exercice 5.2 : Performance des Requêtes (10 min)**

```php
// Dans Tinker - Analyse de performance
echo "=== ANALYSE PERFORMANCE ===" . PHP_EOL;

// Activer le log des requêtes
DB::enableQueryLog();

// Test 1: Sans Eager Loading (problème N+1)
$start = microtime(true);
$livres = App\Models\Livre::all();
foreach($livres as $livre) {
    $cat_nom = $livre->categorie->nom; // Une requête par livre !
}
$time_n1 = microtime(true) - $start;
$queries_n1 = count(DB::getQueryLog());

DB::flushQueryLog();

// Test 2: Avec Eager Loading (optimisé)
$start = microtime(true);
$livres = App\Models\Livre::with('categorie')->get();
foreach($livres as $livre) {
    $cat_nom = $livre->categorie->nom; // Aucune requête supplémentaire
}
$time_eager = microtime(true) - $start;
$queries_eager = count(DB::getQueryLog());

echo "Sans Eager Loading: " . $queries_n1 . " requêtes, " . round($time_n1 * 1000, 2) . "ms" . PHP_EOL;
echo "Avec Eager Loading: " . $queries_eager . " requêtes, " . round($time_eager * 1000, 2) . "ms" . PHP_EOL;

DB::disableQueryLog();
```

### **🔧 Exercice 5.3 : Export et Documentation (10 min)**

```bash
# 1. Exporter la structure de la base
php artisan schema:dump

# 2. Créer un backup des données
php artisan tinker --execute="
    file_put_contents('database/backup_categories.json', 
        App\Models\Categorie::all()->toJson(JSON_PRETTY_PRINT));
    file_put_contents('database/backup_livres.json', 
        App\Models\Livre::with('categorie')->get()->toJson(JSON_PRETTY_PRINT));
    echo 'Backup créé' . PHP_EOL;
"

# 3. Statistiques finales
php artisan tinker --execute="
    echo '=== BIBLIOTECH - STATISTIQUES FINALES ===' . PHP_EOL;
    echo 'Catégories: ' . App\Models\Categorie::count() . PHP_EOL;
    echo 'Livres: ' . App\Models\Livre::count() . PHP_EOL;
    echo 'Relations: ' . App\Models\Livre::whereNotNull('category_id')->count() . PHP_EOL;
    echo 'Disponibles: ' . App\Models\Livre::disponible()->count() . PHP_EOL;
"
```

---

## 🏆 Validation des Compétences

### **📋 Checklist de Maîtrise**

#### **SQLite & Migrations**
- [ ] Je sais créer et lancer des migrations
- [ ] Je comprends les types de colonnes SQLite
- [ ] Je maîtrise `migrate:fresh` vs `migrate:rollback`
- [ ] Je sais analyser la structure avec Tinker

#### **Modèles Eloquent**
- [ ] Je crée des modèles avec relations
- [ ] Je utilise `$fillable` pour mass assignment
- [ ] Je définis des scopes personnalisés
- [ ] Je comprends belongsTo vs hasMany

#### **Relations**
- [ ] Je configure les clés étrangères
- [ ] J'utilise l'Eager Loading pour optimiser
- [ ] Je navigue dans les relations bidirectionnelles
- [ ] J'évite le problème N+1

#### **Seeders**
- [ ] Je crée des seeders cohérents
- [ ] Je respecte l'ordre d'exécution
- [ ] Je génère des données réalistes
- [ ] Je teste avec `--seed`

### **🎯 Défis Bonus**

1. **Défi Performance :** Créer une requête qui récupère tous les livres avec leurs catégories en une seule requête SQL
2. **Défi Relation :** Ajouter une table `auteurs` et créer une relation many-to-many avec `livres`
3. **Défi Search :** Implémenter une recherche full-text avec pondération par colonnes

---

**✨ Bravo ! Vous maîtrisez maintenant SQLite avec Laravel !**

> **🚀 Prochaine étape :** Séance 3 - Créer des formulaires CRUD pour manipuler ces données via l'interface web.
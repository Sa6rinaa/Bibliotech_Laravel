# 🎓 Solution - Séance 2: Migrations & Eloquent ORM

**Durée:** 7 heures  
**Compétences:** Migrations, Models Eloquent, Relations, Seeders  

---

## 📁 Structure des Solutions

```
solutions/seance-02/
├── README.md (ce fichier)
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_categories_table.php
│   │   ├── *_create_livres_table.php
│   │   ├── *_add_categorie_id_to_livres_table.php
│   │   └── *_create_utilisateurs_table.php
│   └── seeders/
│       ├── CategorieSeeder.php
│       ├── LivreSeeder.php
│       └── DatabaseSeeder.php
└── app/Http/Controllers/
    ├── LivreController.php (avec Eloquent)
    └── CategorieController.php (avec Eloquent)
```

---

## 🎯 Concepts Clés Appliqués

### 1️⃣ Migrations
- Création de tables `Schema::create()`
- Colonnes et types : `$table->string()`, `$table->integer()`, etc
- Clés étrangères : `$table->foreign()->references()`
- Rollback et refactorisation

### 2️⃣ Models Eloquent
- Correspondance avec tables
- Attributs et casting
- Accesseurs et mutateurs
- Conventions Laravel

### 3️⃣ Relations
- HasMany / BelongsTo (1-N)
- BelongsToMany (N-N)
- Lazy loading vs Eager loading

### 4️⃣ Query Builder vs Eloquent
- Eloquent = abstraction POO
- DB::table() = Query builder brut
- Methods : `->where()`, `->get()`, `->first()`, `->count()`

### 5️⃣ Seeders
- Remplir la base avec données de test
- Factories pour générer données
- Appel avec `php artisan db:seed`

---

## ✅ Auto-Évaluation

### Niveau 1 - Migrations (Essentiel)
- [ ] Je comprends la structure d'une migration
- [ ] Je sais créer une colonne avec `->string()`, `->integer()`, etc
- [ ] Je sais ajouter une clé étrangère
- [ ] Je comprends le timestamp et `created_at/updated_at`
- [ ] Je sais lancer les migrations avec `php artisan migrate`

**Validation:** Créer une migration `create_articles_table` avec titre, contenu, auteur_id

### Niveau 2 - Models & Relations (Important)
- [ ] Je sais créer un Model correspondant à une table
- [ ] Je comprends les conventions de nommage (Livre → livres table)
- [ ] Je sais définir une relation HasMany
- [ ] Je sais définir une relation BelongsTo
- [ ] Je sais utiliser `$model->relation()` pour charger les données
- [ ] Je comprends Eager loading vs Lazy loading

**Validation:** Afficher tous les livres avec leur catégorie (eager loading)

### Niveau 3 - Advanced Queries (Bonus)
- [ ] Je sais écrire des requêtes complexes avec `->where()`, `->orderBy()`
- [ ] Je sais utiliser `withCount()` pour compter les relations
- [ ] Je sais paginer avec `->paginate()`
- [ ] Je sais utiliser les scopes
- [ ] Je comprends les mutateurs/accesseurs

**Validation:** Afficher les 3 catégories avec le plus de livres

---

## 🚀 Extensions Possibles

### Extension 1: Soft Deletes
**Objectif:** Supprimer les livres sans vraiment les supprimer de la DB

**Migration:**
```php
// Ajouter une colonne deleted_at
Schema::table('livres', function (Blueprint $table) {
    $table->softDeletes();
});
```

**Dans le Model:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Livre extends Model
{
    use SoftDeletes;
}
```

**Query:**
```php
$livres = Livre::all(); // Exclut automatiquement les deletés
$todos = Livre::withTrashed()->get(); // Inclut les deletés
$deleted = Livre::onlyTrashed()->get(); // Seulement les deletés
```

**Compétences:** Traits Laravel, migrations, scopes implicites

---

### Extension 2: Accesseurs & Mutateurs
**Objectif:** Formatter automatiquement les données

**Dans le Model Livre:**
```php
class Livre extends Model
{
    // Accesseur: formater le titre en minuscules
    public function getTitreAttribute($value)
    {
        return strtolower($value);
    }

    // Mutateur: capitaliser le titre quand on l'assigne
    public function setTitreAttribute($value)
    {
        $this->attributes['titre'] = ucfirst($value);
    }

    // Accesseur calculé (pas de colonne)
    public function getExcerptAttribute()
    {
        return substr($this->description, 0, 100) . '...';
    }
}
```

**Utilisation:**
```php
$livre = Livre::first();
echo $livre->titre; // Automatiquement formaté
$livre->titre = 'nouveau titre'; // Automatiquement muté
```

**Compétences:** Magic methods, data formatting, business logic

---

### Extension 3: Scopes Réutilisables
**Objectif:** Créer des requêtes réutilisables

**Dans le Model:**
```php
class Livre extends Model
{
    // Scope global: toujours exclure les livres supprimés
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    // Scope avec paramètre
    public function scopeParCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    // Scope pour les nouveautés
    public function scopeRecent($query, $jours = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($jours));
    }
}
```

**Utilisation:**
```php
$livres = Livre::actif()->recent(7)->get();
$livresFantasy = Livre::actif()->parCategorie(3)->get();
```

**Compétences:** Chaîning de requêtes, réutilisabilité, lisibilité

---

### Extension 4: Relations Many-to-Many
**Objectif:** Livres avec plusieurs auteurs (N-N)

**Migration pivot table:**
```php
Schema::create('auteur_livre', function (Blueprint $table) {
    $table->id();
    $table->foreignId('auteur_id')->constrained();
    $table->foreignId('livre_id')->constrained();
    $table->timestamps();
});
```

**Dans Model Livre:**
```php
class Livre extends Model
{
    public function auteurs()
    {
        return $this->belongsToMany(Auteur::class);
    }
}
```

**Utilisation:**
```php
$livre = Livre::first();
foreach ($livre->auteurs as $auteur) {
    echo $auteur->nom;
}

// Attacher un auteur
$livre->auteurs()->attach($auteurId);

// Détacher
$livre->auteurs()->detach($auteurId);

// Synchroniser (remplace tous)
$livre->auteurs()->sync([1, 2, 3]);
```

**Compétences:** Tables pivot, relations complexes, gestion associations

---

### Extension 5: Factories & Seeders Avancés
**Objectif:** Générer beaucoup de données de test avec des relations

**Factory:**
```php
// database/factories/LivreFactory.php
public function definition()
{
    return [
        'titre' => fake()->sentence(),
        'auteur' => fake()->name(),
        'description' => fake()->paragraph(),
        'categorie_id' => Categorie::inRandomOrder()->first()->id ?? 1,
        'isbn' => fake()->isbn13(),
        'pages' => fake()->numberBetween(100, 800),
        'annee' => fake()->year(),
    ];
}
```

**Seeder:**
```php
// database/seeders/DatabaseSeeder.php
public function run()
{
    // Créer 5 catégories
    Categorie::factory()->count(5)->create();

    // Créer 50 livres
    Livre::factory()->count(50)->create();

    // Créer 10 utilisateurs
    User::factory()->count(10)->create();
}
```

**Utilisation:**
```bash
php artisan db:seed
php artisan migrate:fresh --seed  # Reset + seeder
```

**Compétences:** Factories, relations en seed, data fixtures

---

## 📊 Grille de Validation

| Compétence | Status | Points | Notes |
|---|---|---|---|
| Migrations | ✅/❌ | /3 | Création, clés étrangères |
| Models & Relations | ✅/❌ | /3 | HasMany, BelongsTo |
| Query Builder | ✅/❌ | /2 | Where, orderBy, paginate |
| Seeders | ✅/❌ | /2 | Remplir la DB |
| Extensions réalisées | ✅/❌ | /2 | Bonus |
| **TOTAL** | | **/12** | |

---

## 💡 Points d'Attention

### ❌ Erreurs Courantes
- Oublier `$table->id()` en début de migration
- Nommer la table au singulier (deve être pluriel)
- Oublier `->references('id')->on('users')` pour les clés étrangères
- Oublier `use HasMany;` sur les models
- Générer des données sans vérifier les doublons

### ✅ Bonnes Pratiques
- Toujours utiliser des migrations plutôt que ALTER TABLE manuel
- Cherger les relations avec Eager loading (`.with()`)
- Écrire les seeders pour tous les environnements
- Utiliser des factories plutôt que du SQL brut
- Tester les migrations avec `migrate:fresh`

---

## 🔗 Ressources

- [Migrations](https://laravel.com/docs/11.x/migrations)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
- [Relationships](https://laravel.com/docs/11.x/eloquent-relationships)
- [Seeding](https://laravel.com/docs/11.x/seeding)
- [Accessors & Mutators](https://laravel.com/docs/11.x/eloquent-mutators)

---

**Prêt pour la Séance 3 ?** → Controllers Avancés & API


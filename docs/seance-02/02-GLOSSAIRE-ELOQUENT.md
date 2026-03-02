# 📚 Glossaire Eloquent ORM & Base de Données

**Dictionnaire des termes essentiels pour SQLite et Laravel**

---

## 🗃️ Base de Données (Database)

### **SQLite**
Base de données **légère**, **autonome** et **sans serveur** qui stocke toutes les données dans un **seul fichier**.
```bash
# Fichier SQLite dans Laravel
database/database.sqlite
```

### **SGBD (Système de Gestion de Base de Données)**
Logiciel qui permet de **créer**, **gérer** et **interroger** une base de données.
- 🪶 **SQLite** : Léger, fichier unique
- 🐘 **PostgreSQL** : Robuste, serveur
- 🐬 **MySQL** : Populaire, serveur

### **Table**
Structure qui organise les données en **lignes** (enregistrements) et **colonnes** (attributs).
```
Table "livres"
+----+------------------+---------+-------------+
| id | titre            | auteur  | category_id |
+----+------------------+---------+-------------+
| 1  | Laravel Guide    | John    | 2           |
| 2  | PHP Avancé       | Marie   | 1           |
+----+------------------+---------+-------------+
```

### **Schéma**
**Structure** et **organisation** des tables dans la base de données.
```php
// Définition du schéma avec Laravel
Schema::create('livres', function (Blueprint $table) {
    $table->id();
    $table->string('titre');
    $table->foreignId('category_id');
});
```

---

## 🔄 Migrations

### **Migration**
Fichier PHP qui décrit les **modifications** à apporter à la structure de la base de données.
```bash
# Créer une migration
php artisan make:migration create_categories_table
```

### **Schema Builder**
API Laravel pour **définir** et **modifier** la structure des tables.
```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();                    // Clé primaire auto-incrémentée
    $table->string('nom');           // VARCHAR(255)
    $table->text('description');     // TEXT
    $table->timestamps();            // created_at, updated_at
});
```

### **Rollback**
**Annuler** la dernière migration pour revenir à l'état précédent.
```bash
php artisan migrate:rollback
```

### **Fresh**
**Supprimer toutes** les tables puis **re-exécuter** toutes les migrations.
```bash
php artisan migrate:fresh
```

---

## 🎭 Eloquent ORM

### **ORM (Object-Relational Mapping)**
Technique qui permet de **manipuler** les données de la base comme des **objets PHP**.
```php
// Au lieu de SQL brut
$result = DB::select("SELECT * FROM livres WHERE disponible = 1");

// On utilise Eloquent
$livres = Livre::where('disponible', true)->get();
```

### **Modèle (Model)**
Classe PHP qui **représente** une table de la base de données.
```php
class Livre extends Model
{
    protected $table = 'livres';     // Table associée
    protected $fillable = ['titre']; // Colonnes modifiables
}
```

### **Active Record**
Pattern où chaque **instance de modèle** correspond à **une ligne** dans la table.
```php
$livre = new Livre();      // Nouvelle instance = nouvelle ligne
$livre->titre = "Test";    // Modifier l'attribut
$livre->save();            // Sauvegarder en base
```

### **Query Builder**
Interface fluide pour **construire des requêtes** SQL de manière programmatique.
```php
Livre::where('disponible', true)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();
```

---

## 🔗 Relations

### **Clé Primaire (Primary Key)**
Colonne qui **identifie uniquement** chaque ligne de la table.
```php
$table->id(); // Crée une colonne 'id' auto-incrémentée
```

### **Clé Étrangère (Foreign Key)**
Colonne qui **référence** la clé primaire d'une **autre table**.
```php
$table->foreignId('category_id')
    ->constrained('categories')
    ->onDelete('cascade');
```

### **belongsTo (Appartient à)**
Relation **Many-to-One** : plusieurs enregistrements appartiennent à un seul.
```php
class Livre extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

// Usage
$livre = Livre::find(1);
echo $livre->category->nom; // Accès à la catégorie
```

### **hasMany (Possède plusieurs)**
Relation **One-to-Many** : un enregistrement possède plusieurs autres.
```php
class Category extends Model
{
    public function livres()
    {
        return $this->hasMany(Livre::class);
    }
}

// Usage
$category = Category::find(1);
echo $category->livres->count(); // Nombre de livres
```

### **Eager Loading**
Technique pour **charger les relations** en même temps que le modèle principal.
```php
// ✅ Une seule requête pour livres + catégories
$livres = Livre::with('category')->get();
```

### **Lazy Loading**
Chargement des relations **à la demande** (peut causer le problème N+1).
```php
// ❌ Une requête par livre pour récupérer sa catégorie
$livres = Livre::all();
foreach ($livres as $livre) {
    echo $livre->category->nom; // Requête à chaque itération
}
```

---

## 🌱 Seeders

### **Seeder**
Classe qui **peuple** la base de données avec des **données de test**.
```php
class LivreSeeder extends Seeder
{
    public function run()
    {
        Livre::create([
            'titre' => 'Laravel Guide',
            'auteur' => 'John Doe'
        ]);
    }
}
```

### **Factory**
Générateur de **données factices** pour les tests.
```php
class LivreFactory extends Factory
{
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'auteur' => $this->faker->name(),
        ];
    }
}
```

### **DatabaseSeeder**
Seeder **principal** qui orchestre l'exécution des autres seeders.
```php
public function run()
{
    $this->call([
        CategorySeeder::class,
        LivreSeeder::class,
    ]);
}
```

---

## 🔍 Requêtes et Scopes

### **Scope**
Méthode qui **encapsule** une logique de requête réutilisable.
```php
class Livre extends Model
{
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }
    
    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'like', "%{$terme}%");
    }
}

// Usage
$livres = Livre::disponible()->recherche('Laravel')->get();
```

### **Mass Assignment**
Capacité d'**assigner** plusieurs attributs en **une seule opération**.
```php
class Livre extends Model
{
    protected $fillable = ['titre', 'auteur', 'category_id'];
}

// Création avec mass assignment
$livre = Livre::create([
    'titre' => 'Test',
    'auteur' => 'Auteur',
    'category_id' => 1
]);
```

### **Guarded**
Attributs **protégés** contre le mass assignment.
```php
protected $guarded = ['id', 'created_at', 'updated_at'];
```

---

## ⚙️ Types de Colonnes

### **Types Numériques**
```php
$table->id();                    // BIGINT UNSIGNED AUTO_INCREMENT
$table->integer('pages');        // INT
$table->decimal('prix', 8, 2);   // DECIMAL(8,2)
$table->boolean('disponible');   // TINYINT(1)
```

### **Types Textuels**
```php
$table->string('titre');         // VARCHAR(255)
$table->string('isbn', 20);      // VARCHAR(20)
$table->text('description');     // TEXT
$table->longText('contenu');     // LONGTEXT
```

### **Types Temporels**
```php
$table->timestamps();            // created_at, updated_at
$table->timestamp('publié_at');  // TIMESTAMP
$table->date('date_publication'); // DATE
$table->year('annee');           // YEAR
```

### **Modificateurs**
```php
$table->string('email')->unique();     // Contrainte d'unicité
$table->text('bio')->nullable();       // Valeur NULL autorisée
$table->string('nom')->default('N/A'); // Valeur par défaut
$table->string('slug')->index();       // Index pour performances
```

---

## 🛡️ Sécurité et Contraintes

### **Contrainte d'Intégrité**
Règle qui assure la **cohérence** des données.
```php
$table->foreignId('category_id')
    ->constrained()                    // Référence categories.id
    ->onDelete('cascade');             // Suppression en cascade
```

### **Validation**
Vérification des données **avant** insertion en base.
```php
$request->validate([
    'titre' => 'required|string|max:255',
    'category_id' => 'required|exists:categories,id'
]);
```

### **Fillable vs Guarded**
Protection contre les **assignments malveillants**.
```php
// Approche positive (recommandée)
protected $fillable = ['titre', 'auteur'];

// Approche négative
protected $guarded = ['id', 'created_at'];
```

---

## 📊 Performance et Optimisation

### **Index**
Structure qui **accélère** les requêtes de recherche.
```php
$table->string('email')->index();        // Index simple
$table->index(['nom', 'prenom']);        // Index composé
$table->string('slug')->unique();        // Index unique
```

### **Problème N+1**
**Multiplication** des requêtes lors du parcours de relations.
```php
// ❌ Problème N+1 (1 + N requêtes)
$livres = Livre::all();
foreach ($livres as $livre) {
    echo $livre->category->nom;
}

// ✅ Solution avec Eager Loading (2 requêtes)
$livres = Livre::with('category')->get();
foreach ($livres as $livre) {
    echo $livre->category->nom;
}
```

### **Query Log**
**Enregistrement** des requêtes SQL pour debug.
```php
DB::enableQueryLog();
// Votre code Eloquent
$queries = DB::getQueryLog();
```

---

## 🎯 Conventions Laravel

### **Nommage des Tables**
- **Pluriel** et **snake_case** : `categories`, `livres`, `users`
- **Tables pivot** : `category_livre` (ordre alphabétique)

### **Nommage des Colonnes**
- **snake_case** : `created_at`, `category_id`, `is_available`
- **Clés étrangères** : `{table_singular}_id` → `category_id`

### **Nommage des Modèles**
- **Singulier** et **PascalCase** : `Category`, `Livre`, `User`
- **Correspond à la table** : `Category` ↔ `categories`

### **Nommage des Relations**
```php
// belongsTo : singulier
public function category()

// hasMany : pluriel  
public function livres()

// Nom basé sur le modèle cible
public function category() // retourne Category
public function livres()   // retourne Collection de Livre
```

---

## 🔧 Outils de Debug

### **Tinker**
**Console interactive** PHP pour tester le code.
```bash
php artisan tinker
>>> App\Models\Livre::count()
>>> $livre = App\Models\Livre::first()
>>> $livre->category
```

### **Log des Requêtes**
```php
// Activer le logging
\DB::listen(function ($query) {
    \Log::info($query->sql, $query->bindings);
});
```

### **Debug Bar (Package)**
Interface graphique pour **analyser** les performances.
```bash
composer require barryvdh/laravel-debugbar --dev
```

---

## ✅ Checklist Vocabulaire

### **📚 Termes de Base**
- [ ] SQLite, SGBD, Table, Schéma
- [ ] Migration, Rollback, Fresh
- [ ] ORM, Modèle, Active Record

### **🔗 Relations**
- [ ] Clé primaire, Clé étrangère
- [ ] belongsTo, hasMany
- [ ] Eager Loading, Lazy Loading

### **🌱 Données**
- [ ] Seeder, Factory, Mass Assignment
- [ ] Fillable, Guarded, Scope

### **⚡ Performance**
- [ ] Index, Problème N+1
- [ ] Query Builder, Query Log

---

**🎓 Félicitations ! Vous maîtrisez maintenant le vocabulaire essentiel de la séance 2.**

> 📖 **Prochaine étape :** [03-TP-DECOUVERTE-DATABASE.md](03-TP-DECOUVERTE-DATABASE.md) pour mettre en pratique ces concepts !
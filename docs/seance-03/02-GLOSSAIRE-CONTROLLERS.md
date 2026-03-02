# 📚 Glossaire Controllers & Vues - Séance 03

**Dictionnaire des termes essentiels pour les contrôleurs et système de vues Laravel**

---

## 🎭 Contrôleurs (Controllers)

### **Controller**
Classe PHP qui **reçoit les requêtes**, **traite la logique** et **renvoie une réponse**. Centre de l'architecture MVC.
```php
class LivreController extends Controller
{
    public function index() {
        return view('livres.index');
    }
}
```

### **Resource Controller**
Contrôleur qui implémente automatiquement les **7 actions CRUD** standards.
```bash
# Génération automatique
php artisan make:controller LivreController --resource
```
**Actions générées :** `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`

### **Action**
**Méthode publique** d'un contrôleur qui traite une requête spécifique.
```php
// Action pour afficher la liste des livres
public function index() {
    $livres = Livre::all();
    return view('livres.index', compact('livres'));
}
```

### **Route Model Binding**
Laravel **inject automatiquement** le modèle dans l'action du contrôleur.
```php
// Au lieu de :
public function show($id) {
    $livre = Livre::findOrFail($id);
}

// Laravel fait automatiquement :
public function show(Livre $livre) {
    // $livre est déjà chargé
}
```

---

## 🛣️ Routage Avancé

### **Route Resource**
Route qui **génère automatiquement** toutes les routes CRUD pour un contrôleur resource.
```php
// Une seule ligne génère 7 routes
Route::resource('livres', LivreController::class);

// Équivaut à :
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
// ... + 5 autres routes
```

### **Route Name (Nom de Route)**
**Alias** donné à une route pour la référencer facilement.
```php
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');

// Utilisation dans les vues
<a href="{{ route('livres.index') }}">Catalogue</a>
```

### **Route Parameter (Paramètre de Route)**
**Variable** dans l'URL qui est passée au contrôleur.
```php
Route::get('/livres/{livre}', [LivreController::class, 'show']);
// {livre} est le paramètre, automatiquement injecté
```

---

## 🎨 Système de Vues (Views)

### **Blade Template**
**Moteur de templates** de Laravel pour créer des vues dynamiques.
```blade
{{-- Commentaire Blade --}}
<h1>{{ $titre }}</h1>  {{-- Affichage sécurisé --}}
{!! $html !!}          {{-- Affichage HTML brut --}}
```

### **Layout**
**Template principal** qui définit la structure commune des pages.
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head><title>@yield('title')</title></head>
<body>
    @yield('content')
</body>
</html>
```

### **Section**
**Zone définie** dans un layout qui peut être remplie par les vues enfants.
```blade
{{-- Dans le layout --}}
@yield('content')

{{-- Dans la vue enfant --}}
@section('content')
    <h1>Contenu de la page</h1>
@endsection
```

### **Component (Composant)**
**Élément réutilisable** qui peut être inclus dans plusieurs vues.
```blade
{{-- Définition : resources/views/components/livre-card.blade.php --}}
@props(['livre'])
<div class="card">
    <h5>{{ $livre->titre }}</h5>
</div>

{{-- Utilisation --}}
<x-livre-card :livre="$livre" />
```

### **Directive Blade**
**Instruction spéciale** Blade qui génère du PHP.
```blade
@if($condition)         {{-- if --}}
@foreach($items as $item)  {{-- foreach --}}
@auth                   {{-- if(auth()->check()) --}}
@csrf                   {{-- Token CSRF --}}
```

---

## 📝 Formulaires et Validation

### **CRUD**
**C**reate (Créer), **R**ead (Lire), **U**pdate (Mettre à jour), **D**elete (Supprimer).
Quatre opérations de base sur les données.

### **Request Validation**
**Validation automatique** des données soumises par un formulaire.
```php
$validated = $request->validate([
    'titre' => 'required|string|max:255',
    'isbn' => 'required|unique:livres|size:13'
]);
```

### **Validation Rule (Règle de Validation)**
**Contrainte** appliquée à un champ de formulaire.
- `required` : Obligatoire
- `string` : Doit être une chaîne
- `max:255` : Maximum 255 caractères
- `unique:table` : Unique dans la table
- `exists:table,column` : Doit exister dans la table

### **CSRF Token**
**Jeton de sécurité** qui protège contre les attaques Cross-Site Request Forgery.
```blade
<form method="POST">
    @csrf  {{-- Génère le token CSRF --}}
    <!-- Champs du formulaire -->
</form>
```

### **Method Spoofing**
Technique pour **simuler** les méthodes HTTP PUT/DELETE dans les formulaires HTML.
```blade
<form method="POST" action="{{ route('livres.update', $livre) }}">
    @csrf
    @method('PUT')  {{-- Simule PUT --}}
    <!-- Champs du formulaire -->
</form>
```

---

## 💬 Messages et Redirections

### **Flash Message**
**Message temporaire** stocké en session pour être affiché après une redirection.
```php
return redirect()
    ->route('livres.index')
    ->with('success', 'Livre créé avec succès !');
```

### **Session**
**Stockage temporaire** de données côté serveur entre les requêtes.
```php
// Stocker
session(['key' => 'value']);

// Récupérer
$value = session('key');

// Flash (une seule fois)
session()->flash('message', 'Succès !');
```

### **Redirect**
**Redirection** vers une autre page après traitement.
```php
// Redirection vers route nommée
return redirect()->route('livres.index');

// Redirection arrière
return redirect()->back();

// Redirection avec données
return redirect()->back()->withInput();
```

### **Old Input**
**Données précédemment saisies** conservées après une erreur de validation.
```blade
{{-- Récupère la valeur précédente ou vide --}}
<input value="{{ old('titre') }}">

{{-- Avec valeur par défaut --}}
<input value="{{ old('titre', $livre->titre) }}">
```

---

## 📊 Pagination et Recherche

### **Pagination**
**Division** des résultats en plusieurs pages pour améliorer les performances.
```php
// Dans le contrôleur
$livres = Livre::paginate(12);

// Dans la vue
{{ $livres->links() }}
```

### **Query Builder**
**Interface fluide** pour construire des requêtes SQL complexes.
```php
$livres = Livre::where('disponible', true)
    ->whereHas('categorie', function($query) {
        $query->where('actif', true);
    })
    ->orderBy('titre')
    ->get();
```

### **Scope**
**Méthode réutilisable** pour filtrer les requêtes Eloquent.
```php
// Dans le modèle Livre
public function scopeDisponible($query) {
    return $query->where('disponible', true);
}

// Utilisation
$livres = Livre::disponible()->get();
```

### **Eager Loading**
**Chargement anticipé** des relations pour éviter le problème N+1.
```php
// Problème N+1 (1 requête + N requêtes pour les catégories)
$livres = Livre::all();
foreach($livres as $livre) {
    echo $livre->categorie->nom; // Requête à chaque itération
}

// Solution : Eager Loading (2 requêtes seulement)
$livres = Livre::with('categorie')->get();
```

---

## 🎨 Interface Utilisateur

### **Bootstrap**
**Framework CSS** pour créer rapidement des interfaces responsives.
```html
<div class="container">
    <div class="row">
        <div class="col-md-6">Contenu</div>
    </div>
</div>
```

### **Responsive Design**
**Design adaptatif** qui s'ajuste automatiquement à toutes les tailles d'écran.
```html
{{-- Classes Bootstrap responsives --}}
<div class="col-12 col-md-6 col-lg-4">
    <!-- Mobile: 100%, Tablette: 50%, Desktop: 33% -->
</div>
```

### **Alert**
**Message d'information** affiché à l'utilisateur.
```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
```

### **Modal**
**Fenêtre popup** pour afficher du contenu par-dessus la page.
```html
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Confirmation</h5>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce livre ?
            </div>
        </div>
    </div>
</div>
```

---

## 🔧 Outils de Développement

### **Artisan**
**Interface en ligne de commande** de Laravel pour automatiser les tâches.
```bash
php artisan make:controller    # Créer un contrôleur
php artisan route:list        # Lister les routes
php artisan serve            # Démarrer le serveur
```

### **Tinker**
**Console interactive** pour tester du code Laravel en temps réel.
```bash
php artisan tinker
>>> $livre = Livre::first()
>>> $livre->titre
```

### **Debugbar**
**Barre d'outils** pour déboguer les requêtes, performances et variables.
```bash
composer require barryvdh/laravel-debugbar --dev
```

### **Log**
**Enregistrement** des événements et erreurs de l'application.
```php
Log::info('Livre créé', ['livre_id' => $livre->id]);
Log::error('Erreur de validation', ['errors' => $errors]);
```

---

## 🔒 Sécurité

### **Mass Assignment**
**Protection** contre l'affectation en masse non autorisée.
```php
class Livre extends Model {
    // Champs autorisés à la modification
    protected $fillable = ['titre', 'auteur', 'isbn'];
    
    // Champs protégés
    protected $guarded = ['id', 'created_at'];
}
```

### **SQL Injection**
**Attaque** consistant à injecter du code SQL malveillant. Eloquent protège automatiquement.
```php
// ✅ Sécurisé avec Eloquent
Livre::where('titre', $userInput)->get();

// ❌ Vulnérable
DB::select("SELECT * FROM livres WHERE titre = '$userInput'");
```

### **XSS (Cross-Site Scripting)**
**Attaque** par injection de code JavaScript. Blade échappe automatiquement.
```blade
{{-- ✅ Sécurisé (échappé automatiquement) --}}
<p>{{ $userContent }}</p>

{{-- ❌ Dangereux (non échappé) --}}
<p>{!! $userContent !!}</p>
```

---

## 📱 Performance

### **Caching**
**Mise en cache** pour améliorer les performances.
```php
// Cache pendant 1 heure
$livres = Cache::remember('livres.all', 3600, function() {
    return Livre::all();
});
```

### **Database Index**
**Index** pour accélérer les requêtes sur certaines colonnes.
```php
// Dans une migration
$table->string('isbn')->index();
$table->index(['titre', 'auteur']); // Index composé
```

### **Lazy Loading**
**Chargement différé** des relations pour optimiser les performances.
```php
// Ne charge la relation que si elle est utilisée
$livre->categorie; // Requête exécutée ici
```

---

## 🎯 Conventions Laravel

### **Naming Conventions**
**Conventions de nommage** Laravel pour maintenir la cohérence.

| Élément | Convention | Exemple |
|---------|------------|---------|
| **Controller** | Singulier + Controller | `LivreController` |
| **Model** | Singulier | `Livre` |
| **Table** | Pluriel | `livres` |
| **Route** | Pluriel | `Route::resource('livres')` |
| **Vue** | Pluriel/action | `livres/index.blade.php` |

### **RESTful Routes**
**Architecture REST** pour organiser les routes de manière logique.

| Verbe HTTP | URI | Action | Route Name |
|------------|-----|--------|------------|
| GET | `/livres` | index | livres.index |
| GET | `/livres/create` | create | livres.create |
| POST | `/livres` | store | livres.store |
| GET | `/livres/{id}` | show | livres.show |
| GET | `/livres/{id}/edit` | edit | livres.edit |
| PUT/PATCH | `/livres/{id}` | update | livres.update |
| DELETE | `/livres/{id}` | destroy | livres.destroy |

---

## ⚡ Conseils de Performance

### **N+1 Problem**
**Problème** de performance causé par des requêtes multiples non optimisées.
```php
// ❌ Problème N+1
$livres = Livre::all(); // 1 requête
foreach($livres as $livre) {
    echo $livre->categorie->nom; // N requêtes
}

// ✅ Solution
$livres = Livre::with('categorie')->all(); // 2 requêtes
```

### **Select Specific Columns**
**Sélectionner** seulement les colonnes nécessaires.
```php
// ❌ Toutes les colonnes
$livres = Livre::all();

// ✅ Colonnes spécifiques
$livres = Livre::select(['id', 'titre', 'auteur'])->get();
```

### **Chunk**
**Traiter** de gros volumes de données par petits blocs.
```php
// Pour traiter 1 million de livres
Livre::chunk(100, function($livres) {
    foreach($livres as $livre) {
        // Traitement
    }
});
```
# 🎓 Solution - Séance 3: Controllers & Views Avancées

**Durée:** 7 heures  
**Compétences:** Contrôleurs Resource, Vues Blade complexes, Validation, Route Model Binding  

---

## 📁 Structure des Solutions

```
solutions/seance-03/
├── README.md (ce fichier)
├── app/Http/Controllers/
│   ├── LivreController.php (Resource Controller complet)
│   └── CategorieController.php (Resource Controller)
├── resources/views/
│   ├── livres/
│   │   ├── index.blade.php (Liste paginée)
│   │   ├── show.blade.php (Détails)
│   │   ├── create.blade.php (Formulaire création)
│   │   ├── edit.blade.php (Formulaire édition)
│   │   └── _form.blade.php (Partial réutilisable)
│   └── components/
│       ├── alert.blade.php (Messages flash)
│       └── pagination.blade.php (Pagination personnalisée)
└── routes/
    └── web.php (Routes resources)
```

---

## 🎯 Concepts Clés Appliqués

### 1️⃣ Contrôleurs Resource
- 7 actions CRUD : index, create, store, show, edit, update, destroy
- Route : `Route::resource('livres', LivreController::class)`
- Génération automatique : `php artisan make:controller LivreController --resource`
- Convention RESTful

### 2️⃣ Validation Laravel
- Règles de validation : `required`, `max`, `min`, `email`, `unique`, etc.
- Méthode `$request->validate()`
- Messages d'erreurs personnalisés
- Affichage avec `@error` en Blade

### 3️⃣ Route Model Binding
- Injection automatique du modèle dans le contrôleur
- `public function show(Livre $livre)` au lieu de `show($id)`
- Simplification du code
- 404 automatique si non trouvé

### 4️⃣ Vues Blade Avancées
- Layouts et sections
- Composants réutilisables
- Directives : `@foreach`, `@if`, `@empty`, `@auth`
- Inclusion de partials : `@include`
- Slots et composants

### 5️⃣ Messages Flash
- `session()->flash('success', 'Message')`
- `redirect()->with('success', 'Message')`
- Affichage avec `@if(session('success'))`
- Composant Alert réutilisable

---

## ✅ Auto-Évaluation

### Niveau 1 - CRUD Basique (Essentiel)
- [ ] Je sais créer un Resource Controller
- [ ] Je comprends les 7 actions : index, create, store, show, edit, update, destroy
- [ ] Je sais créer une vue index avec liste de livres
- [ ] Je sais créer une vue show pour afficher un livre
- [ ] Je sais créer un formulaire dans create.blade.php
- [ ] Je sais valider les données avec `$request->validate()`
- [ ] Je sais sauvegarder avec `Livre::create()`
- [ ] Je sais rediriger avec message flash

**Validation:** Créer un CRUD complet pour les catégories

### Niveau 2 - Blade & Validation (Important)
- [ ] Je sais utiliser Route Model Binding
- [ ] Je sais créer un partial réutilisable (_form.blade.php)
- [ ] Je sais inclure un partial avec `@include`
- [ ] Je comprends la différence entre `create()` et `store()`
- [ ] Je sais afficher les erreurs de validation avec `@error`
- [ ] Je sais paginer les résultats avec `->paginate(10)`
- [ ] Je sais créer un composant Blade (Alert, Card, etc)
- [ ] Je sais utiliser les directives `@empty`, `@forelse`

**Validation:** Créer un formulaire avec validation pour ajouter un livre avec catégorie

### Niveau 3 - Fonctionnalités Avancées (Bonus)
- [ ] Je sais implémenter une recherche avec formulaire GET
- [ ] Je sais filtrer par catégorie avec dropdown
- [ ] Je sais trier (ordre alphabétique, date, etc)
- [ ] Je sais utiliser les Form Requests pour validation complexe
- [ ] Je sais créer des composants Blade avec slots
- [ ] Je comprends les Policy pour l'autorisation
- [ ] Je sais optimiser les requêtes avec eager loading

**Validation:** Ajouter recherche + filtre + tri sur la liste des livres

---

## 🚀 Extensions Possibles

### Extension 1: Recherche Avancée
**Objectif:** Implémenter une barre de recherche avec filtres multiples

**Contrôleur:**
```php
public function index(Request $request)
{
    $query = Livre::query();
    
    // Recherche par titre
    if ($request->has('search')) {
        $query->where('titre', 'like', '%' . $request->search . '%');
    }
    
    // Filtre par catégorie
    if ($request->has('categorie_id')) {
        $query->where('categorie_id', $request->categorie_id);
    }
    
    // Tri
    $query->orderBy($request->get('sort', 'titre'));
    
    return view('livres.index', [
        'livres' => $query->paginate(10)
    ]);
}
```

**Vue:**
```blade
<form method="GET" action="{{ route('livres.index') }}">
    <input type="text" name="search" value="{{ request('search') }}">
    <select name="categorie_id">
        <option value="">Toutes catégories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nom }}
            </option>
        @endforeach
    </select>
    <button type="submit">Rechercher</button>
</form>
```

---

### Extension 2: Composants Blade Avancés
**Objectif:** Créer des composants réutilisables pour le formulaire

**Création du composant:**
```bash
php artisan make:component Forms/Input
```

**Component Class (app/View/Components/Forms/Input.php):**
```php
class Input extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public ?string $value = null
    ) {}
    
    public function render()
    {
        return view('components.forms.input');
    }
}
```

**Component View (resources/views/components/forms/input.blade.php):**
```blade
<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        class="form-control @error($name) is-invalid @enderror"
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

**Utilisation:**
```blade
<x-forms.input name="titre" label="Titre du livre" />
<x-forms.input name="auteur" label="Auteur" />
```

---

### Extension 3: Form Request Validation
**Objectif:** Externaliser la validation dans une classe dédiée

**Création:**
```bash
php artisan make:request StoreLivreRequest
```

**Form Request (app/Http/Requests/StoreLivreRequest.php):**
```php
class StoreLivreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou auth()->check()
    }
    
    public function rules(): array
    {
        return [
            'titre' => 'required|max:255',
            'auteur' => 'required|max:255',
            'annee_publication' => 'required|integer|min:1800|max:' . date('Y'),
            'categorie_id' => 'required|exists:categories,id',
            'resume' => 'nullable|max:1000'
        ];
    }
    
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire',
            'annee_publication.max' => 'L\'année ne peut pas être dans le futur',
        ];
    }
}
```

**Contrôleur:**
```php
public function store(StoreLivreRequest $request)
{
    // Les données sont déjà validées !
    $livre = Livre::create($request->validated());
    
    return redirect()->route('livres.show', $livre)
        ->with('success', 'Livre ajouté avec succès');
}
```

---

### Extension 4: Soft Deletes (Suppression douce)
**Objectif:** Marquer les livres comme supprimés sans les supprimer physiquement

**Migration:**
```php
Schema::table('livres', function (Blueprint $table) {
    $table->softDeletes(); // Ajoute deleted_at
});
```

**Model:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Livre extends Model
{
    use SoftDeletes;
}
```

**Contrôleur:**
```php
// Suppression douce
public function destroy(Livre $livre)
{
    $livre->delete(); // Marque deleted_at
    return redirect()->route('livres.index')
        ->with('success', 'Livre supprimé');
}

// Récupérer les supprimés
public function trashed()
{
    $livres = Livre::onlyTrashed()->get();
    return view('livres.trashed', compact('livres'));
}

// Restaurer
public function restore($id)
{
    Livre::withTrashed()->find($id)->restore();
    return redirect()->route('livres.index')
        ->with('success', 'Livre restauré');
}

// Suppression définitive
public function forceDelete($id)
{
    Livre::withTrashed()->find($id)->forceDelete();
    return redirect()->route('livres.trashed')
        ->with('success', 'Livre supprimé définitivement');
}
```

---

## 📊 Checklist Finale

**Fonctionnalités CRUD:**
- [ ] Liste de tous les livres (index)
- [ ] Détails d'un livre (show)
- [ ] Formulaire d'ajout (create + store)
- [ ] Formulaire d'édition (edit + update)
- [ ] Suppression (destroy)

**Validation:**
- [ ] Titre requis (max 255)
- [ ] Auteur requis
- [ ] Année entre 1800 et aujourd'hui
- [ ] Catégorie doit exister
- [ ] Affichage des erreurs

**UX & Design:**
- [ ] Messages flash (succès, erreur)
- [ ] Pagination
- [ ] Modale de confirmation suppression
- [ ] Design Bootstrap responsive
- [ ] Breadcrumbs de navigation

**Bonus:**
- [ ] Recherche par titre
- [ ] Filtre par catégorie
- [ ] Tri (titre, auteur, année)
- [ ] Composants Blade réutilisables
- [ ] Soft deletes avec corbeille

---

## 🎓 Ressources Complémentaires

- [Laravel Controllers Documentation](https://laravel.com/docs/controllers)
- [Laravel Validation Documentation](https://laravel.com/docs/validation)
- [Blade Templates Documentation](https://laravel.com/docs/blade)
- [Laravel Responses & Redirects](https://laravel.com/docs/responses)
- [Route Model Binding](https://laravel.com/docs/routing#route-model-binding)

---

**🎉 Bravo ! Vous maîtrisez maintenant les contrôleurs Resource et les vues Blade avancées.**

**Prochaine étape :** Séance 4 - Authentification & Autorisations

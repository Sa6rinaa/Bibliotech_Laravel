# 🛠️ TP Pratique : Contrôleurs & Vues Avancées

**Créer un système complet de gestion des livres avec interface utilisateur**

---

## 🎯 Objectifs du TP

À la fin de ce TP, vous aurez créé :
- ✅ **Contrôleur resource complet** pour les livres
- ✅ **7 vues Blade** correspondant aux actions CRUD
- ✅ **Formulaires de création/modification** avec validation
- ✅ **Messages flash** pour le feedback utilisateur
- ✅ **Interface responsive** avec Bootstrap
- ✅ **Navigation** fluide entre les pages

**⏱️ Durée estimée :** 90 minutes (3 modules de 30 min chacun)

---

## 🚀 Prérequis

### **✅ Vérifications Initiales**

```bash
# 1. S'assurer d'être sur la bonne branche
git branch
# Devrait afficher : * seance-03-controllers-views

# 2. Vérifier la base de données
php artisan migrate:status

# 3. Vérifier les données existantes
php artisan tinker
>>> App\Models\Livre::count()
>>> App\Models\Categorie::count()
>>> exit
```

**📝 Si aucune donnée :**
```bash
php artisan migrate:fresh --seed
```

---

## 📋 Module 1 : Contrôleur Resource (30 min)

### **🎯 Objectif :** Créer et configurer un contrôleur resource complet

### **🔧 Étape 1.1 : Génération du Contrôleur**

```bash
# Générer le contrôleur avec toutes les méthodes CRUD
php artisan make:controller LivreController --resource --model=Livre
```

**📍 Localisation :** `app/Http/Controllers/LivreController.php`

**🔍 Vérification :**
```bash
# Vérifier que le fichier a été créé
ls -la app/Http/Controllers/LivreController.php

# Examiner la structure générale
head -20 app/Http/Controllers/LivreController.php
```

### **🔧 Étape 1.2 : Configurer les Routes**

**📝 Modifier le fichier `routes/web.php` :**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes resource pour les livres
Route::resource('livres', LivreController::class);

// Autres routes existantes...
```

**🔍 Vérification :**
```bash
# Lister les nouvelles routes
php artisan route:list --path=livres
```

**📝 Résultat attendu :**
```
+--------+-----------+----------------------+---------------+---------+
| Domain | Method    | URI                  | Name          | Action  |
+--------+-----------+----------------------+---------------+---------+
|        | GET|HEAD  | livres               | livres.index  | ...     |
|        | POST      | livres               | livres.store  | ...     |
|        | GET|HEAD  | livres/create        | livres.create | ...     |
|        | GET|HEAD  | livres/{livre}       | livres.show   | ...     |
|        | PUT|PATCH | livres/{livre}       | livres.update | ...     |
|        | DELETE    | livres/{livre}       | livres.destroy| ...     |
|        | GET|HEAD  | livres/{livre}/edit  | livres.edit   | ...     |
+--------+-----------+----------------------+---------------+---------+
```

### **🔧 Étape 1.3 : Implémenter les Méthodes du Contrôleur**

**📝 Remplacer le contenu de `app/Http/Controllers/LivreController.php` :**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    /**
     * Afficher la liste des livres
     */
    public function index()
    {
        $livres = Livre::with('categorie')->orderBy('titre')->paginate(12);
        $categories = Categorie::orderBy('nom')->get();
        
        return view('livres.index', compact('livres', 'categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('livres.create', compact('categories'));
    }

    /**
     * Sauvegarder un nouveau livre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255', // 📝 Note: En séance 4, nous transformerons ceci en relation vers un modèle Auteur
            'isbn' => 'required|string|unique:livres|size:13',
            'categorie_id' => 'required|exists:categories,id',
            'resume' => 'nullable|string|max:1000',
            'date_publication' => 'required|date|before_or_equal:today',
            'pages' => 'required|integer|min:1|max:9999',
            'disponible' => 'boolean'
        ]);

        $livre = Livre::create($validated);

        return redirect()
            ->route('livres.show', $livre)
            ->with('success', 'Livre créé avec succès !');
    }

    /**
     * Afficher un livre spécifique
     */
    public function show(Livre $livre)
    {
        return view('livres.show', compact('livre'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Livre $livre)
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('livres.edit', compact('livre', 'categories'));
    }

    /**
     * Mettre à jour un livre
     */
    public function update(Request $request, Livre $livre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255', // 📝 Note: En séance 4, nous transformerons ceci en relation vers un modèle Auteur
            'isbn' => 'required|string|size:13|unique:livres,isbn,' . $livre->id,
            'categorie_id' => 'required|exists:categories,id',
            'resume' => 'nullable|string|max:1000',
            'date_publication' => 'required|date|before_or_equal:today',
            'pages' => 'required|integer|min:1|max:9999',
            'disponible' => 'boolean'
        ]);

        $livre->update($validated);

        return redirect()
            ->route('livres.show', $livre)
            ->with('success', 'Livre mis à jour avec succès !');
    }

    /**
     * Supprimer un livre
     */
    public function destroy(Livre $livre)
    {
        $livre->delete();

        return redirect()
            ->route('livres.index')
            ->with('success', 'Livre supprimé avec succès !');
    }
}
```

**🔍 Vérification :**
```bash
# Tester que les routes ne génèrent plus d'erreur
php artisan route:list --path=livres
```

---

## 🎨 Module 2 : Vues et Templates (30 min)

### **🎯 Objectif :** Créer toutes les vues Blade avec un design moderne

💡 **ASTUCE GAIN DE TEMPS** : Des templates de démarrage sont fournis dans `resources/views/templates/` !  
Vous pouvez les copier et les adapter au lieu de partir de zéro. Gain estimé : **15-20 minutes** ⚡

```bash
# Copier les templates (optionnel)
cp resources/views/templates/index.blade.php resources/views/livres/index.blade.php
cp resources/views/templates/show.blade.php resources/views/livres/show.blade.php
cp resources/views/templates/create.blade.php resources/views/livres/create.blade.php
cp resources/views/templates/edit.blade.php resources/views/livres/edit.blade.php
```

### **🔧 Étape 2.1 : Créer la Structure des Vues**

```bash
# Créer le dossier livres
mkdir -p resources/views/livres
```

### **🔧 Étape 2.2 : Vue Index (Liste des Livres)**

**📝 Créer `resources/views/livres/index.blade.php` :**

```blade
@extends('layouts.app')

@section('title', 'Catalogue des Livres')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>📚 Catalogue des Livres</h1>
                <a href="{{ route('livres.create') }}" class="btn btn-success">
                    ➕ Ajouter un livre
                </a>
            </div>
        </div>
    </div>

    {{-- Formulaire de recherche --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('livres.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Rechercher un livre ou un auteur...">
                    </div>
                    <div class="col-md-4">
                        <select name="categorie" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" 
                                        {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">🔍 Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des livres --}}
    <div class="row">
        @forelse($livres as $livre)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $livre->titre }}</h5>
                        <p class="card-text">
                            <strong>👤 Auteur :</strong> {{ $livre->auteur }}<br>
                            <strong>📂 Catégorie :</strong> 
                            <span class="badge bg-info">{{ $livre->categorie->nom }}</span><br>
                            <strong>📄 Pages :</strong> {{ $livre->pages }}<br>
                            <strong>📅 Publication :</strong> {{ $livre->date_publication->format('Y') }}
                        </p>
                        <div class="mt-auto">
                            @if($livre->disponible)
                                <span class="badge bg-success mb-2">✅ Disponible</span>
                            @else
                                <span class="badge bg-danger mb-2">❌ Indisponible</span>
                            @endif
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('livres.show', $livre) }}" 
                                   class="btn btn-primary btn-sm">👁️ Voir</a>
                                <a href="{{ route('livres.edit', $livre) }}" 
                                   class="btn btn-secondary btn-sm">✏️ Modifier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>📭 Aucun livre trouvé</h4>
                    <p>Il n'y a actuellement aucun livre dans le catalogue.</p>
                    <a href="{{ route('livres.create') }}" class="btn btn-success">
                        Ajouter le premier livre
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($livres->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $livres->withQueryString()->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
```

### **🔧 Étape 2.3 : Vue Show (Détail d'un Livre)**

**📝 Créer `resources/views/livres/show.blade.php` :**

```blade
@extends('layouts.app')

@section('title', $livre->titre . ' - Détail')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>📖 {{ $livre->titre }}</h2>
                        <div class="btn-group">
                            <a href="{{ route('livres.edit', $livre) }}" class="btn btn-warning">
                                ✏️ Modifier
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>👤 Auteur :</strong> {{ $livre->auteur }}</p>
                            <p><strong>📂 Catégorie :</strong> 
                               <span class="badge bg-info">{{ $livre->categorie->nom }}</span></p>
                            <p><strong>📄 Pages :</strong> {{ $livre->pages }}</p>
                            <p><strong>📅 Date de publication :</strong> 
                               {{ $livre->date_publication->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>📚 ISBN :</strong> {{ $livre->isbn }}</p>
                            <p><strong>📊 Statut :</strong> 
                                @if($livre->disponible)
                                    <span class="badge bg-success">✅ Disponible</span>
                                @else
                                    <span class="badge bg-danger">❌ Indisponible</span>
                                @endif
                            </p>
                            <p><strong>🕒 Ajouté le :</strong> 
                               {{ $livre->created_at->format('d/m/Y à H:i') }}</p>
                            <p><strong>🔄 Modifié le :</strong> 
                               {{ $livre->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($livre->resume)
                        <hr>
                        <h5>📝 Résumé</h5>
                        <p class="text-muted">{{ $livre->resume }}</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                        ⬅️ Retour au catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de confirmation de suppression --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">⚠️ Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le livre <strong>"{{ $livre->titre }}"</strong> ?</p>
                <p class="text-danger">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('livres.destroy', $livre) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">🗑️ Supprimer définitivement</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

### **🔧 Étape 2.4 : Vue Create (Formulaire de Création)**

**📝 Créer `resources/views/livres/create.blade.php` :**

```blade
@extends('layouts.app')

@section('title', 'Ajouter un Livre')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2>➕ Ajouter un Nouveau Livre</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.store') }}" method="POST">
                        @csrf
                        
                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label">📖 Titre *</label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre') }}"
                                   placeholder="Entrez le titre du livre">
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Auteur --}}
                        <div class="mb-3">
                            <label for="auteur" class="form-label">👤 Auteur *</label>
                            <input type="text" 
                                   class="form-control @error('auteur') is-invalid @enderror" 
                                   id="auteur" 
                                   name="auteur" 
                                   value="{{ old('auteur') }}"
                                   placeholder="Nom de l'auteur">
                            @error('auteur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ISBN --}}
                        <div class="mb-3">
                            <label for="isbn" class="form-label">📚 ISBN (13 chiffres) *</label>
                            <input type="text" 
                                   class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn') }}"
                                   placeholder="9780123456789"
                                   maxlength="13">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catégorie --}}
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">📂 Catégorie *</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    name="categorie_id" id="categorie_id">
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Pages --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pages" class="form-label">📄 Nombre de pages *</label>
                                    <input type="number" 
                                           class="form-control @error('pages') is-invalid @enderror" 
                                           id="pages" 
                                           name="pages" 
                                           value="{{ old('pages') }}"
                                           min="1" max="9999"
                                           placeholder="250">
                                    @error('pages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date de publication --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_publication" class="form-label">📅 Date de publication *</label>
                                    <input type="date" 
                                           class="form-control @error('date_publication') is-invalid @enderror" 
                                           id="date_publication" 
                                           name="date_publication" 
                                           value="{{ old('date_publication') }}"
                                           max="{{ date('Y-m-d') }}">
                                    @error('date_publication')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Disponibilité --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="disponible" 
                                       name="disponible" 
                                       value="1"
                                       {{ old('disponible', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponible">
                                    ✅ Livre disponible
                                </label>
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="mb-3">
                            <label for="resume" class="form-label">📝 Résumé (optionnel)</label>
                            <textarea class="form-control @error('resume') is-invalid @enderror" 
                                      id="resume" 
                                      name="resume" 
                                      rows="4"
                                      placeholder="Résumé du livre...">{{ old('resume') }}</textarea>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                                ⬅️ Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                ✅ Créer le livre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## 🔧 Module 3 : Finalisation et Tests (30 min)

### **🎯 Objectif :** Compléter les vues restantes et tester l'ensemble

### **🔧 Étape 3.1 : Vue Edit (Formulaire de Modification)**

**📝 Créer `resources/views/livres/edit.blade.php` :**

```blade
@extends('layouts.app')

@section('title', 'Modifier - ' . $livre->titre)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2>✏️ Modifier "{{ $livre->titre }}"</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.update', $livre) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label">📖 Titre *</label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre', $livre->titre) }}">
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Auteur --}}
                        <div class="mb-3">
                            <label for="auteur" class="form-label">👤 Auteur *</label>
                            <input type="text" 
                                   class="form-control @error('auteur') is-invalid @enderror" 
                                   id="auteur" 
                                   name="auteur" 
                                   value="{{ old('auteur', $livre->auteur) }}">
                            @error('auteur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ISBN --}}
                        <div class="mb-3">
                            <label for="isbn" class="form-label">📚 ISBN (13 chiffres) *</label>
                            <input type="text" 
                                   class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn', $livre->isbn) }}"
                                   maxlength="13">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catégorie --}}
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">📂 Catégorie *</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    name="categorie_id" id="categorie_id">
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                            {{ old('categorie_id', $livre->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Pages --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pages" class="form-label">📄 Nombre de pages *</label>
                                    <input type="number" 
                                           class="form-control @error('pages') is-invalid @enderror" 
                                           id="pages" 
                                           name="pages" 
                                           value="{{ old('pages', $livre->pages) }}"
                                           min="1" max="9999">
                                    @error('pages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date de publication --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_publication" class="form-label">📅 Date de publication *</label>
                                    <input type="date" 
                                           class="form-control @error('date_publication') is-invalid @enderror" 
                                           id="date_publication" 
                                           name="date_publication" 
                                           value="{{ old('date_publication', $livre->date_publication->format('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}">
                                    @error('date_publication')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Disponibilité --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="disponible" 
                                       name="disponible" 
                                       value="1"
                                       {{ old('disponible', $livre->disponible) ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponible">
                                    ✅ Livre disponible
                                </label>
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="mb-3">
                            <label for="resume" class="form-label">📝 Résumé (optionnel)</label>
                            <textarea class="form-control @error('resume') is-invalid @enderror" 
                                      id="resume" 
                                      name="resume" 
                                      rows="4">{{ old('resume', $livre->resume) }}</textarea>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-secondary">
                                ⬅️ Annuler
                            </a>
                            <button type="submit" class="btn btn-warning">
                                ✏️ Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

### **🔧 Étape 3.2 : Améliorer le Layout Principal**

**📝 Modifier `resources/views/layouts/app.blade.php` pour ajouter les messages flash :**

```blade
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BiblioTech')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">📚 BiblioTech</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('livres.index') }}">📖 Catalogue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('livres.create') }}">➕ Ajouter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        {{-- Messages Flash --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✅ Succès !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>❌ Erreur !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>⚠️ Attention !</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

### **🔧 Étape 3.3 : Configurer le Modèle Livre**

**📝 Vérifier `app/Models/Livre.php` :**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'categorie_id',
        'resume',
        'date_publication',
        'pages',
        'disponible'
    ];

    protected $casts = [
        'date_publication' => 'date',
        'disponible' => 'boolean'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
```

### **🔧 Étape 3.4 : Tests Complets**

**🧪 Série de Tests à Effectuer :**

```bash
# 1. Démarrer le serveur
php artisan serve
```

**🌐 Tests dans le navigateur :**

1. **Page d'accueil :** http://localhost:8000/livres
   - ✅ Liste des livres s'affiche
   - ✅ Bouton "Ajouter un livre" visible
   - ✅ Pagination fonctionne (si plus de 12 livres)

2. **Création d'un livre :** Cliquer sur "Ajouter un livre"
   - ✅ Formulaire s'affiche correctement
   - ✅ Validation fonctionne (tester avec des données invalides)
   - ✅ Création réussie avec message de succès

3. **Visualisation :** Cliquer sur "Voir" d'un livre
   - ✅ Toutes les informations s'affichent
   - ✅ Boutons "Modifier" et "Supprimer" présents

4. **Modification :** Cliquer sur "Modifier"
   - ✅ Formulaire pré-rempli avec les données existantes
   - ✅ Modification sauvegardée avec succès

5. **Suppression :** Tester la suppression avec confirmation
   - ✅ Modal de confirmation s'affiche
   - ✅ Suppression effective après confirmation

**📝 Tests de Validation :**

```
# Tester ces cas d'erreur :
- Titre vide
- ISBN avec moins/plus de 13 caractères
- ISBN déjà existant
- Date de publication future
- Nombre de pages négatif
```

### **🔧 Étape 3.5 : Vérification Finale**

```bash
# Vérifier que tout fonctionne
php artisan route:list --path=livres

# Tester via Tinker
php artisan tinker
>>> $livre = App\Models\Livre::with('categorie')->first()
>>> $livre->titre
>>> $livre->categorie->nom
>>> exit
```

---

## ✅ Checklist de Validation

**Cochez chaque élément une fois terminé :**

### **🏗️ Structure**
- [ ] Contrôleur `LivreController` créé avec 7 méthodes
- [ ] Routes resource configurées dans `web.php`
- [ ] 4 vues créées (index, show, create, edit)
- [ ] Layout amélioré avec messages flash

### **🎨 Interface**
- [ ] Design Bootstrap responsive
- [ ] Navigation entre les pages fluide
- [ ] Formulaires avec validation visuelle
- [ ] Messages de succès/erreur affichés

### **🔧 Fonctionnalités**
- [ ] Liste des livres avec pagination
- [ ] Détail d'un livre complet
- [ ] Création avec validation complète
- [ ] Modification avec pré-remplissage
- [ ] Suppression avec confirmation

### **🧪 Tests**
- [ ] Toutes les pages se chargent sans erreur
- [ ] Validation fonctionne (côtés client et serveur)
- [ ] Messages flash s'affichent correctement
- [ ] Interface responsive sur mobile

---

## 🚀 Pour Aller Plus Loin

### **🎯 Améliorations Suggérées**

1. **Recherche avancée** avec filtres multiples
2. **Upload d'images** de couverture
3. **Tri** par colonnes (titre, auteur, date)
4. **Export** de la liste en PDF/Excel
5. **Gestion de stock** avec quantités

### **🔗 Prochaines Étapes**

Vous êtes maintenant prêt pour :
- **Module 05** : Exercices avancés autonomes
- **Module 06** : Évaluation des compétences
- **Séance 04** : Authentification et autorisations

🎉 **Félicitations !** Vous maîtrisez maintenant les contrôleurs resource et le système de vues Laravel !
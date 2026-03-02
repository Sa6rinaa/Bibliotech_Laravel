# 💪 TP Pratique : Exercices Avancés Autonomes

**3 modules d'exercices progressifs et pédagogiques pour maîtriser les contrôleurs et vues**

---

## 🎯 Objectifs Généraux

À la fin de ces exercices, vous serez capable de :
- ✅ **Implémenter une recherche** multi-critères avec filtres
- ✅ **Créer des composants** Blade réutilisables
- ✅ **Maîtriser la validation** avancée avec Form Requests

**⏱️ Durée recommandée :** 45 minutes (3 modules de 15 min)
**🎓 Niveau :** Autonome (solutions disponibles séparément)
**📝 Planning suggéré :**
- **Débutants** : Module 1 uniquement (15 min)
- **Intermédiaires** : Modules 1-2 (30 min)
- **Confirmés** : Modules 1-2-3 (45 min)

💡 **Note pédagogique** : Chaque module explique d'abord les **concepts théoriques** avant de passer à la **pratique**.

---

## 📋 Vue d'Ensemble des Modules

```
🚀 EXERCICES PROGRESSIFS (45 min)
│
├── 📊 Module 1: Recherche et Filtres (15 min)
│   ├── 📖 Concepts: Query Builder, Request parameters, Pagination
│   └── 🛠️ Pratique: Recherche texte + filtre catégorie
│
├── 🎨 Module 2: Composants Blade (15 min)
│   ├── 📖 Concepts: Blade Components, Props, Slots
│   └── 🛠️ Pratique: Composant carte livre réutilisable
│
└── ✅ Module 3: Validation Avancée (15 min)
    ├── 📖 Concepts: Form Requests, Règles custom
    └── 🛠️ Pratique: Validation ISBN avec Form Request
```

---

## 📊 Module 1 : Recherche et Filtres (15 min)

### **📖 Partie 1 : Comprendre les Concepts (5 min)**

#### **� Concept 1 : Query Builder Dynamique**

Le **Query Builder** de Laravel permet de construire des requêtes SQL de manière progressive :

```php
// ❌ MAUVAISE APPROCHE : Requête fixe
$livres = Livre::all(); // Récupère TOUJOURS tous les livres

// ✅ BONNE APPROCHE : Query Builder dynamique
$query = Livre::query(); // Crée une requête vide

if ($request->filled('search')) {
    $query->where('titre', 'LIKE', '%' . $request->search . '%');
}

$livres = $query->get(); // Exécute la requête construite
```

**💡 Pourquoi c'est utile ?**
- Permet d'ajouter des filtres **conditionnellement**
- Évite la duplication de code
- Plus performant (ne charge que les données nécessaires)

#### **🎓 Concept 2 : Request Parameters**

Les paramètres d'URL permettent de passer des données via GET :

```php
// URL : /livres?search=Laravel&categorie=1

// Dans le contrôleur :
$request->filled('search')    // true si paramètre existe ET non vide
$request->has('search')       // true si paramètre existe (même vide)
$request->get('search')       // Récupère la valeur
$request->get('sort', 'titre') // Avec valeur par défaut
```

#### **🎓 Concept 3 : Pagination avec Filtres**

La pagination doit **conserver les paramètres** de recherche :

```php
// ❌ PROBLÈME : Les filtres disparaissent au changement de page
$livres = $query->paginate(10);

// ✅ SOLUTION : Utiliser appends() pour conserver les paramètres
$livres = $query->paginate(10)->appends($request->all());

// Dans la vue, les liens de pagination incluront : ?search=Laravel&page=2
```

---

### **🛠️ Partie 2 : Exercice Pratique (10 min)**

#### **📝 Exercice 1.1 : Recherche Simple**

**Objectif** : Permettre de chercher un livre par titre ou auteur

**Étape 1** : Modifier la méthode `index` du `LivreController`

```php
public function index(Request $request)
{
    // 1. Créer une requête de base avec la relation categorie
    $query = Livre::with('categorie');
    
    // 2. TODO: Ajouter la recherche si le paramètre 'search' existe
    if ($request->filled('search')) {
        $search = $request->search;
        
        // Rechercher dans titre OU auteur (insensible à la casse)
        $query->where(function($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
              ->orWhere('auteur', 'LIKE', "%{$search}%");
        });
    }
    
    // 3. TODO: Exécuter la requête avec pagination (10 par page)
    $livres = $query->orderBy('titre')->paginate(10);
    
    // 4. TODO: Ajouter les paramètres de recherche aux liens de pagination
    $livres->appends($request->all());
    
    return view('livres.index', compact('livres'));
}
```

**💡 Explication du code :**
- `where(function($q) {...})` : Groupe les conditions avec des parenthèses SQL
- `LIKE "%{$search}%"` : Recherche partielle (contient le texte)
- `appends($request->all())` : Conserve ?search=... dans les liens de pagination

---

#### **📝 Exercice 1.2 : Filtre par Catégorie**

**Objectif** : Ajouter un filtre pour afficher uniquement les livres d'une catégorie

```php
public function index(Request $request)
{
    $query = Livre::with('categorie');
    
    // Recherche (code précédent)
    if ($request->filled('search')) {
        // ... (code de l'exercice 1.1)
    }
    
    // TODO: Filtre par catégorie
    if ($request->filled('categorie_id')) {
        $query->where('categorie_id', $request->categorie_id);
    }
    
    $livres = $query->orderBy('titre')->paginate(10)->appends($request->all());
    
    // TODO: Récupérer toutes les catégories pour le formulaire
    $categories = Categorie::orderBy('nom')->get();
    
    return view('livres.index', compact('livres', 'categories'));
}
```

---

#### **📝 Exercice 1.3 : Formulaire de Recherche**

**Objectif** : Créer le formulaire HTML pour la recherche et les filtres

**Créer dans `resources/views/livres/index.blade.php` :**

```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>📚 Liste des Livres</h1>
    
    {{-- Formulaire de recherche --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('livres.index') }}">
                <div class="row g-3">
                    {{-- Champ de recherche --}}
                    <div class="col-md-6">
                        <label for="search" class="form-label">🔍 Rechercher</label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               placeholder="Titre ou auteur..."
                               value="{{ request('search') }}">
                    </div>
                    
                    {{-- Filtre catégorie --}}
                    <div class="col-md-4">
                        <label for="categorie_id" class="form-label">📂 Catégorie</label>
                        <select class="form-select" id="categorie_id" name="categorie_id">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" 
                                        {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Boutons --}}
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            Rechercher
                        </button>
                        <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                            Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Résultats --}}
    <div class="card">
        <div class="card-header">
            <strong>{{ $livres->total() }}</strong> livre(s) trouvé(s)
        </div>
        <div class="card-body">
            {{-- TODO: Afficher la liste des livres (tableau ou cartes) --}}
            @forelse($livres as $livre)
                {{-- Affichage de chaque livre --}}
            @empty
                <p class="text-muted">Aucun livre trouvé.</p>
            @endforelse
            
            {{-- Pagination --}}
            <div class="mt-3">
                {{ $livres->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
```

**� Points clés à comprendre :**
- `request('search')` : Récupère la valeur du paramètre pour pré-remplir le formulaire
- `{{ request('categorie_id') == $categorie->id ? 'selected' : '' }}` : Maintient la sélection
- `{{ $livres->total() }}` : Affiche le nombre total de résultats
- `{{ $livres->links() }}` : Génère les liens de pagination avec les filtres

---

### **✅ Vérification du Module 1**

**Checklist de validation :**
- [ ] La recherche fonctionne sur titre ET auteur
- [ ] Le filtre catégorie fonctionne
- [ ] Les filtres persistent lors du changement de page
- [ ] Le bouton "Réinitialiser" supprime tous les filtres
- [ ] Le nombre total de résultats s'affiche correctement

---

## 🎨 Module 2 : Composants Blade Réutilisables (15 min)

### **📖 Partie 1 : Comprendre les Concepts (5 min)**

#### **� Concept 1 : Qu'est-ce qu'un Composant Blade ?**

Un **composant Blade** est un **morceau de vue réutilisable** avec sa propre logique.

**Exemple concret :**
Imaginez que vous affichez des cartes de livres à 5 endroits différents (page d'accueil, recherche, catégorie, favoris, nouveautés). Sans composant :

```blade
{{-- ❌ Code DUPLIQUÉ 5 fois --}}
<div class="card">
    <div class="card-body">
        <h5>{{ $livre->titre }}</h5>
        <p>{{ $livre->auteur }}</p>
        <span class="badge bg-primary">{{ $livre->categorie->nom }}</span>
    </div>
</div>
```

Avec un composant :

```blade
{{-- ✅ Code RÉUTILISABLE partout --}}
<x-livre-card :livre="$livre" />
```

**💡 Avantages :**
- **DRY** (Don't Repeat Yourself) : Pas de duplication
- **Maintenabilité** : Une modification = tous les endroits sont mis à jour
- **Lisibilité** : Code plus clair et concis

#### **🎓 Concept 2 : Props (Propriétés)**

Les **props** sont les **paramètres** qu'on passe au composant.

```blade
{{-- Passer des données au composant --}}
<x-livre-card 
    :livre="$livre"           {{-- Variable PHP (avec :) --}}
    show-actions="true"       {{-- Valeur texte (sans :) --}}
    size="large"
/>
```

Dans le composant, on déclare les props acceptées :

```php
@props([
    'livre',              // Obligatoire
    'showActions' => true, // Optionnel avec valeur par défaut
    'size' => 'medium'
])
```

#### **🎓 Concept 3 : Structure d'un Composant**

Un composant Blade est un fichier dans `resources/views/components/` :

```
resources/views/components/
├── livre-card.blade.php    → Utilisé avec <x-livre-card />
├── alert.blade.php         → Utilisé avec <x-alert />
└── navigation/
    └── menu.blade.php      → Utilisé avec <x-navigation.menu />
```

---

### **🛠️ Partie 2 : Exercice Pratique (10 min)**

#### **📝 Exercice 2.1 : Créer un Composant Carte Livre**

**Objectif** : Créer un composant réutilisable pour afficher une carte de livre

**Étape 1** : Créer le fichier `resources/views/components/livre-card.blade.php`

```blade
{{-- 
    Composant Carte Livre
    Usage : <x-livre-card :livre="$livre" />
--}}

@props([
    'livre',                    // Le modèle Livre (obligatoire)
    'showActions' => true,      // Afficher les boutons d'action
    'compact' => false          // Mode compact (moins de détails)
])

<div class="card h-100 shadow-sm hover-shadow">
    {{-- En-tête avec catégorie --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>📚 {{ $livre->categorie->nom ?? 'Sans catégorie' }}</span>
        
        {{-- Badge disponibilité --}}
        @if($livre->disponible ?? true)
            <span class="badge bg-success">Disponible</span>
        @else
            <span class="badge bg-secondary">Emprunté</span>
        @endif
    </div>
    
    {{-- Corps de la carte --}}
    <div class="card-body">
        {{-- Titre --}}
        <h5 class="card-title">{{ $livre->titre }}</h5>
        
        {{-- Auteur --}}
        <p class="card-text text-muted mb-2">
            <strong>Auteur :</strong> {{ $livre->auteur }}
        </p>
        
        {{-- Résumé (seulement si mode non compact) --}}
        @if(!$compact && isset($livre->resume))
            <p class="card-text small">
                {{ Str::limit($livre->resume, 100) }}
            </p>
        @endif
        
        {{-- ISBN (seulement si mode non compact) --}}
        @if(!$compact && isset($livre->isbn))
            <p class="card-text small text-muted">
                <strong>ISBN :</strong> {{ $livre->isbn }}
            </p>
        @endif
    </div>
    
    {{-- Actions --}}
    @if($showActions)
        <div class="card-footer bg-light d-flex gap-2">
            <a href="{{ route('livres.show', $livre) }}" 
               class="btn btn-sm btn-primary flex-fill">
                👁️ Voir
            </a>
            <a href="{{ route('livres.edit', $livre) }}" 
               class="btn btn-sm btn-warning flex-fill">
                ✏️ Modifier
            </a>
        </div>
    @endif
</div>

{{-- Styles pour l'effet hover --}}
@once
@push('styles')
<style>
    .hover-shadow {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
</style>
@endpush
@endonce
```

**💡 Explication du code :**
- `@props([...])` : Déclare les propriétés acceptées
- `{{ $livre->categorie->nom ?? 'Sans catégorie' }}` : Affiche la catégorie ou valeur par défaut
- `@if(!$compact)` : Affiche conditionnellement selon le mode
- `Str::limit($livre->resume, 100)` : Tronque le texte à 100 caractères
- `@once @push('styles')` : Ajoute le CSS une seule fois (même si composant utilisé plusieurs fois)

---

#### **📝 Exercice 2.2 : Utiliser le Composant**

**Objectif** : Remplacer le code HTML répété par le composant

**Dans `resources/views/livres/index.blade.php` :**

```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>📚 Liste des Livres</h1>
    
    {{-- ... Formulaire de recherche (Module 1) ... --}}
    
    {{-- Résultats en grille de cartes --}}
    <div class="row g-3">
        @forelse($livres as $livre)
            <div class="col-md-4">
                {{-- ✅ Utilisation du composant --}}
                <x-livre-card :livre="$livre" />
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center">Aucun livre trouvé.</p>
            </div>
        @endforelse
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $livres->links() }}
    </div>
</div>
@endsection
```

**Exemples d'utilisation avec différentes options :**

```blade
{{-- Mode normal avec actions --}}
<x-livre-card :livre="$livre" />

{{-- Mode compact sans actions --}}
<x-livre-card :livre="$livre" :show-actions="false" compact />

{{-- Compact avec actions --}}
<x-livre-card :livre="$livre" :compact="true" />
```

---

#### **📝 Exercice 2.3 : Créer un Composant Alert Réutilisable**

**Objectif** : Créer un composant pour les messages flash

**Créer `resources/views/components/alert.blade.php` :**

```blade
@props([
    'type' => 'info',  // success, danger, warning, info
    'dismissible' => true,
    'icon' => null
])

@php
    // Mapper les types aux icônes
    $icons = [
        'success' => '✅',
        'danger' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️'
    ];
    $displayIcon = $icon ?? $icons[$type] ?? 'ℹ️';
@endphp

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    <strong>{{ $displayIcon }}</strong> {{ $slot }}
    
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @endif
</div>
```

**Utilisation dans les vues :**

```blade
{{-- Message de succès --}}
<x-alert type="success">
    Le livre a été créé avec succès !
</x-alert>

{{-- Message d'erreur non dismissible --}}
<x-alert type="danger" :dismissible="false">
    Une erreur est survenue.
</x-alert>

{{-- Avec messages flash --}}
@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif
```

---

### **✅ Vérification du Module 2**

**Checklist de validation :**
- [ ] Le composant `livre-card` affiche correctement toutes les informations
- [ ] L'effet hover fonctionne (carte se soulève au survol)
- [ ] Les boutons "Voir" et "Modifier" fonctionnent
- [ ] Le mode compact masque bien le résumé et l'ISBN
- [ ] Le composant `alert` affiche les messages avec les bonnes couleurs

**📝 Créer `resources/views/components/form-field.blade.php` :**

```blade
@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'options' => [],
    'required' => false,
    'help' => null
])

{{-- TODO: Composant générique pour : --}}
{{-- 1. Input text, number, date, email --}}
{{-- 2. Textarea --}}
{{-- 3. Select avec options --}}
{{-- 4. Checkbox --}}
{{-- 5. Gestion automatique des erreurs --}}
{{-- 6. Texte d'aide optionnel --}}
```

---

## ✅ Module 3 : Validation Avancée avec Form Requests (15 min)

### **📖 Partie 1 : Comprendre les Concepts (5 min)**

#### **🎓 Concept 1 : Pourquoi utiliser des Form Requests ?**

**Sans Form Request** (validation dans le contrôleur) :

```php
// ❌ PROBLÈME : Code de validation mélangé avec la logique métier
public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|max:255',
        'auteur' => 'required|max:255',
        'isbn' => 'required|size:13|unique:livres',
        // ... 10 autres règles
    ]);
    
    Livre::create($validated);
    // ... autres actions
}

// Si on veut les mêmes règles pour update() → DUPLICATION
```

**Avec Form Request** (validation séparée) :

```php
// ✅ SOLUTION : Validation isolée et réutilisable
public function store(StoreLivreRequest $request)
{
    Livre::create($request->validated());
    // Contrôleur plus court et lisible
}
```

**💡 Avantages :**
- **Séparation des responsabilités** : Validation ≠ Logique métier
- **Réutilisabilité** : Même validation pour store() et update()
- **Testabilité** : Plus facile à tester
- **Autorisation intégrée** : Peut inclure `authorize()`

#### **🎓 Concept 2 : Structure d'une Form Request**

```php
class StoreLivreRequest extends FormRequest
{
    // 1. Autorisation : Qui peut utiliser ce formulaire ?
    public function authorize()
    {
        return true; // ou Auth::check()
    }
    
    // 2. Règles de validation
    public function rules()
    {
        return [
            'titre' => 'required|max:255',
        ];
    }
    
    // 3. Messages personnalisés (optionnel)
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire',
        ];
    }
}
```

#### **🎓 Concept 3 : Règles de Validation Personnalisées**

Laravel permet de créer vos propres règles :

```php
// Règle inline (simple)
'isbn' => ['required', function ($attribute, $value, $fail) {
    if (!$this->validateIsbn($value)) {
        $fail("L'ISBN $value n'est pas valide.");
    }
}]

// Règle dédiée (réutilisable)
'isbn' => ['required', new ValidIsbn]
```

---

### **🛠️ Partie 2 : Exercice Pratique (10 min)**

#### **📝 Exercice 3.1 : Créer une Form Request**

**Objectif** : Déplacer la validation du contrôleur vers une Form Request

**Étape 1** : Générer la Form Request

```bash
php artisan make:request StoreLivreRequest
```

**Étape 2** : Implémenter `app/Http/Requests/StoreLivreRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivreRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        // TODO: Retourner true pour autoriser tout le monde
        // Dans une vraie app, vérifier les permissions : Auth::user()->can('create', Livre::class)
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'titre' => [
                'required',
                'string',
                'max:255',
            ],
            'auteur' => [
                'required',
                'string',
                'max:255',
            ],
            'isbn' => [
                'required',
                'string',
                'size:13',        // ISBN-13 fait exactement 13 chiffres
                'unique:livres',  // Doit être unique dans la table livres
                'regex:/^\d+$/',  // Uniquement des chiffres
            ],
            'resume' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'date_publication' => [
                'nullable',
                'date',
                'before_or_equal:today', // Pas de date future
            ],
            'categorie_id' => [
                'required',
                'exists:categories,id', // Doit exister dans la table categories
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés en français
     */
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser :max caractères.',
            
            'auteur.required' => 'L\'auteur est obligatoire.',
            'auteur.max' => 'Le nom de l\'auteur ne peut pas dépasser :max caractères.',
            
            'isbn.required' => 'L\'ISBN est obligatoire.',
            'isbn.size' => 'L\'ISBN doit contenir exactement 13 chiffres.',
            'isbn.unique' => 'Cet ISBN existe déjà dans la base de données.',
            'isbn.regex' => 'L\'ISBN ne doit contenir que des chiffres.',
            
            'date_publication.before_or_equal' => 'La date de publication ne peut pas être dans le futur.',
            
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'Cette catégorie n\'existe pas.',
        ];
    }

    /**
     * Noms d'attributs personnalisés pour les messages
     */
    public function attributes(): array
    {
        return [
            'titre' => 'titre du livre',
            'auteur' => 'nom de l\'auteur',
            'isbn' => 'ISBN',
            'categorie_id' => 'catégorie',
        ];
    }
}
```

**� Explication du code :**
- `authorize()` : Contrôle d'accès (true = tout le monde peut créer un livre)
- `rules()` : Toutes les règles de validation
- `messages()` : Messages personnalisés en français
- `attributes()` : Noms d'attributs pour des messages plus clairs
- `size:13` : Longueur exacte (ISBN-13)
- `exists:categories,id` : Vérifie que la catégorie existe
- `before_or_equal:today` : Date ≤ aujourd'hui

---

#### **📝 Exercice 3.2 : Utiliser la Form Request dans le Contrôleur**

**Objectif** : Remplacer `Request` par `StoreLivreRequest`

**Modifier `app/Http/Controllers/LivreController.php` :**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use App\Http\Requests\StoreLivreRequest; // ← Importer la Form Request
use Illuminate\Http\Request;

class LivreController extends Controller
{
    // ... autres méthodes (index, create, show) ...
    
    /**
     * Enregistrer un nouveau livre
     */
    public function store(StoreLivreRequest $request) // ← Remplacer Request
    {
        // ✅ Plus besoin de $request->validate() !
        // La validation est déjà faite automatiquement par Laravel
        
        // Créer le livre avec les données validées
        $livre = Livre::create($request->validated());
        
        // Message flash de succès
        return redirect()
            ->route('livres.show', $livre)
            ->with('success', 'Le livre "' . $livre->titre . '" a été créé avec succès !');
    }
}
```

**💡 Comment ça fonctionne ?**

1. **Laravel intercepte** la requête avant qu'elle n'arrive au contrôleur
2. **Exécute automatiquement** `authorize()` et `rules()`
3. **Si validation échoue** : Redirige vers le formulaire avec les erreurs
4. **Si validation réussit** : Passe au contrôleur avec `$request->validated()`

---

#### **📝 Exercice 3.3 : Créer une Règle de Validation Custom pour ISBN**

**Objectif** : Valider le checksum de l'ISBN-13 (algorithme de vérification)

**Étape 1** : Créer la règle personnalisée

```bash
php artisan make:rule ValidIsbn
```

**Étape 2** : Implémenter `app/Rules/ValidIsbn.php`

```php
<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIsbn implements ValidationRule
{
    /**
     * Valide un ISBN-13
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Vérifier que c'est bien 13 chiffres
        if (!preg_match('/^\d{13}$/', $value)) {
            $fail("L'ISBN doit contenir exactement 13 chiffres.");
            return;
        }
        
        // Calculer le checksum ISBN-13
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $value[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }
        
        $checksum = (10 - ($sum % 10)) % 10;
        $lastDigit = (int) $value[12];
        
        // Vérifier si le dernier chiffre correspond au checksum
        if ($lastDigit !== $checksum) {
            $fail("L'ISBN $value n'est pas valide (checksum incorrect).");
        }
    }
}
```

**Étape 3** : Utiliser la règle dans la Form Request

```php
// Dans StoreLivreRequest.php
use App\Rules\ValidIsbn;

public function rules(): array
{
    return [
        // ... autres champs ...
        
        'isbn' => [
            'required',
            'string',
            'unique:livres',
            new ValidIsbn, // ← Utiliser la règle personnalisée
        ],
    ];
}
```

**💡 Explication de l'algorithme ISBN-13 :**
- On multiplie les chiffres pairs par 1, les impairs par 3
- On additionne le tout
- Le dernier chiffre doit faire en sorte que la somme soit divisible par 10

**Exemple avec ISBN valide : 9782100547357**
```
9×1 + 7×3 + 8×1 + 2×3 + 1×1 + 0×3 + 0×1 + 5×3 + 4×1 + 7×3 + 3×1 + 5×3 = 113
Checksum = (10 - (113 % 10)) % 10 = 7 ✅
```

---

### **✅ Vérification du Module 3**

**Checklist de validation :**
- [ ] La Form Request `StoreLivreRequest` est créée et fonctionne
- [ ] Tous les champs sont validés avec les bonnes règles
- [ ] Les messages d'erreur s'affichent en français
- [ ] La règle personnalisée `ValidIsbn` fonctionne
- [ ] Le contrôleur `store()` utilise `StoreLivreRequest` au lieu de `Request`
- [ ] Tester avec un ISBN invalide : l'erreur s'affiche

---

## 🎯 Récapitulatif des 3 Modules

### **📊 Ce que vous avez appris**

| Module | Concepts | Compétences |
|--------|----------|-------------|
| **1. Recherche** | Query Builder, Request params, Pagination | Filtres dynamiques, URL persistantes |
| **2. Composants** | Blade Components, Props, Slots | Code réutilisable, DRY |
| **3. Validation** | Form Requests, Règles custom | Validation robuste, Séparation logique |

### **✅ Barème de Notation (sur 15 points)**

| Critère | Points | Description |
|---------|---------|-------------|
| **Module 1** | 5 pts | Recherche + Filtre catégorie fonctionnels |
| **Module 2** | 5 pts | Composant livre-card réutilisable |
| **Module 3** | 5 pts | Form Request avec validation ISBN |
| **BONUS** | +2 pts | Règle ValidIsbn avec checksum |

### **🎯 Niveaux de Compétence (sur 15)**

- **13-15 pts** : Expert - Maîtrise complète des concepts avancés
- **10-12 pts** : Avancé - Bonnes pratiques respectées
- **7-9 pts** : Intermédiaire - Fonctionnalités de base implémentées
- **< 7 pts** : Débutant - Réviser les concepts fondamentaux

---

## 📚 Ressources Complémentaires

### **Documentation Laravel**
- [Query Builder](https://laravel.com/docs/queries)
- [Blade Components](https://laravel.com/docs/blade#components)
- [Form Requests](https://laravel.com/docs/validation#form-request-validation)
- [Validation Rules](https://laravel.com/docs/validation#available-validation-rules)

### **Pour aller plus loin (optionnel)**
- 📖 **Module Bonus 1** : Optimisation des requêtes (Eager Loading, Select)
- 📖 **Module Bonus 2** : Export PDF/Excel (packages externes)
- 📖 **Module Bonus 3** : Cache Redis pour améliorer les performances

---

**💡 Conseil pédagogique** : Si vous bloquez sur un exercice, **relisez la partie théorique** (📖 Comprendre les Concepts) avant de passer à la pratique. Les concepts sont expliqués avec des exemples concrets pour faciliter la compréhension.

**Dernière mise à jour :** 6 octobre 2025

    }

    public function message()
    {
        return 'Le :attribute doit être un ISBN-13 valide.';
    }
}
```

### **🏗️ Exercice 3.3 : Validation Conditionnelle**

**📝 Objectifs à implémenter :**
- Si catégorie = "Roman", le résumé devient obligatoire
- Si pages > 1000, ajouter un champ "tome" obligatoire
**Dernière mise à jour :** 6 octobre 2025
<script>
// TODO: JavaScript pour auto-hide des toasts
</script>
@endpush
```

### **🏗️ Exercice 4.3 : Loading States et Feedback**

**📝 Objectifs :**
- Spinner de chargement lors des soumissions de formulaire
- Skeleton loading pour la liste des livres
- Feedback visuel pour les actions (boutons disabled, etc.)
- Confirmation inline pour les suppressions

---

## ⚡ Module 5 : Performance & Export (12 min)

### **🎯 Objectif :** Optimiser les performances et ajouter des fonctionnalités d'export

### **🏗️ Exercice 5.1 : Optimisation des Requêtes**

**📝 Améliorer les performances du contrôleur :**

```php
public function index(Request $request)
{
    // TODO: Optimisations à implémenter :
    // 1. Eager loading intelligent selon les besoins
    // 2. Cache des catégories (rarement modifiées)
    // 3. Requête optimisée pour le comptage
    // 4. Index de base de données pour la recherche
    
    $query = Livre::query();
    
    // TODO: N'inclure 'categorie' que si nécessaire
    // TODO: Utiliser select() pour limiter les colonnes
    // TODO: Cache pour les compteurs globaux
    
    return view('livres.index', compact('livres', 'categories'));
}
```

### **🏗️ Exercice 5.2 : Export PDF et Excel**

## ⚡ Module 5 : Performance & Export (30 min) 🏠 OPTIONNEL - BONUS MAISON

> **⚠️ ATTENTION** : Ce module est **OPTIONNEL** et doit être fait **à la maison** ou en dehors de la séance de 3h.  
> Il nécessite l'installation de packages externes (PDF/Excel) et des concepts avancés (Cache/Redis).  
> **Durée estimée :** 30-40 minutes (installation incluse)

### **🎯 Objectif :** Optimiser les performances et ajouter des fonctionnalités d'export avancées

### **🏗️ Exercice 5.1 : Optimisation des Requêtes**

**📝 Objectifs :**
- Utiliser `select()` pour limiter les colonnes chargées
- Implémenter le Eager Loading pour éviter le problème N+1
- Indexer les colonnes fréquemment recherchées
- Utiliser `chunk()` pour les gros volumes

**💡 Pourquoi c'est important ?**
- Réduction du temps de chargement de 50-80%
- Moins de consommation mémoire
- Meilleure expérience utilisateur

---

### **🏗️ Exercice 5.2 : Export PDF et Excel**

**📝 Installer les dépendances :**

```bash
# TODO: Installer les packages nécessaires
composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel
```

**📝 Créer les méthodes d'export :**

```php
// Dans LivreController
public function exportPdf(Request $request)
{
    // TODO: Générer un PDF avec la liste filtrée
    // 1. Récupérer les livres selon les filtres actuels
    // 2. Créer une vue spéciale pour PDF
    // 3. Générer et télécharger le PDF
}

public function exportExcel(Request $request)
{
    // TODO: Générer un Excel avec la liste filtrée
    // 1. Utiliser Laravel Excel
    // 2. Formater les données correctement
    // 3. Inclure des totaux et statistiques
}
```

### **🏗️ Exercice 5.3 : Cache et Mémorisation**

**📝 Objectifs :**
- Cache Redis/File pour les catégories
- Mémorisation des recherches fréquentes
- Cache des statistiques (nombre total de livres, etc.)
- Invalidation intelligente du cache

**💡 Ressources pour Module 5 :**
- Documentation Laravel Cache : https://laravel.com/docs/cache
- Laravel Excel : https://docs.laravel-excel.com/
- Laravel DomPDF : https://github.com/barryvdh/laravel-dompdf

---

## 🎯 Challenges Bonus (Optionnels - Hors Séance)

### **🚀 Challenge 1 : API REST**
Créer une API REST complète pour les livres avec :
- Endpoints CRUD complets
- Authentification par token
- Documentation Swagger
- Tests automatisés

### **🚀 Challenge 2 : Interface Administrative**
Développer un panneau d'administration avec :
- Dashboard avec statistiques
- Gestion en lot (bulk actions)
- Import CSV de livres
- Logs d'activité

### **🚀 Challenge 3 : Fonctionnalités Avancées**
Implémenter des fonctionnalités avancées :
- Système de tags/étiquettes
- Favoris utilisateur
- Recommandations intelligentes
- Historique de consultation

---

## ✅ Critères d'Évaluation

### **📊 Barème de Notation (sur 20 points)**

**⚠️ Module 5 exclu du barème principal (optionnel)**

| Critère | Points | Description |
|---------|---------|-------------|
| **Module 1** | 5 pts | Recherche et filtres fonctionnels |
| **Module 2** | 5 pts | Composants réutilisables et bien structurés |
| **Module 3** | 5 pts | Validation robuste et messages clairs |
| **Module 4** | 5 pts | Interface responsive et UX soignée |
| **Module 5** | **BONUS** | Optimisations et export (si fait à la maison) |

**💡 Note :** Le Module 5 peut rapporter des points bonus si réalisé en dehors de la séance.

### **🎯 Niveaux de Compétence (sur 20)**

- **16-20 pts :** Expert - Maîtrise complète des Modules 1-4
- **12-15 pts :** Avancé - Bonnes pratiques respectées
- **8-11 pts :** Intermédiaire - Fonctionnalités de base implémentées
- **4-7 pts :** Débutant - Travail à approfondir
- **0-3 pts :** Insuffisant - Revoir les concepts de base

---

## 🆘 Aide et Ressources

### **📚 Documentation Utile**
- [Laravel Validation](https://laravel.com/docs/validation)
- [Blade Components](https://laravel.com/docs/blade#components)
- [Eloquent Performance](https://laravel.com/docs/eloquent#eager-loading)
- [Laravel Excel Documentation](https://docs.laravel-excel.com)

### **💡 Conseils Généraux**
1. **Testez chaque module** avant de passer au suivant
2. **Utilisez Git** pour sauvegarder vos progrès
3. **Commentez votre code** pour expliquer vos choix
4. **Pensez mobile** dès le début
5. **Optimisez progressivement** (d'abord fonctionnel, puis performant)

### **🔧 Outils de Développement**
- **Laravel Debugbar** pour analyser les performances
- **Browser DevTools** pour tester le responsive
- **PHPStorm/VS Code** avec extensions Laravel
- **Postman** pour tester les APIs

---

## 🏁 Validation Finale

### **📋 Checklist de Livraison**

**Module 1 - Recherche :**
- [ ] Recherche multi-critères fonctionnelle
- [ ] Filtres par catégorie et disponibilité
- [ ] Tri dynamique par colonnes
- [ ] URL avec paramètres persistants

**Module 2 - Composants :**
- [ ] Composant livre-card réutilisable
- [ ] Pagination personnalisée
- [ ] Composants de formulaire génériques
- [ ] Styles CSS cohérents

**Module 3 - Validation :**
- [ ] Form Request classes implémentées
- [ ] Règles de validation personnalisées
- [ ] Messages d'erreur en français
- [ ] Validation conditionnelle

**Module 4 - Mobile :**
- [ ] Navigation mobile optimisée
- [ ] Interface responsive
- [ ] Notifications toast
- [ ] Loading states

**Module 5 - Performance :**
- [ ] Requêtes optimisées
- [ ] Export PDF/Excel
- [ ] Cache implémenté
- [ ] Performance mesurée

🎉 **Bravo !** Vous maîtrisez maintenant les aspects avancés des contrôleurs et vues Laravel !
# 🎓 Solution - Séance 1: Fondations Laravel + Docker

**Durée:** 6 heures  
**Compétences:** Architecture MVC, Routage, Vues Blade, Docker  

---

## 📁 Structure des Solutions

```
solutions/seance-01/
├── README.md (ce fichier)
├── routes/
│   └── web.php
├── app/Http/Controllers/
│   ├── HomeController.php
│   ├── LivreController.php
│   └── CategorieController.php
└── resources/views/
    ├── pages/
    │   ├── home.blade.php
    │   ├── livres.blade.php
    │   └── categories.blade.php
    └── layouts/
        └── app.blade.php
```

---

## 🎯 Concepts Clés Appliqués

### 1️⃣ Architecture MVC
- **Model** : représente les données (Livre, Categorie)
- **View** : affichage avec Blade (templates HTML)
- **Controller** : logique métier et requêtes

### 2️⃣ Routage
- Routes simples : `Route::get('/livres', ...)`
- Routes paramétrées : `Route::get('/livre/{id}', ...)`
- Groupes de routes : `Route::group()`
- Nommage : `->name('nom.route')`

### 3️⃣ Vues Blade
- Interpolation : `{{ $variable }}`
- Structures de contrôle : `@if`, `@foreach`, `@forelse`
- Commentaires : `{{-- ... --}}`
- Héritage : `@extends`, `@section`, `@yield`

### 4️⃣ Containers Docker
- Isolation environnement
- Multi-services (app + DB)
- Networks Docker

---

## ✅ Auto-Évaluation

### Niveau 1 - Fondations (Essentiel)
- [ ] Je comprends le pattern MVC et ses 3 couches
- [ ] Je sais créer une route simple
- [ ] Je sais créer une view et la lier à une route
- [ ] Je comprends la syntaxe Blade (@if, @foreach, etc)
- [ ] Je sais naviguer dans l'arborescence Laravel

**Validation:** Créer une route `/categorie/{id}` qui affiche le nom de la catégorie

### Niveau 2 - Intégration (Important)
- [ ] Je sais créer un controller avec une logique basique
- [ ] Je comprends le passage de données vue->controller->view
- [ ] Je sais utiliser les paramètres de route
- [ ] Je sais utiliser un layout avec sections
- [ ] Je comprends les URL nommées et le helper `route()`

**Validation:** Créer une page listant les livres avec détails

### Niveau 3 - Avancé (Bonus)
- [ ] Je sais utiliser les resource routes
- [ ] Je comprends le query builder Eloquent basique
- [ ] Je sais organiser mes vues avec des partials
- [ ] Je comprends les groupes de routes
- [ ] Je sais commenter mon code correctement

**Validation:** Implémenter les 5 exercices pratiques de la séance

---

## 🚀 Extensions Possibles

### Extension 1: Navigation Interactive
**Objectif:** Créer une navbar avec menu dynamique

```php
// Dans HomeController ou BaseController
$categories = Categorie::all();
return view('home', ['categories' => $categories]);
```

**Dans la navbar Blade:**
```blade
<nav>
    <a href="{{ route('home') }}">Accueil</a>
    @foreach ($categories as $cat)
        <a href="{{ route('categorie.show', $cat->id) }}">
            {{ $cat->nom }}
        </a>
    @endforeach
</nav>
```

**Compétences appliquées:** Requête Eloquent, boucles Blade, URL nommées

---

### Extension 2: Synthèse Statistiques
**Objectif:** Ajouter un dashboard avec stats

**Fichier:** `app/Http/Controllers/DashboardController.php`
```php
<?php
namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use App\Models\Utilisateur;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_livres' => Livre::count(),
            'total_categories' => Categorie::count(),
            'total_utilisateurs' => Utilisateur::count(),
            'categories' => Categorie::withCount('livres')
                ->orderByDesc('livres_count')
                ->take(5)
                ->get(),
        ];

        return view('dashboard', $stats);
    }
}
```

**Compétences appliquées:** withCount(), agrégation, tri, limite requête

---

### Extension 3: Recherche Simple
**Objectif:** Implémenter une recherche de livres

**Route:**
```php
Route::get('/search', [LivreController::class, 'search'])->name('search');
```

**Contrôleur:**
```php
public function search(Request $request)
{
    $query = $request->input('q');
    $livres = Livre::where('titre', 'LIKE', "%$query%")
        ->orWhere('auteur', 'LIKE', "%$query%")
        ->paginate(10);

    return view('search', [
        'livres' => $livres,
        'query' => $query
    ]);
}
```

**Compétences appliquées:** Requêtes GET, LIKE, OR conditions, pagination

---

### Extension 4: Filtrage par Catégorie
**Objectif:** Voir les livres d'une catégorie

**Route:**
```php
Route::get('/categorie/{id}/livres', [CategorieController::class, 'livres'])
    ->name('categorie.livres');
```

**Contrôleur:**
```php
public function livres($id)
{
    $categorie = Categorie::findOrFail($id);
    $livres = $categorie->livres()->paginate(15);
    
    return view('categorie.livres', [
        'categorie' => $categorie,
        'livres' => $livres
    ]);
}
```

**Compétences appliquées:** Relations Eloquent, routes implicites, 404 handling

---

### Extension 5: Système de Favoris (Frontend)
**Objectif:** Marquer des livres en favoris (stocké en localStorage)

**Dans la view:**
```blade
<button 
    class="btn-favorite" 
    data-id="{{ $livre->id }}"
    onclick="toggleFavorite({{ $livre->id }})"
>
    ⭐ Ajouter aux favoris
</button>

<script>
function toggleFavorite(id) {
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    const index = favorites.indexOf(id);
    
    if (index > -1) {
        favorites.splice(index, 1);
    } else {
        favorites.push(id);
    }
    
    localStorage.setItem('favorites', JSON.stringify(favorites));
}
</script>
```

**Compétences appliquées:** JavaScript basique, localStorage, événements

---

## 📊 Grille de Validation

| Compétence | Status | Points | Notes |
|---|---|---|---|
| MVC compris | ✅/❌ | /2 | |
| Routes fonctionnelles | ✅/❌ | /3 | |
| Vues Blade | ✅/❌ | /3 | |
| Controllers logique | ✅/❌ | /2 | |
| Extensions réalisées | ✅/❌ | /2 | Bonus |
| **TOTAL** | | **/12** | |

---

## 💡 Points d'Attention

### ❌ Erreurs Courantes
- Oublier `->name()` sur les routes
- Ne pas passer les données au `view()`
- Confondre `Route::post` et `Route::get`
- Oublier `@csrf` dans les formulaires (séance prochaine)

### ✅ Bonnes Pratiques
- Nommer vos routes pour éviter les URL hardcodées
- Utiliser les Laravel conventions (noms au pluriel, camelCase)
- Commenter les fonctions complexes
- Organiser vos vues en dossiers logiques
- Utiliser `route()` helper plutôt que `/url/hardcodee`

---

## 🔗 Ressources

- [Laravel Routing](https://laravel.com/docs/11.x/routing)
- [Blade Templates](https://laravel.com/docs/11.x/blade)
- [Controllers](https://laravel.com/docs/11.x/controllers)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)

---

**Prêt à passer à la Séance 2 ?** → Migrations et Models Eloquent


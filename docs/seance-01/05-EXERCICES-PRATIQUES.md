# 💪 EXERCICES PRATIQUES - SÉANCE 1

## 🎯 Objectif des Exercices

Ces exercices vous permettront de pratiquer concrètement les concepts vus en séance 1 :
- Architecture MVC de Laravel
- Système de routes et paramètres
- Contrôleurs et passage de données
- Vues Blade et héritage de templates

⏱️ Durée estimée : 1h30-2h selon votre niveau

---

## 🚀 Exercice 1 : Personnaliser la Page d'Accueil (15 min)

### 🎯 Objectif
Modifier la page d'accueil pour la personnaliser avec vos informations.

### 📋 Instructions
1. Ouvrir le fichier `resources/views/welcome.blade.php`
2. Modifier la section hero pour afficher votre nom d'équipe/classe
3. Ajouter votre établissement dans le sous-titre
4. Personnaliser les couleurs ou les icônes selon vos préférences

### 💡 Exemple de modification
```blade
{{-- Dans la section hero --}}
<h1><i class="fas fa-book-open me-3"></i>{{ $appName }} - Lycée Jean Moulin</h1>
<p class="lead">Votre bibliothèque numérique développée par la classe BTS SIO2</p>
<p>Formation Laravel - Équipe de développement : Alice, Bob, Charlie</p>
```

### ✅ Validation
- [ ] La page d'accueil affiche vos informations personnalisées
- [ ] Le design reste cohérent et professionnel
- [ ] Aucune erreur dans la console du navigateur

---

## 🛠️ Exercice 2 : Créer une Nouvelle Route (20 min)

### 🎯 Objectif
Créer une page "Contact" accessible via une route personnalisée.

### 📋 Instructions

#### Étape 1 : Définir la route
Dans `routes/web.php`, ajouter :
```php
Route::get('/contact', function () {
    return view('contact', [
        'etablissement' => 'Votre Lycée',
        'formation' => 'BTS SIO SLAM',
        'email' => 'contact@votre-lycee.fr',
        'telephone' => '01 23 45 67 89',
        'adresse' => '123 Rue de l\'École, 75000 Paris'
    ]);
})->name('contact');
```

#### Étape 2 : Créer la vue
Créez le fichier `resources/views/contact.blade.php` :
```blade
@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-envelope me-2"></i>Contactez-nous</h3>
                </div>
                <div class="card-body">
                    <h5>{{ $etablissement }}</h5>
                    <p class="text-muted">{{ $formation }}</p>
                    <!-- Ajoutez le reste des champs ici -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

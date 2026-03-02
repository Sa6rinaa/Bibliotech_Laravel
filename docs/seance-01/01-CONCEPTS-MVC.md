
# 🧠 Concepts clés de la Séance 1

Ce document synthétise les notions fondamentales abordées lors de la première séance du projet BiblioTech avec Laravel et Docker.

---

## 🏗️ Architecture MVC

**MVC** (Modèle-Vue-Contrôleur) est le cœur de Laravel :
- **Model (Modèle)** : Représente les données et la logique métier. (Ex : `Livre.php`, non utilisé en S1, données statiques)
- **View (Vue)** : Affiche les données à l’utilisateur via Blade. (Ex : `books/index.blade.php`)
- **Controller (Contrôleur)** : Reçoit la requête, prépare les données et appelle la vue. (Ex : `LivreController.php`)

**Schéma du flux :**
```
Route → Controller → View (Blade)
```

**Exemple :**
```php
// routes/web.php
Route::get('/livres', [LivreController::class, 'index']);
```
```php
// app/Http/Controllers/LivreController.php
public function index() {
		$livres = [/* ... */];
		return view('books.index', compact('livres'));
}
```
```blade
{{-- resources/views/books/index.blade.php --}}
@foreach($livres as $livre)
		<div>{{ $livre['titre'] }}</div>
@endforeach
```

---

## 🛣️ Routage Laravel

- Les routes sont définies dans `routes/web.php`.
- On peut utiliser des paramètres : `/livre/{id}`.
- Les routes nommées facilitent la navigation :
	```php
	Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livre.show');
	```
- On peut ajouter des contraintes :
	```php
	Route::get('/livre/{id}', ...)->where('id', '[0-9]+');
	```

**À tester :** Créez une route `/mentions` qui affiche la page `mentions.blade.php`.

---

## 🎨 Blade Templates

- Blade est le moteur de template de Laravel.
- Utilisez des layouts pour factoriser le code :
	```blade
	@extends('layouts.app')
	@section('content')
		<h1>Catalogue</h1>
		@foreach($livres as $livre)
			<div>{{ $livre['titre'] }}</div>
		@endforeach
	@endsection
	```
- Passage de variables : `return view('books.index', ['livres' => $livres]);`
- Boucles : `@foreach`, Conditions : `@if`, Inclusion de composants : `@include`

**À retenir :**
- Les vues sont dans `resources/views/`
- Les layouts dans `resources/views/layouts/`

---

## 🐳 Docker & Codespaces

- Docker permet d’avoir un environnement identique pour tous.
- Codespaces facilite le démarrage sans configuration locale.
- Commandes utiles :
	```bash
	docker-compose up -d
	docker-compose exec app composer install
	docker-compose exec app php artisan migrate --seed
	```

**À tester :** Lancez l’application et accédez à http://localhost:8000

---

## 📁 Organisation du projet

- `app/Http/Controllers/` : Contrôleurs
- `resources/views/` : Vues Blade
- `routes/web.php` : Routes web
- `database/migrations/` : Migrations (S2)
- `docs/seance-01/` : Documentation pédagogique

---

## 📝 Conseils pratiques

- Utilisez la documentation officielle Laravel : https://laravel.com/docs
- Testez chaque modification dans Codespaces ou Docker
- Demandez de l’aide sur GitHub Discussions si besoin

---

**À retenir :**
- MVC = Séparation des responsabilités
- Routage = Navigation et paramètres
- Blade = Templates dynamiques
- Docker/Codespaces = Environnement prêt à l’emploi

**Objectif :** Être capable de créer une route, un contrôleur et une vue pour afficher une liste de livres.

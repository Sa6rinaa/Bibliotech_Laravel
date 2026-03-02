<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\CategorieController;

// Route simple menant à la page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les livres
Route::prefix('/livres')->group(function () {
    // Afficher la liste des livres
    Route::get('/', [LivreController::class, 'index'])->name('livres.index');

    // Afficher les détails d'un livre spécifique
    Route::get('/{id}', [LivreController::class, 'show'])->name('livres.show');

    // Rechercher des livres (paramètre query string)
    Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');
});

// Routes pour les catégories
Route::prefix('/categories')->group(function () {
    // Afficher la liste des catégories
    Route::get('/', [CategorieController::class, 'index'])->name('categories.index');

    // Afficher les détails d'une catégorie
    Route::get('/{id}', [CategorieController::class, 'show'])->name('categories.show');

    // Afficher les livres d'une catégorie
    Route::get('/{id}/livres', [CategorieController::class, 'livres'])
        ->name('categories.livres');
});

// Route pour la page À Propos (exemple simple)
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Route pour Mentions Légales (exemple simple)
Route::get('/mentions-legales', function () {
    return view('pages.mentions');
})->name('mentions');

?>

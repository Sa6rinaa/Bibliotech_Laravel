<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\LivreController;

/*
|--------------------------------------------------------------------------
| SÉANCE 1 : Routes Fondamentales
|--------------------------------------------------------------------------
| Focus : Comprendre le routage Laravel basique
| - Routes simples
| - Paramètres d'URL
| - Routes nommées
| - Contrôleurs
*/

Route::get('/test-debug', function () { 
    return 'Laravel fonctionne !'; 
});

// 1. Accueil - Route simple
Route::get('/', [AccueilController::class, 'index'])->name('home');

// 2. À propos - Route vers vue directe  
Route::get('/about', function () {
    return view('about');
})->name('about');

// 3. Liste livres - Route vers contrôleur
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');

// 4. Détail livre - Route avec paramètre
Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');

// Recherche livre
Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

// Authentication (minimal pour tests)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Affiche simplement un placeholder (la vue peut être vide ou inexistante)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return redirect('/login');
});

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect('/dashboard');
});

// Route de démonstration pour comprendre les paramètres
Route::get('/demo/hello/{nom?}', function ($nom = 'Étudiant') {
    return view('demo.hello', ['nom' => $nom]);
})->name('demo.hello');

// Route de test pour déboguer - retourne du HTML simple
Route::get('/test', function () {
    return '<h1>Test Laravel fonctionne !</h1><p>Si vous voyez ce message, Laravel fonctionne.</p>';
})->name('test');

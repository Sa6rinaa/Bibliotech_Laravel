<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Routes d'authentification - Séance 4
 *
 * Démontre:
 * - Routes simples (login/register/logout)
 * - Protection avec middleware ['auth', 'role:admin']
 * - Validation CSRF
 */

// 🔓 Routes publiques (pas besoin d'être connecté)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// 🔐 Routes authentifiées
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile management (chaque utilisateur gère son profil)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');

    // Dashboard personnalisé par rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => view('dashboard.admin', ['user' => $user]),
            'bibliothecaire' => view('dashboard.bibliothecaire', ['user' => $user]),
            default => view('dashboard.user', ['user' => $user]),
        };
    })->name('dashboard');
});

// 🛡️ Routes admin uniquement
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {

    // Gestion des utilisateurs
    Route::get('/utilisateurs', [UserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/{id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/utilisateurs/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::patch('/utilisateurs/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

// 🛡️ Routes bibliothécaire uniquement
Route::middleware(['auth', 'role:bibliothecaire'])->prefix('/biblio')->name('biblio.')->group(function () {

    // Exemple: ajouter des livres
    Route::get('/dashboard', function () {
        return view('dashboard.bibliothecaire');
    })->name('dashboard');
});

?>

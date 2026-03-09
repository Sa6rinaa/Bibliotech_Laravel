<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\LivreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Routes Fondamentales & Abonnements
|--------------------------------------------------------------------------
*/

Route::get('/', [AccueilController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/tarifs', fn() => view('tarifs'))->name('tarifs');

// Livres (la liste est publique, le détail est protégé plus bas)
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');

// --- AUTHENTIFICATION ---
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }
    return redirect('/login')->withErrors(['email' => 'Identifiants invalides']);
});

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8',
    ]);
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'user',
    ]);
    Auth::login($user);
    $request->session()->regenerate();
    return redirect('/dashboard');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Vous êtes déconnecté.');
})->name('logout');


// --- ZONE CONNECTÉE (Middleware Auth) ---
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $children = auth()->user()->children; 
        return view('dashboard', compact('children'));
    })->name('dashboard');

    // 1. PAGE DE PAIEMENT (CHECKOUT)
    Route::get('/checkout/{plan}', function ($plan) {
        // Sécurité : si on veut passer à l'individuel alors qu'on a des enfants
        if ($plan === 'individuel' && auth()->user()->children()->count() > 0) {
            return redirect()->route('dashboard')->with('error', "Supprimez vos comptes enfants avant de passer au plan individuel.");
        }
        return view('checkout', ['plan' => $plan]);
    })->name('checkout');

    // 2. ACTION DE SOUSCRIPTION (VALIDATION DU PAIEMENT)
    Route::post('/subscribe/{plan}', function ($plan) {
        $user = auth()->user();

        // Bloquer si passage à l'individuel avec des enfants existants
        if ($plan === 'individuel' && $user->children()->count() > 0) {
            return redirect()->route('dashboard')->with('error', "Action refusée : enfants détectés.");
        }

        if (in_array($plan, ['individuel', 'famille'])) {
            $user->update([
                'subscription_type' => $plan,
                'is_active' => true
            ]);
            return redirect()->route('dashboard')->with('success', "Paiement validé ! Abonnement $plan activé.");
        }
        return redirect()->back();
    })->name('subscription.subscribe');

    // 3. SUPPRESSION D'UN ENFANT
    Route::delete('/enfant/{id}', function ($id) {
        $child = User::where('id', $id)->where('parent_id', auth()->id())->firstOrFail();
        $child->delete();
        return redirect()->back()->with('success', "Compte enfant supprimé.");
    })->name('child.delete');

    // 4. GESTION DES ENFANTS (AJOUT)
    Route::post('/ajouter-enfant', function (Request $request) {
        if (auth()->user()->subscription_type !== 'famille') {
            return redirect()->back()->with('error', "Prenez un abonnement Famille d'abord !");
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'parent_id' => auth()->id(),
            'role' => 'user',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', "Enfant ajouté !");
    })->name('subscription.add_child');

    // --- ZONE SÉCURISÉE (ABONNÉS SEULEMENT) ---
    Route::middleware('subscribed')->group(function () {
        Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');
        Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');
    });

    // Zone Admin
    Route::get('/admin', function () {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Routes de test
Route::get('/test', fn() => '<h1>Test Laravel OK</h1>')->name('test');
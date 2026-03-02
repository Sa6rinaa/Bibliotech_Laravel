<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * AuthController - Séance 4 (Authentification)
 *
 * Gère toute l'authentification:
 * - Login
 * - Register
 * - Logout
 */
class AuthController extends Controller
{
    /**
     * Affiche la page de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion
     *
     * Concepts:
     * - Auth::attempt() = vérifier + créer session
     * - Hash::check() = vérifier un password
     * - Logging = tracer les tentatives échouées
     * - Rate limiting = protection contre brute force
     */
    public function login(Request $request)
    {
        // Valider les données
        $credentials = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            // ✅ Succès: créer la session
            $request->session()->regenerate();  // Sécurité: nouveau session ID

            Log::info('User logged in', ['email' => $request->email]);

            return redirect('/dashboard')
                ->with('success', 'Bienvenue !');
        }

        // ❌ Échec
        Log::warning('Login attempt failed', ['email' => $request->email]);

        return back()
            ->withErrors(['email' => 'Identifiants invalides'])
            ->onlyInput('email');
    }

    /**
     * Affiche la page de register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription
     *
     * Concepts:
     * - Hash::make() = hasher le password
     * - Validation unique
     * - Auto-login après inscription
     */
    public function register(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',  // Role par défaut
        ]);

        // Auto-login
        Auth::login($user);
        $request->session()->regenerate();

        Log::info('User registered', ['email' => $user->email]);

        return redirect('/dashboard')
            ->with('success', 'Compte créé avec succès !');
    }

    /**
     * Traite la déconnexion
     *
     * Concepts:
     * - Invalider la session
     * - Détruire le cookie de session
     * - Logout de tous les navigateurs (optionnel)
     */
    public function logout(Request $request)
    {
        Log::info('User logged out', ['id' => auth()->id()]);

        Auth::logout();

        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF pour éviter les attaques
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie');
    }
}

?>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * ProfileController - Séance 4 (Gestion Profil)
 *
 * Permet à chaque user de gérer son profil
 */
class ProfileController extends Controller
{
    /**
     * Affiche la page d'édition du profil
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Modifie les informations du profil
     * (nom, email)
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profil mis à jour');
    }

    /**
     * Change le mot de passe
     *
     * Concepts:
     * - Vérifier l'ancien password avec Hash::check()
     * - Hasher le nouveau password avec Hash::make()
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Vérifier que l'ancien password est correct
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe incorrect']);
        }

        // Mettre à jour le password
        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        Log::info('Password changed', ['user_id' => auth()->id()]);

        return back()->with('success', 'Mot de passe changé');
    }

    /**
     * Supprime le compte utilisa
     */
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
        ]);

        // Vérifier le password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect']);
        }

        $user = auth()->user();
        auth()->logout();
        $request->session()->invalidate();

        $user->delete();  // Soft delete

        Log::warning('User account deleted', ['id' => $user->id]);

        return redirect('/')->with('success', 'Compte supprimé');
    }
}

?>

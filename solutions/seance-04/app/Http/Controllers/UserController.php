<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * UserController - Séance 4 (Rôles & Middleware)
 *
 * Gère l'affichage et modification des utilisateurs
 * Note: Protégé par middleware role:admin
 */
class UserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs
     *
     * ⚠️ Route protégée par middleware: ['auth', 'role:admin']
     */
    public function index()
    {
        // Admin peut voir TOUS les users
        $users = User::paginate(15);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Vérifier que l'admin peut voir cet utilisateur
        if (auth()->user()->isAdmin() || auth()->id() === $id) {
            return view('admin.users.show', ['user' => $user]);
        }

        return redirect('/users')->withError('Non autorisé');
    }

    /**
     * Supprime un utilisateur (soft delete)
     *
     * ⚠️ Route protégée par middleware: ['auth', 'role:admin']
     */
    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Empêcher l'auto-suppression
        if (auth()->id() === $id) {
            return back()->withError('Vous ne pouvez pas vous supprimer');
        }

        $user->delete();  // Soft delete

        Log::warning('User deleted', ['id' => $id, 'deleted_by' => auth()->id()]);

        return redirect('/users')->with('success', 'Utilisateur supprimé');
    }

    /**
     * Change le rôle d'un utilisateur
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:admin,bibliothecaire,user',
        ]);

        $user->update(['role' => $validated['role']]);

        Log::info('User role updated', [
            'user_id' => $id,
            'new_role' => $validated['role'],
        ]);

        return back()->with('success', 'Rôle mis à jour');
    }
}

?>

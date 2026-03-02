<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;

/**
 * LivreController - Séance 2 (Eloquent)
 *
 * Démontre l'utilisation riche d'Eloquent ORM avec:
 * - Relations
 * - Eager loading
 * - Scopes
 * - Counting
 */
class LivreController extends Controller
{
    /**
     * Affiche la liste paginée avec eager loading
     *
     * ❌ MAUVAIS - N+1 queries:
     * $livres = Livre::paginate(15);  // Requête 1
     * foreach ($livres as $livre) {
     *     $livre->categorie->nom;      // Requête 2, 3, 4... N+1 au total
     * }
     *
     * ✅ BON - Eager loading:
     */
    public function index()
    {
        $livres = Livre::with('categorie')  // Charger la relation d'un coup
            ->orderBy('titre')
            ->paginate(15);

        return view('livres.index', [
            'livres' => $livres,
            'total_count' => Livre::count(),
        ]);
    }

    /**
     * Affiche un livre avec ses informations
     */
    public function show($id)
    {
        $livre = Livre::with('categorie')
            ->findOrFail($id);

        // Chercher les livres similaires (même catégorie)
        $similaires = Livre::where('categorie_id', $livre->categorie_id)
            ->where('id', '!=', $livre->id)
            ->take(5)
            ->get();

        return view('livres.show', [
            'livre' => $livre,
            'similaires' => $similaires,
        ]);
    }

    /**
     * Cherche les livres par titre ou auteur
     *
     * Utilise les conditions OR
     */
    public function search()
    {
        $query = request()->input('q', '');

        // Chercher par titre OU auteur
        $livres = Livre::where('titre', 'LIKE', "%$query%")
            ->orWhere('auteur', 'LIKE', "%$query%")
            ->with('categorie')
            ->paginate(10);

        return view('livres.search', [
            'livres' => $livres,
            'query' => $query,
        ]);
    }

    /**
     * Affiche les statistiques des livres par catégorie
     *
     * Démontre withCount() pour compter les relations
     */
    public function statistics()
    {
        // Charger les catégories avec le nombre de livres
        $categories = Categorie::withCount('livres')
            ->orderByDesc('livres_count')
            ->get();

        // Les catégories les plus populaires
        $topCategories = Categorie::withCount('livres')
            ->orderByDesc('livres_count')
            ->take(5)
            ->get();

        // Livres les plus récents
        $newestLivres = Livre::latest()  // Scope implicite : orderBy('created_at', 'desc')
            ->take(10)
            ->with('categorie')
            ->get();

        return view('livres.statistics', [
            'categories' => $categories,
            'topCategories' => $topCategories,
            'newestLivres' => $newestLivres,
        ]);
    }
}

?>

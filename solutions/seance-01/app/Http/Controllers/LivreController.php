<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Http\Request;

/**
 * LivreController
 *
 * Gère tous les appels concernant les livres:
 * - Listing
 * - Affichage détaillé
 * - Recherche et filtrage
 */
class LivreController extends Controller
{
    /**
     * Affiche la liste de tous les livres
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer les livres avec pagination (15 par page)
        $livres = Livre::paginate(15);

        return view('pages.livres.index', [
            'livres' => $livres,
        ]);
    }

    /**
     * Affiche les détails d'un livre spécifique
     *
     * @param int $id L'identifiant du livre
     * @return \Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si le livre n'existe pas
     */
    public function show($id)
    {
        // Récupérer le livre avec sa catégorie (relation)
        $livre = Livre::with('categorie')->findOrFail($id);

        // Récupérer les 5 livres similaires (même catégorie)
        $livresSimilaires = Livre::where('categorie_id', $livre->categorie_id)
            ->where('id', '!=', $livre->id)
            ->take(5)
            ->get();

        return view('pages.livres.show', [
            'livre' => $livre,
            'livresSimilaires' => $livresSimilaires,
        ]);
    }

    /**
     * Recherche des livres par titre ou auteur
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        // Chercher dans le titre ou l'auteur
        $livres = Livre::where('titre', 'LIKE', "%$query%")
            ->orWhere('auteur', 'LIKE', "%$query%")
            ->paginate(10);

        return view('pages.livres.search', [
            'livres' => $livres,
            'query' => $query,
        ]);
    }
}

?>

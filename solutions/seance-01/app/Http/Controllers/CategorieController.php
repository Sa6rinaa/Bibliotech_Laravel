<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Livre;

/**
 * CategorieController
 *
 * Gère l'affichage des catégories et des livres par catégorie
 */
class CategorieController extends Controller
{
    /**
     * Affiche la liste de toutes les catégories
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Charger les catégories avec le nombre de livres pour chacune
        $categories = Categorie::withCount('livres')
            ->orderBy('nom')
            ->paginate(12);

        return view('pages.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Affiche les détails d'une catégorie
     *
     * @param int $id L'identifiant de la catégorie
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);

        return view('pages.categories.show', [
            'categorie' => $categorie,
        ]);
    }

    /**
     * Affiche les livres d'une catégorie spécifique
     *
     * @param int $id L'identifiant de la catégorie
     * @return \Illuminate\View\View
     */
    public function livres($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Récupérer les livres de cette catégorie avec pagination
        $livres = $categorie->livres()
            ->orderBy('titre')
            ->paginate(15);

        return view('pages.categories.livres', [
            'categorie' => $categorie,
            'livres' => $livres,
        ]);
    }
}

?>

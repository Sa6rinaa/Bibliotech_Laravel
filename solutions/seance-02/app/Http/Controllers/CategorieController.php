<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Livre;

/**
 * CategorieController - Séance 2 (Eloquent)
 *
 * Démontre les relations et queries avancées
 */
class CategorieController extends Controller
{
    /**
     * Lister toutes les catégories avec nombre de livres
     */
    public function index()
    {
        $categories = Categorie::withCount('livres')
            ->orderBy('nom')
            ->paginate(12);

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Afficher une catégorie et ses livres
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Charger les livres de cette catégorie
        $livres = $categorie->livres()
            ->orderBy('titre')
            ->paginate(15);

        return view('categories.show', [
            'categorie' => $categorie,
            'livres' => $livres,
        ]);
    }
}

?>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Categorie;

class LivreController extends Controller
{
    /**
     * Affichage liste avec base de données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour récupérer les données depuis SQLite
     */
    public function index()
    {
        // Récupération des livres avec leurs catégories via Eloquent
        $livres = Livre::with('categorie')->get();

        // Récupération des catégories pour le filtre
        $categories = Categorie::actives()->get();

        $statistiques = [
            'totalLivres' => Livre::count(),
            'livresDisponibles' => Livre::disponible()->count(),
            'totalCategories' => Categorie::actives()->count()
        ];

        return view('livres.index', [
            'livres' => $livres,
            'categories' => $categories,
            'stats' => $statistiques,
            'total' => $livres->count()
        ]);
    }

    /**
     * Affichage détail avec paramètre d'URL et Eloquent
     * SÉANCE 2 : Utiliser Eloquent pour récupérer un enregistrement spécifique
     */
    public function show($id)
    {
        // Conversion de l'ID en entier pour éviter les erreurs
        $id = (int) $id;

        // Récupération du livre avec sa catégorie via Eloquent
        $livre = Livre::with('categorie')->findOrFail($id);

        return view('livres.show', [
            'livre' => $livre
        ]);
    }

    /**
     * Recherche de livres avec Eloquent
     * SÉANCE 2 : Utiliser les scopes Eloquent pour la recherche
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Utilisation des scopes Eloquent pour la recherche
        $livres = Livre::with('categorie')
            ->when($query, function ($queryBuilder, $searchTerm) {
                return $queryBuilder->recherche($searchTerm);
            })
            ->get();

        return view('livres.search', [
            'livres' => $livres,
            'query' => $query,
            'total' => $livres->count()
        ]);
    }
}

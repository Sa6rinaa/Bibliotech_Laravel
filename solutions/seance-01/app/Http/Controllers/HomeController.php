<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use App\Models\Utilisateur;

/**
 * HomeController
 *
 * Contrôle la page d'accueil et le dashboard principal
 * Responsabilités:
 * - Collecter les données pour la vue d'accueil
 * - Agréger les statistiques de la base de données
 * - Formater les données pour l'affichage
 */
class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec statistiques
     *
     * @return \Illuminate\View\View Vue avec statistiques
     */
    public function index()
    {
        // Récupérer les statistiques principales
        $stats = [
            'total_livres' => Livre::count(),
            'total_categories' => Categorie::count(),
            'total_utilisateurs' => Utilisateur::count(),
        ];

        // Récupérer les 5 catégories avec le plus de livres
        $topCategories = Categorie::withCount('livres')
            ->orderByDesc('livres_count')
            ->take(5)
            ->get();

        // Récupérer les 8 derniers livres ajoutés
        $latestLivres = Livre::latest()
            ->take(8)
            ->with('categorie') // Charger la relation pour éviter N+1
            ->get();

        // Passer les données à la vue
        return view('pages.home', [
            'stats' => $stats,
            'topCategories' => $topCategories,
            'latestLivres' => $latestLivres,
        ]);
    }
}

?>

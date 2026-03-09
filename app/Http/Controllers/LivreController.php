<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;

class LivreController extends Controller
{
    /**
     * Liste des livres avec avantages abonnés
     */
    public function index()
    {
        $user = Auth::user();
        $query = Livre::with('categorie');

        // AVANTAGE ENFANT : Si c'est un compte enfant, on filtre par catégorie "Jeunesse"
        if ($user && $user->parent_id) {
            $query->whereHas('categorie', function($q) {
                $q->where('nom', 'LIKE', '%Jeunesse%')
                  ->orWhere('nom', 'LIKE', '%Enfant%');
            });
        }

        // AVANTAGE ABONNÉ : Si pas abonné, on ne montre que les 3 premiers (Teasing)
        if (!$user || !$user->is_active) {
            $livres = $query->take(3)->get();
        } else {
            $livres = $query->get();
        }

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
            'total' => $livres->count(),
            'is_limited' => (!$user || !$user->is_active) // Pour afficher un message "Abonnez-vous"
        ]);
    }

    /**
     * Détail du livre (Sécurisé par le middleware 'subscribed' dans web.php)
     */
    public function show($id)
    {
        $livre = Livre::with('categorie')->findOrFail((int)$id);

        // LOGIQUE PARENTALE : Empêcher un enfant de voir une BD adulte via l'URL
        if (Auth::user()->parent_id && str_contains(strtolower($livre->categorie->nom), 'adulte')) {
            return redirect()->route('livres.index')->with('error', 'Contenu non autorisé pour ton âge.');
        }

        return view('livres.show', ['livre' => $livre]);
    }

    /**
     * Recherche
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $user = Auth::user();

        $livresQuery = Livre::with('categorie')
            ->when($query, function ($qB, $searchTerm) {
                return $qB->recherche($searchTerm);
            });

        // Même filtre de sécurité pour la recherche
        if ($user && $user->parent_id) {
            $livresQuery->whereHas('categorie', function($q) {
                $q->where('nom', 'NOT LIKE', '%Adulte%');
            });
        }

        $livres = $livresQuery->get();

        return view('livres.search', [
            'livres' => $livres,
            'query' => $query,
            'total' => $livres->count()
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupération des catégories pour les relations (en utilisant celles existantes)
        $roman = Categorie::where('slug', 'roman')->first();
        $informatique = Categorie::where('slug', 'informatique')->first();
        $histoire = Categorie::where('slug', 'histoire')->first();
        $scienceFiction = Categorie::where('slug', 'science-fiction')->first();
        $biographie = Categorie::where('slug', 'biographie')->first();
        $fantastique = Categorie::where('slug', 'fantastique')->first();

        $livres = [
            [
                'titre' => 'Les Misérables',
                'auteur' => 'Victor Hugo',
                'annee' => 1862,
                'nb_pages' => 1200,
                'isbn' => '978-2-1234-5678-9',
                'resume' => 'Un chef-d\'œuvre de la littérature française qui suit la vie de Jean Valjean.',
                'couverture' => 'miserables.jpg',
                'disponible' => true,
                'categorie_id' => $roman?->id,
            ],
            [
                'titre' => 'Guide Laravel pour Développeurs',
                'auteur' => 'Marie Dubois',
                'annee' => 2023,
                'nb_pages' => 280,
                'isbn' => '978-2-1234-5679-6',
                'resume' => 'Maîtriser le framework Laravel avec des exemples pratiques.',
                'couverture' => 'laravel.jpg',
                'disponible' => true,
                'categorie_id' => $informatique?->id,
            ],
            [
                'titre' => 'Histoire de France',
                'auteur' => 'Pierre Martin',
                'annee' => 2024,
                'nb_pages' => 195,
                'isbn' => '978-2-1234-5680-2',
                'resume' => 'Un voyage à travers l\'histoire de France des origines à nos jours.',
                'couverture' => 'histoire.jpg',
                'disponible' => false,
                'categorie_id' => $histoire?->id,
            ],
            [
                'titre' => 'Dune',
                'auteur' => 'Frank Herbert',
                'annee' => 1965,
                'nb_pages' => 245,
                'isbn' => '978-2-1234-5682-6',
                'resume' => 'Un classique de la science-fiction dans l\'univers d\'Arrakis.',
                'couverture' => 'dune.jpg',
                'disponible' => true,
                'categorie_id' => $scienceFiction?->id,
            ],
            [
                'titre' => 'Steve Jobs',
                'auteur' => 'Walter Isaacson',
                'annee' => 2011,
                'nb_pages' => 350,
                'isbn' => '978-2-1234-5681-9',
                'resume' => 'La biographie officielle du co-fondateur d\'Apple.',
                'couverture' => 'jobs.jpg',
                'disponible' => true,
                'categorie_id' => $biographie?->id,
            ],
            [
            'titre' => '1984',
             'auteur' => 'George Orwell',
             'annee' => 1949,
            'nb_pages' => 328,
            'isbn' => '978-0-452-28423-4',
         'resume' => 'Le monde de Big Brother.',
          'couverture' => '1984.jpg',
      'disponible' => true,
      'categorie_id' => $scienceFiction?->id,
],
            [
                'titre' => 'Le Seigneur des Anneaux',
                'auteur' => 'J.R.R. Tolkien',
                'annee' => 1954,
                'nb_pages' => 290,
                'isbn' => '978-2-1234-5683-3',
                'resume' => 'L\'épopée fantasy la plus célèbre de tous les temps.',
                'couverture' => 'lotr.jpg',
                'disponible' => true,
                'categorie_id' => $fantastique?->id,
            ]
            
        ];

        foreach ($livres as $livre) {
            Livre::create($livre);
        }
    }
}

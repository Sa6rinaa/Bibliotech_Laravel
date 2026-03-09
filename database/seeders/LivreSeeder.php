<?php

namespace Database\Seeders;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Database\Seeder;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. On crée les catégories en utilisant uniquement les colonnes qui existent (slug et nom)
        $roman = Categorie::firstOrCreate(['slug' => 'roman'], ['nom' => 'Roman']);
        $informatique = Categorie::firstOrCreate(['slug' => 'informatique'], ['nom' => 'Informatique']);
        $scienceFiction = Categorie::firstOrCreate(['slug' => 'science-fiction'], ['nom' => 'Science-Fiction']);
        $jeunesse = Categorie::firstOrCreate(['slug' => 'jeunesse'], ['nom' => 'BD Jeunesse']);
        $manga = Categorie::firstOrCreate(['slug' => 'manga'], ['nom' => 'Manga']);

        // 2. Liste des livres à insérer
        $livres = [
            [
                'titre' => 'Les Misérables',
                'auteur' => 'Victor Hugo',
                'resume' => 'Un chef-d\'œuvre de la littérature française.',
                'disponible' => true,
                'categorie_id' => $roman->id,
            ],
            [
                'titre' => 'Astérix le Gaulois',
                'auteur' => 'René Goscinny',
                'resume' => 'Les aventures du célèbre guerrier gaulois.',
                'disponible' => true,
                'categorie_id' => $jeunesse->id,
            ],
            [
                'titre' => 'Le Petit Nicolas',
                'auteur' => 'Sempé & Goscinny',
                'resume' => 'Les souvenirs d\'enfance de Nicolas.',
                'disponible' => true,
                'categorie_id' => $jeunesse->id,
            ],
            [
                'titre' => 'Naruto Tome 1',
                'auteur' => 'Masashi Kishimoto',
                'resume' => 'Le début de la quête de Naruto pour devenir Hokage.',
                'disponible' => true,
                'categorie_id' => $manga->id,
            ],
            [
                'titre' => 'Spirou et Fantasio',
                'auteur' => 'Franquin',
                'resume' => 'Aventures humoristiques et fantastiques.',
                'disponible' => true,
                'categorie_id' => $jeunesse->id,
            ],
            [
                'titre' => 'Dragon Ball',
                'auteur' => 'Akira Toriyama',
                'resume' => 'Son Goku part à la recherche des boules de cristal.',
                'disponible' => true,
                'categorie_id' => $manga->id,
            ],
            [
                'titre' => 'Guide Laravel pour Développeurs',
                'auteur' => 'Marie Dubois',
                'resume' => 'Maîtriser le framework Laravel avec des exemples pratiques.',
                'disponible' => true,
                'categorie_id' => $informatique->id,
            ],
            [
                'titre' => 'Dune',
                'auteur' => 'Frank Herbert',
                'resume' => 'Un classique de la science-fiction sur Arrakis.',
                'disponible' => true,
                'categorie_id' => $scienceFiction->id,
            ],
        ];

        // 3. Insertion ou mise à jour
        foreach ($livres as $livre) {
            Livre::updateOrCreate(['titre' => $livre['titre']], $livre);
        }
    }
}
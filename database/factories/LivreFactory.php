<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livre>
 */
class LivreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(3),
            'auteur' => $this->faker->name(),
            'annee' => $this->faker->year(),
            'nb_pages' => $this->faker->numberBetween(50, 500),
            'isbn' => $this->faker->unique()->isbn13(),
            'resume' => $this->faker->paragraph(),
            'couverture' => null,
            'disponible' => true,
            'categorie_id' => null,
        ];
    }
}

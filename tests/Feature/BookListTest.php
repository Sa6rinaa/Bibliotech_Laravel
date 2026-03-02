<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookListTest extends TestCase
{
    /**
     * Teste si la page d'accueil s'affiche correctement.
     */
    public function test_homepage_is_accessible(): void
    {
        // 1. On simule une visite sur l'URL '/'
        $response = $this->get('/');

        // 2. On vérifie que la page répond "OK" (status 200)
        $response->assertStatus(200);

        // 3. On vérifie que le texte "BiblioTech" est présent dans le HTML
        $response->assertSee('BiblioTech');
    }
}
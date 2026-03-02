<?php

namespace Tests\Feature;

use App\Models\Livre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_livres_page_loads(): void
    {
        $response = $this->get('/livres');
        $response->assertStatus(200);
    }

    public function test_livre_detail_loads(): void
    {
        $livre = Livre::factory()->create();
        
        $response = $this->get("/livre/{$livre->id}");
        $response->assertStatus(200);
        $response->assertSee($livre->titre);
    }

    public function test_can_search_livres(): void
    {
        Livre::factory(3)->create(['titre' => 'Laravel']);
        
        $response = $this->get('/recherche?q=Laravel');
        $response->assertStatus(200);
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données pour chaque test

    /** @test */
    public function un_utilisateur_peut_souscrire_au_plan_individuel()
    {
        // 1. Créer un utilisateur
        $user = User::factory()->create();

        // 2. Simuler la connexion et l'achat du plan
        $response = $this->actingAs($user)
                         ->post(route('subscription.subscribe', 'individuel'));

        // 3. Vérifications
        $user->refresh();
        $this->assertEquals('individuel', $user->subscription_type);
        $this->assertTrue((bool)$user->is_active);
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function un_abonne_peut_acceder_a_la_lecture_d_un_livre()
    {
        $user = User::factory()->create([
            'subscription_type' => 'individuel',
            'is_active' => true
        ]);

        // On simule l'accès à un livre (ID 1 par exemple)
        $response = $this->actingAs($user)->get('/livre/1');

        // L'accès doit être autorisé (Code 200) et non redirigé vers les tarifs
        $response->assertStatus(200);
    }

    /** @test */
    public function un_non_abonne_est_redirige_lorsqu_il_tente_de_lire()
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)->get('/livre/1');

        // Doit rediriger vers la page des tarifs
        $response->assertRedirect(route('tarifs'));
    }

    /** @test */
    public function un_parent_famille_peut_ajouter_un_enfant()
    {
        $parent = User::factory()->create([
            'subscription_type' => 'famille',
            'is_active' => true
        ]);

        $response = $this->actingAs($parent)->post(route('subscription.add_child'), [
            'name' => 'Enfant Test',
            'email' => 'enfant.test@mail.com',
            'password' => 'password123'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'enfant.test@mail.com',
            'parent_id' => $parent->id
        ]);
        
        $this->assertEquals(1, $parent->children()->count());
    }

    /** @test */
    public function impossible_de_repasser_en_individuel_si_des_enfants_existent()
    {
        $parent = User::factory()->create([
            'subscription_type' => 'famille',
            'is_active' => true
        ]);

        // Créer un enfant lié
        User::factory()->create(['parent_id' => $parent->id]);

        // Tenter de s'abonner au plan individuel
        $response = $this->actingAs($parent)->post(route('subscription.subscribe', 'individuel'));

        // Vérifier que le plan reste "famille"
        $parent->refresh();
        $this->assertEquals('famille', $parent->subscription_type);
        $response->assertSessionHas('error');
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * AuthTest - Tests de l'authentification
 *
 * Lancer avec: php artisan test
 */
class AuthTest extends TestCase
{
    /**
     * Test: Un utilisateur peut se connecter
     */
    public function test_user_can_login()
    {
        // Créer un utilisateur
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Envoyer les credentials
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Vérifier que la connexion a réussi
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test: La connexion échoue avec credentials invalides
     */
    public function test_login_fails_with_invalid_credentials()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Un utilisateur peut s'inscrire
     */
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Vérifier que l'utilisateur a été créé
        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'name' => 'New User',
        ]);

        // Vérifier que l'utilisateur est connecté
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test: Admin peut voir tous les utilisateurs
     */
    public function test_admin_can_view_all_users()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/utilisateurs');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    /**
     * Test: User simple ne peut pas voir tous les utilisateurs
     */
    public function test_user_cannot_view_users_list()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/utilisateurs');

        $response->assertRedirect('/dashboard');
    }

    /**
     * Test: Admin peut supprimer un utilisateur
     */
    public function test_admin_can_delete_user()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $userToDelete = User::create([
            'name' => 'To Delete',
            'email' => 'delete@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->delete('/admin/utilisateurs/' . $userToDelete->id);

        // Vérifier que l'utilisateur a été soft-deleted
        $this->assertSoftDeleted('users', ['id' => $userToDelete->id]);
        $response->assertRedirect('/admin/utilisateurs');
    }

    /**
     * Test: Un utilisateur peut modifier son profil
     */
    public function test_user_can_update_profile()
    {
        $user = User::create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch('/profile/update', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertStatus(302);
    }

    /**
     * Test: Un utilisateur peut changer son mot de passe
     */
    public function test_user_can_change_password()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('oldpassword'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch('/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        // Vérifier que le nouveau password fonctionne
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));

        $response->assertStatus(302);
    }
}

?>

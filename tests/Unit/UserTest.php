<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_admin_method(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());
    }

    public function test_user_has_bibliothecaire_method(): void
    {
        $biblio = User::create([
            'name' => 'Biblio',
            'email' => 'biblio@test.com',
            'password' => 'password',
            'role' => 'bibliothécaire',
        ]);

        $this->assertTrue($biblio->isBibliothecaire());
    }
}
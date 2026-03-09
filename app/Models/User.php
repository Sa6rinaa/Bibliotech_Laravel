<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'subscription_type',
        'parent_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean', // Ajouté pour gérer le statut proprement
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations (Parents / Enfants)
    |--------------------------------------------------------------------------
    */

    // Un parent peut avoir plusieurs enfants
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // Un enfant appartient à un parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Logique d'Abonnement
    |--------------------------------------------------------------------------
    */

    // Calcul du prix dynamique (Accesseur)
    // Utilisation : $user->subscription_price
    public function getSubscriptionPriceAttribute()
    {
        if (!$this->subscription_type || $this->subscription_type === 'none') {
            return 0;
        }

        $basePrice = 15; // Prix de base Adulte
        $childPrice = 5; // Prix par enfant

        if ($this->subscription_type === 'famille') {
            return $basePrice + ($this->children()->count() * $childPrice);
        }

        return $basePrice; // Individuel
    }

    /*
    |--------------------------------------------------------------------------
    | Vérification des Rôles
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBibliothecaire(): bool
    {
        return $this->role === 'bibliothécaire';
    }
}
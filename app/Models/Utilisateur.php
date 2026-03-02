<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modèle Utilisateur français pour BiblioTech
 * Alternative au modèle User anglais
 */
class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'utilisateurs';
    
    protected $fillable = [
        'nom',
        'courriel',
        'mot_de_passe',
        'role'
    ];
    
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mot_de_passe' => 'hashed',
    ];
    
    /**
     * Override pour utiliser 'mot_de_passe' au lieu de 'password'
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
    
    /**
     * Scope pour les administrateurs
     */
    public function scopeAdministrateurs($query)
    {
        return $query->where('role', 'admin');
    }
}
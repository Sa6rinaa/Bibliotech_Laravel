<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
        'slug',
        'couleur',
        'icone',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Une catégorie peut avoir plusieurs livres
     */
    public function livres()
    {
        return $this->hasMany(Livre::class, 'categorie_id');
    }

    /**
     * Scope pour rechercher par nom
     */
    public function scopeRecherche($query, $terme)
    {
        return $query->where('nom', 'like', '%' . $terme . '%')
            ->orWhere('description', 'like', '%' . $terme . '%');
    }

    /**
     * Scope pour les catégories actives
     */
    public function scopeActives($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope pour trouver par slug
     */
    public function scopeParSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Accesseur pour l'URL de la catégorie
     */
    public function getUrlAttribute()
    {
        return route('categorie.show', $this->slug);
    }
}

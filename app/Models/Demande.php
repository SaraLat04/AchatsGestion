<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;
use App\Models\Utilisateur;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur_id',
        'statut',
        'date_demande',
        'description',
        'justification'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'demande_produit')
                    ->withPivot('quantite');  // Ajouter la colonne 'quantite' à la relation
    }
}

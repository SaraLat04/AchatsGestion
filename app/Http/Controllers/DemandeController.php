<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\DemandeProduit;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produitdemande;
use App\Models\Utilisateur;
 

class DemandeController extends Controller
{
    // Méthode pour afficher le formulaire de création de demande
    public function create()
    {
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        // Retourner une vue pour la création de la demande avec les données utilisateur pré-remplies
        return view('demandes.create', compact('user'));
    }

    // Méthode pour enregistrer la demande dans la base de données
    public function store(Request $request)
{
    $request->validate([
        'description' => 'required|string|max:255',
        'justification' => 'required|string|max:255',
        'piece_jointe' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'produits' => 'required|array',
        'produits.*.nom' => 'required|string', // On attend maintenant un nom plutôt qu'un ID
        'produits.*.quantite' => 'required|integer|min:1', // Ajout d'autres champs si nécessaire
    ]);

    // Création de la demande
    $demande = Demande::create([
        'utilisateur_id' => auth()->id(),
        'departement' => 'IT', // Exemple de département, à adapter selon votre logique
        'statut' => 'en_attente', // Valeur par défaut
        'description' => $request->description,
        'justification' => $request->justification,
        'piece_jointe' => $request->hasFile('piece_jointe') 
            ? $request->file('piece_jointe')->store('pieces_jointes')
            : null,
    ]);

    // Gestion des produits
    foreach ($request->produits as $produitData) {
        // Crée ou récupère le produit
        Produitdemande::create([
            'demande_id' => $demande->id,
            'nom' => $produitData['nom'],
            'quantite' => $produitData['quantite'],
        ]);
           
       
    }

    return redirect()->route('demandes.index')->with('success', 'Demande créée avec succès!');
}
}

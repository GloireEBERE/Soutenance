<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Tuteur;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    // Affichage des stagiaires pour les affecter à un tuteur
    public function index()
    {
        $stagiaires = Stagiaire::whereHas('demandes', function($query) {
            $query->where('statut', 'acceptée');
        })->with(['user', 'demandes'])->get();

        $tuteurs = Tuteur::withCount('stagiaires')->get();

        return view('admin.affectation', compact('stagiaires', 'tuteurs'));
    }

    public function assignTuteur($stagiaire_id, Request $request)
    {
        $stagiaire = Stagiaire::find($stagiaire_id);
        $stagiaire->tuteur_id = $request->input('tuteur_id');
        $stagiaire->save();

        return redirect()->route('affectation.index')->with('success', 'Stagiaire affecté avec succès.');
    }

}

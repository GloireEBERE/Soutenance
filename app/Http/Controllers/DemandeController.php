<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Rapport;
use App\Models\User;
use App\Notifications\DemandeDeStageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DemandeController extends Controller
{
    // Affichage de la page de demande de stage
    public function AfficherDemande()
    {
        return view('stagiaire.faire');
    }

    // La page stagiaireSidebar
    public function tuteurSidebar() 
    {
        $stagiaire = Auth::user()->stagiaire;

        $demandes = $stagiaire ? $stagiaire->demandes : collect();

        return view('layouts.stagiaireSidebar',compact('demandes'));
    }

    public function afficheRapport()
    {
        $rapportStage = Rapport::where('user_id', Auth::id())->first();
        return view('layouts.stagiaireSidebar', compact('rapportStage'));
    }
    

    // Faire la demande de stage
    public function FaireDemande(Request $request)
    {
        $request->validate([
            'lettre_de_demande' => 'required|mimes:pdf,doc,docx|max:2048',
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        // Trouver le stagiaire associé à l'utilisateur connecté
        $stagiaire = Auth::user()->stagiaire;

        // Vérifier si un stagiaire existe pour cet utilisateur
        if (!$stagiaire) {
            return redirect()->route('welcome')->with('error', 'Aucun stagiaire associé à votre compte.');
        }

        $demande = new Demande();

        if ($request->hasFile('lettre_de_demande'))
        {
            $demande->lettre_de_demande = $request->file('lettre_de_demande')->store('lettres', 'public');
        }

        if ($request->hasFile('cv'))
        {
            $demande->cv = $request->file('cv')->store('cv', 'public');
        }

        $demande->statut = 'en attente';

        $demande->date_soumission = now(); 

        // Associer la demande au stagiaire trouvé
        $demande->stagiaire_id = $stagiaire->id;  // Utilisation de l'ID du stagiaire

        $demande->save();

        // Trouver l'admin ou le responsable à notifier
        $admin = User::where('role', 'admin')->first();

        // Envoyer une notification à l'admin
        if ($admin) {
            $admin->notify(new DemandeDeStageNotification(
                'Nouvelle demande de stage',
                "Le stagiaire {$stagiaire->user->nom} a soumis une demande."
            ));
        }

        return redirect()->route('stagiaire.demandes')->with('message', 'Votre demande a été soumise avec succès !');

    }

    // La méthode pour supprimer la demande de stage
    public function detruire($id)
    {
        $demande = Demande::findOrFail($id); // Trouver la demande par ID
        $demande->delete(); // Supprimer la demande

        return redirect()->route('stagiaire.demandes')->with('message', 'La demande a été supprimée avec succès.');
    }


    // Affiche la liste de demande de stage
    public function index()
    {
        // Récupération de l'utilisateur avec ses informations liées aux stagiaires et aux demandes
        $user = User::with('stagiaire.demandes')->find(Auth::id());

        if (!$user || $user->role !== 'stagiaire')
        {
            Log::warning('Utilisateur non stagiaire ou inexistant.', ['user_id' => $user->id ?? 'inconnu']);

            return redirect()->route('welcome')->with('error', 'Vous n\'êtes pas un stagiaire ou l\'utilisateur n\'existe pas.');
        }

        // Récupération du stagiaire associé à l'utilisateur
        $stagiaire = $user->stagiaire;
        

        if (!$stagiaire)
        {
            Log::warning('Aucun stagiaire trouvé pour cet utilisateur.', ['user_id' => $user->id]);

            return redirect()->route('welcome')->with('error', 'Aucun stagiaire associé à cet utilisateur.');
        }

        Log::info('Stagiaire trouvé : ', ['stagiaire' => $stagiaire]);

        // Récupération des demandes de stage liées au stagiaire
        $demandes = $stagiaire->demandes;
        Log::info('Demandes récupérées : ', ['demandes' => $demandes]);

        // Si aucune demande n'est trouvée, afficher un message approprié
        if ($demandes->isEmpty()) {
            Log::info('Aucune demande de stage trouvée pour ce stagiaire.', ['stagiaire_id' => $stagiaire->id]);
        }

        return view('stagiaire.listeDemande', compact('demandes', 'stagiaire'));
    }

    // Affiche la page de modification de la demande de stage
    public function affiche($id)
    {
        $demande = Demande::findOrFail($id);

        return view('stagiaire.modifierDemande', ['demande' => $demande]);
    }

    // Mettre à jour les informations de demande de stage
    public function update(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        $request->validate([
            'lettre_de_demande' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'cv' => 'nullable|mimes:pdf|max:2048',
            'date_soumission' => 'required|date',
        ]);

        if ($request->hasFile('lettre_de_demande')) {
            $lettrePath = $request->file('lettre_de_demande')->store('demandes', 'public');
            $demande->lettre_de_demande = $lettrePath;
        }

        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $demande->cv = $cvPath;
        }

        // Met à jour la date de soumission
        $demande->date_soumission = $request->date_soumission;

        // Enregistre les modifications
        $demande->save();

        return redirect()->route('stagiaire.sortie', $demande->id)->with('message', 'Demande mise à jour avec succès.');
    }

}

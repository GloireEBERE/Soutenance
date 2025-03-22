<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Rapport;
use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TuteurController extends Controller
{

    // Affichage de la page principale de tuteur
    public function index()
    {
        return view('tuteur.index');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('tuteur.profil', compact('user'));
    }

    // Pour mettre à jour les informations de l'utilisateur
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');

        if ($request->hasFile('profileImage')) {
            // Suppression de l'ancienne image
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }

            // Enregistrement de la nouvelle image
            $file = $request->file('profileImage');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('new_images'), $filename);

            $user->photo = 'new_images/' . $filename;
        }

        $user->save();

        return redirect()->route('profil.tuteur')->with('success', 'Votre profil a été mis à jour.');
    }

    // Pour supprimer le profil
    public function deleteProfileImage( Request $request)
    {
        $user = Auth::user();

        // Vérifions si l'utilisateur a une image
        if ($user->photo && file_exists(public_path($user->photo)))
        {
            // Suppression de l'image
            unlink(public_path($user->photo));

            // Mise à jour de la base de données
            $user->photo = null;
            $user->save();

            return redirect()->back()->with('success', 'Image supprimée avec succès.');
        }
        return redirect()->back()->with('success', 'Aucune image à supprimer.');
    }

    // Changer le mot de passe de l'utilisateur
    public function updatePassword(Request $request)
    {
        // Validation des données
        $request->validate([
            'mot_de_passe' => 'required|min:8',
            'nouveau_mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        // Vérification de l'ancien mot de passe
        if(!Hash::check($request->mot_de_passe, Auth::user()->mot_de_passe))
        {
            return back()->withErrors(['mot_de_passe' => "L'ancien mot de passe est incorrect."]);
        }

        Log::debug('User:', ['user' => Auth::user()]);
        Log::debug('Request Data:', $request->all());


        // Mise à jour du mot de passe
        Auth::user()->update([
            'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe),
        ]);

        return back()->with('success', "Le mot de passe a été mis à jour avec succès.");
    }

    // Afficher la page pour affecter les tâches
    public function tacheAffiche()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur connecté est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Trouver tous les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        return view('tuteur.TacheFaire', compact('stagiaires'));
    }

    // Page qui traite l'affectation des tâches
    public function tacheAttribuer(Request $request)
    {
        // Validation du formulaire
        $request->validate([
            'titre_tache' => 'required|string|max:255',
            'description_tache' => 'required|string|max:1000',
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'date_debut' => 'required|date',
        ]); 
    
        // Enregistrement de la tâche 
        $tache = new Tache();
        $tache->titre_tache = $request->titre_tache;
        $tache->description_tache = $request->description_tache;
        $tache->stagiaire_id = $request->stagiaire_id;
        $tache->date_debut = now();
        $tache->save();
    
        return redirect()->route('listeTacheAfaire.tuteur')->with('message', 'La tâche est attribuée avec succès.');
    }

    // Page qui affiche la liste des stagiaires affectés
    public function listeStagiaireAffecte()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur connecté est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Trouver tous les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        // Vérifier s'il y a des stagiaires affectés
        if ($stagiaires->isEmpty()) {
            return view('tuteur.listeStagiaireAffecte', ['message' => 'Aucun stagiaire n\'est affecté']);
        }


        return view('tuteur.listeStagiaireAffecte', compact('stagiaires'));
    }

    // Page qui affiche la liste des tâches à accomplir
    public function listeTacheAfaire()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Récupérer les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        // Récupérer les tâches en cours pour chaque stagiaire
        $taches = Tache::where('statut', 'en cours')
                    ->whereIn('stagiaire_id', $stagiaires->pluck('id'))
                    ->get();

        return view('tuteur.listeTacheFaire', compact('taches'));
    }

    // Page qui affiche la liste des tâches déjà accomplies
    public function listeTacheAccomplie()
    {
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Récupérer les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        $taches = Tache::where('statut', '!=', 'en cours')->whereIn('stagiaire_id', $stagiaires->pluck('id'))->get();

        return view('tuteur.listeTacheAccomplie', compact('taches'));
    }

    // Afficher la page pour affecter les tâches
    public function projetAffiche()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur connecté est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Trouver tous les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        return view('tuteur.attribuerProjet', compact('stagiaires'));
    }

    // Page qui traite l'affectation des projets
    public function projetAttribuer(Request $request)
    {
        // Validation du formulaire
        $request->validate([
            'titre_projet' => 'required|string|max:255',
            'description_projet' => 'required|string|max:1000',
            'date_debut' => 'required|date',
            'stagiaire_id' => 'required|uuid|exists:stagiaires,id',
        ]); 
    
        // Enregistrement du projet 
        $projet = new Projet();
        $projet->titre_projet = $request->titre_projet;
        $projet->description_projet = $request->description_projet;
        $projet->date_debut = now();
        $projet->save();

        // Association avec le stagiaire dans la table pivot
        $projet->stagiaires()->attach($request->stagiaire_id);
    
        return redirect()->route('listeProjet')->with('message', 'Le projet a été attribué avec succès.');
    }

    // Page qui affiche la liste des projets à accomplir
    public function listeProjet()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Récupérer les stagiaires associés à ce tuteur
        $stagiaires = Stagiaire::where('tuteur_id', $tuteur->id)->get();

        // Récupérer les projets en cours associés à ces stagiaires
        $projets = Projet::whereHas('stagiaires', function ($query) use ($stagiaires) {
                                $query->whereIn('stagiaire_id', $stagiaires->pluck('id'));
                            })
                            ->with(['stagiaires.user']) // Charger les relations pour éviter les requêtes N+1
                            ->get();

        return view('tuteur.listeProjet', compact('projets'));
    }

    // La page tuteurSidebar
    public function tuteurSidebar()
    {
        // Récupérer l'utilisateur connecté (tuteur)
        $tuteur = Auth::user();

        // Vérifier que l'utilisateur connecté est bien un tuteur
        $tuteur = Tuteur::where('user_id', $tuteur->id)->first();

        // Si le tuteur n'existe pas, rediriger ou afficher un message d'erreur
        if (!$tuteur) {
            return redirect()->route('welcome')->with('error', 'Tuteur introuvable');
        }

        // Récupérer les stagiaires affectés ou une collection vide si aucun tuteur
        $stagiaires = $tuteur ? $tuteur->stagiaires : collect();

        return view('layouts.tuteurSidebar', compact('stagiaires'));
    }

    // Voir le détail du projet donné au stagiaire
    public function voirProjet($id)
    {
        $projet = Projet::with('stagiaires')->findOrFail($id); // Charge les stagiaires associés au projet
        
        return view('tuteur.voirProjet', compact('projet'));
    }

    // La page de consultation du rapport final des stagiaires
    public function consulteRapport()
    {
        $tuteur = Auth::user()->tuteur;
        
        // Récupérer les stagiaires affectés à ce tuteur
        $stagiaires = $tuteur->stagiaires;

        // Récupérer les rapports des stagiaires affectés au tuteur
        $rapports = Rapport::whereIn('stagiaire_id', $stagiaires->pluck('id'))->latest()->get();

        return view('tuteur.consulteRapport', compact('rapports'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Rapport;
use App\Notifications\DemandeDeStageNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // Le tableau de bord de l'admin
    public function dashboard()
    {
        // Nombre de stagiaires acceptés
        $stagiairesAcceptes = Stagiaire::with('demandes')->whereHas('demandes', function($query) {
                $query->where('statut', 'acceptée');
            })->count();

        // Nombre de stagiaires refusés
        $stagiairesRefuses = Stagiaire::with('demandes')
        ->whereHas('demandes', function($query) {
            $query->where('statut', 'refusée');
        })
        ->count();

        $tuteurs = User::where('role', 'tuteur')->count();

        $admins = User::where('role', 'admin')->count();

        return view('admin.index', compact('stagiairesAcceptes', 'stagiairesRefuses', 'tuteurs', 'admins'));
    }
    
    // Méthode pour afficher la liste des stagiaires
    public function tuteur()
    {
        $users = User::where('role', 'tuteur')->latest()->paginate(1);

        return view('admin.tuteur', compact('users'));
    }

    // Méthode pour afficher la liste des stagiaires
    public function stagiaire()
    {
        $stagiaires = Stagiaire::whereHas('demandes')->with(['users', 'demandes'])->get();
        
        return view('admin.statistic', compact('stagiaires'));
    }

    public function accepte()
    {
        $stagiaires = Stagiaire::whereHas('demandes', function($query) {
            $query->where('statut', 'acceptée');
        })->with(['user', 'demandes'])->latest()->paginate(1);

        return view('admin.stagiaireAccepte', compact('stagiaires'));
    }

    public function refus()
    {
        $stagiaires = Stagiaire::whereHas('demandes', function($query) {
            $query->where('statut', 'refusée');
        })->with(['user', 'demandes'])->latest()->paginate(1);

        return view('admin.stagiaireRefuse', compact('stagiaires'));
    }

    // Méthode pour afficher la liste de tous les utilisateurs
    public function liste()
    {
        $stagiaires = Stagiaire::whereHas('demandes', function($query) {
                $query->where('statut', 'acceptée');
            })->with(['user', 'demandes'])->get();

        $tuteurs = User::where('role', 'tuteur')->get();

        // Fusionner les deux collections
        $users = $stagiaires->merge($tuteurs)->sortBy('nom');

        // La pagination manuelle
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 3;

        $currentItems = $users->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedUsers = new LengthAwarePaginator(
            $currentItems,
            $users->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.affiche', ['users' => $paginatedUsers]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

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

        return redirect()->route('profile')->with('success', 'Votre profil a été mis à jour.');
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

    // La page qui affiche la liste des demandes de stage
    public function recevoirDemande()
    {
        $demandes = Demande::with('stagiaire')->where('statut', 'en attente')->get();
        return view('admin.recevoirDemande', compact('demandes'));
    }

    public function recevoirDemandeUpdate(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);
        $nouveauStatut = $request->input('statut');

        // Mettre à jour le statut
        $demande->statut = $nouveauStatut;

        // Si le statut devient 'acceptée', on met à jour la date_acceptation
        if ($nouveauStatut == 'acceptée' && is_null($demande->date_acceptation)) {
            $demande->date_acceptation = now();
            Log::info('Date acceptation mise à jour : ' . $demande->date_acceptation);
        }

        // Sauvegarder la demande
        $demande->save();

        Log::info('Statut mis à jour : ' . $demande->statut);

        return redirect()->route('recevoirDemande')->with('success', 'Statut de la demande mis à jour avec succès.');
    }

    // La liste des rapports de stage
    public function consulterRapport()
    {
        // Récupérer tous les rapports avec les informations des stagiaires
        $rapports = Rapport::with('stagiaire.user')->get();

        return view('admin.consulterRapport', compact('rapports'));
    }

    // Méthode pour effectuer une recherche
    public function rechercher( Request $request)
    {
        $query = $request->input('query');

        $resultat = User::where('nom', 'LIKE', '%' . $query . '%')->orWhere('prenom', 'LIKE', '%' . $query . '%')->orWhere('role', 'LIKE', '%' . $query . '%')->orWhere('email', 'LIKE', '%' . $query . '%')->paginate(1)->appends(['query' => $query]);

        return view('admin.resultat', compact('resultat', 'query'));
    }

}

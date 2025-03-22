<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Demande;
use App\Models\Stagiaire;
use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('id')->get();
        return view('admin.affiche', compact('users'));
    }

    public function FormulaireInscription()
    {
        return view('inscription');
    }
    
    // L'inscription d'un utilisateur
    public function inscrire( Request $request)
    {
        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'contact' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'mot_de_passe' => 'required|string|min:8',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'date_de_naissance' => 'nullable|date',
                'commentaire' => 'nullable|string|max:1000',
            ]
        );

        // Créer un utilisateur
        $user = User::create([
            'id' => Str::uuid(),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'role' => 'stagiaire',
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'mot_de_passe' => bcrypt($request->input('mot_de_passe')),
        ]);

        if ($request->hasFile('photo'))
        {
            $file = $request->file('photo');

            $file_name = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads'), $file_name);

            $user->photo = 'uploads/' . $file_name;

            $user->save();
        }

        // Associer l'utilisateur à son rôle spécifique
        switch ($user->role) {
            case 'stagiaire':
                // Vérifier si le stagiaire existe déjà
                if (!$user->stagiaire) {
                    $user->stagiaire()->create([
                        'id' => Str::uuid(),
                        'date_de_naissance' => $request->input('date_de_naissance'),
                        'commentaire' => $request->input('commentaire'),
                    ]);
                }
                break;

            case 'tuteur':
                if (!$user->tuteur) {
                    $user->tuteur()->create([
                        'id' => Str::uuid(),
                    ]);
                }
                break;

            case 'admin':
                if (!$user->admin) {
                    $user->admin()->create([
                        'id' => Str::uuid(),
                    ]);
                }
                break;
        }

        session()->flash('message', 'Votre compte a été créé avec succès !');

        return redirect()->route('login');
    }

    public function FormulaireConnexion()
    {
        return view('connexion');
    }

    public function connexion(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|string|email',
            'mot_de_passe' => 'required|min:8',
        ]);

        // Récupération de l'utilisateur avec l'email
        $user = User::where('email', $request->email)->first();

        // Vérificafions si l'utilisateur existe et si le mot de passe est correct
        if ($user && Hash::check($request->mot_de_passe, $user->mot_de_passe))
        {
            // Connexion réussie
            Auth::login($user);

            // Redirection en fonction du rôle
            switch ($user->role)
            {
                case 'tuteur':
                    return redirect()->route('dashboard.tuteur')->with('username', $user->nom);
                case 'admin':
                    return redirect()->route('dashboard')->with('username', $user->nom);
                default:
                    return redirect()->route('welcome')->with('username', $user->nom);
            }
        }

        // Si l'authentification échoue, retourner un message d'erreur
        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
    }

    // La page de changement de statut
    public function changeRoleAffiche()
    {
        $users = User::all();
        return view('admin.changeRole', compact('users'));
    }

    // Changer le rôle d'un utilisateur
    public function changeRole(Request $request, $userId)
    {

        // Validation des données entrantes
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:stagiaire,tuteur,admin',
        ]); 

        // Récupérer l'utilisateur ou renvoyer une erreur 404
        $user = User::findOrFail($userId);

        // Vérification et mise à jour du rôle
        if ($user->role !== $request->input('role'))
        {
            $newRole = $request->input('role');

            // Si le rôle est "stagiaire", vérifier si un stagiaire existe pour cet utilisateur et le créer si nécessaire
            if ($newRole === 'stagiaire') {
                // Si l'utilisateur n'a pas encore de stagiaire, créer un enregistrement dans la table "stagiaires"
                if (!$user->stagiaire) {
                    Stagiaire::create([
                        'user_id' => $user->id,
                        'commentaire' => 'Nouveau stagiaire',
                    ]);
                    Log::info('Stagiaire créé pour l\'utilisateur', ['user_id' => $user->id]);
                }
            } else {
                // Si le rôle n'est plus "stagiaire", supprimer l'entrée dans "Stagiaires"
                if ($user->stagiaire) {
                    $user->stagiaire->delete();
                    Log::info('Stagiaire supprimé pour l\'utilisateur', ['user_id' => $user->id]);
                }
            }

            // Si le rôle est "tuteur", créer une entrée dans "Tuteurs"
            if ($newRole === 'tuteur')
            {
                if (!$user->tuteur)
                {
                    Tuteur::create(['user_id' => $user->id]);
                    Log::info('Tuteur créé pour l\'utilisateur', ['user_id' => $user->id]);
                }
            } else {
                // Si le rôle n'est plus "tuteur", supprimer l'entrée dans "Tuteurs"
                if ($user->tuteur) {
                    $user->tuteur->delete();
                }
            }

            // Si le rôle est "admin", créer une entrée dans "Admins"
            if ($newRole === 'admin')
            {
                if (!$user->admin)
                {
                    Admin::create(['user_id' => $user->id]);
                    Log::info('Admin créé pour l\'utilisateur', ['user_id' => $user->id]);
                }
            } else {
                // Si le rôle n'est plus "admin", supprimer l'entrée dans "Admins"
                if ($user->admin)
                {
                    $user->admin->delete();
                }
            }

            // Mettre à jour le rôle dans la table User
            $user->role = $newRole;
            $user->save();
            
        }

        // Redirection avec un message de succès
        return redirect()->route('changeRoleAffiche')->with('success', "Le rôle a été mis à jour avec succès !");
    }

    public function edit()
    {
        $user = Auth::user();
        return view('stagiaire.profil', compact('user'));
    }

    // Mettre à jour le profil
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

        return redirect()->route('profil.user')->with('success', 'Votre profil a été mis à jour.');
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

    // La page de naissance
    public function afficheNaissance()
    {
        $user = Auth::user();

        if ($user->role !== 'stagiaire')
        {
            abort(403, 'Accès non autorisé !');
        }

        return view('stagiaire.naissance', compact('user'));
    }

    public function updateNaissance(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'date_de_naissance' => 'required|date|before:today',
        ]);

        $user->stagiaire->update($request->only('date_de_naissance'));

        return redirect()->route('AfficherDemande')->with('success', 'Profil complété avec succès !');
    }

}

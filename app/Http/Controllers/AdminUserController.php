<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Affichage de la page
    public function index()
    {
        return view('admin.ajouterUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'mot_de_passe' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Création de l'utilisateur
        User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'contact' => $request->contact,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'photo' => $request->photo,
        ]);

        return redirect()->route('dashboard')->with('success', 'Utilisateur ajouté avec succès !');
    }
}

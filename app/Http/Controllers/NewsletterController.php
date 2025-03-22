<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        // Enregistrez l'email dans la base de données
        DB::table('newsletters')->insert([
            'email' => $request->email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optionnel : Envoyer un email de confirmation
        Mail::to($request->email)->send(new \App\Mail\NewsletterConfirmation());

        return back()->with('newsletter_success', 'Vous êtes inscrit(e) à notre Newsletter !');
    }
}

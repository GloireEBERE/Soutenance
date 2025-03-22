<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use App\Notifications\DemandeDeStageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer toutes les notifications
        $notifications = $user->notifications;
        return view('admin.notification', compact('notifications'));
    }

    public function NotificationsLues()
    {
        $user = Auth::user();

        // Marquer toutes les notifications comme lues
        $user->unreadNotifications->markAsRead();

        // Rediriger avec un message de confirmation
        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    // Pour le traitement des demandes (notification)
    public function store(Request $request)
    {
        // La logique d'enregistrement de la demande de stage
        $demande = Demande::create($request->all());

        // Envoyer la notification
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin)
        {
            $admin->notify(new DemandeDeStageNotification($demande));
        }

        return redirect()->route('dashboard');
    }
}

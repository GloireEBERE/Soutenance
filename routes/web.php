<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',  [HomeController::class, 'home'])->name('welcome');

// Affichage du formulaire
Route::get('/inscription', [UserController::class, 'FormulaireInscription'])->name('inscription.form');

// Traitement du formulaire
Route::post('/inscription', [UserController::class, 'inscrire'])->name('inscription.submit');

// Affichage de la page connexion
Route::get('/connexion', [UserController::class, 'FormulaireConnexion'])->name('login');

// Traitement de la page connexion
Route::post('/connexion', [UserController::class, 'connexion'])->name('login.submit');

// La Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Page de déconnexion
Route::post('/deconnexion', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('deconnexion')->middleware('auth');

Route::prefix('stagiaire')->middleware(['auth', 'role:stagiaire'])->group(function () {
    
});

Route::middleware(['auth'])->group(function () {
    // Pour les notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // Affichage de la page de faire la demande
    Route::get('/stagiaire/soumettre/demande', [DemandeController::class, 'AfficherDemande'])->name('AfficherDemande');

    // Envoyer la demande
    Route::post('/stagiaire/soumettre/demande', [DemandeController::class, 'FaireDemande'])->name('FaireDemande');

    // Affiche la liste de demande d'un utilisateur donné
    Route::get('/stagiaire/mes-demandes', [DemandeController::class, 'index'])->name('stagiaire.demandes');

    // Page de modification
    Route::get('/stagiaire/modifier/demande/{id}', [DemandeController::class, 'affiche'])->name('demande.affiche');

    // Modification de la demande
    Route::put('/stagiaire/modifier/demande/{id}', [DemandeController::class, 'update'])->name('demande.update');

    // Pour supprimer la demande
    Route::delete('/demande/{id}', [DemandeController::class, 'detruire'])->name('demande.delete');

    // Affichage de la liste des demandes
    Route::get('/stagiaire/liste-demande', [DemandeController::class, 'listeDemande'])->name('stagiaire.listeDemande');

    // Affichage du profil de l'utilisateur
    Route::get('/utilisateur/dashboard', [StagiaireController::class, 'index'])->name('dashboard.user');

    //Modifier le mot de passe
    Route::put('/mot_de_passe/modifier', [UserController::class, 'updatePassword'])->name('changementMotDePasse');

    // Modifier le profil
    Route::put('/profil/update', [UserController::class, 'updateProfile'])->name('profil.update');

    // Affichage du profil
    Route::get('/stagiaire/profil', [UserController::class, 'edit'])->name('profil.user');

    // Supprimer le profil
    Route::delete('/profil/delete-image', [UserController::class, 'deleteProfileImage'])->name('profil.delete_image');

    // La date de naissance
    Route::get('/stagiaire/date-de-naissance', [UserController::class, 'afficheNaissance'])->name('stagiaire.affiche');
    Route::post('/stagiaire/date-de-naissance', [UserController::class, 'updateNaissance'])->name('stagiaire.naissance');

    // La liste des tâches à effectuer
    Route::get('/stagiaire/liste/tache/a/faire', [StagiaireController::class, 'TacheListeFaire'])->name('TacheListeFaire');

    // Pour mettre à jour le statut de la tâche
    Route::post('/stagiaire/liste/tache/a/faire/{id}', [StagiaireController::class, 'update'])->name('stagiaireTache.update');

    // La liste des tâches déjà effectuées
    Route::get('/stagiaire/liste/tache/valide', [StagiaireController::class, 'TacheListeValider'])->name('TacheListeValider');

    // La route pour afficher la page du rapport de stage
    Route::get('/stagiaire/rapport/final', [StagiaireController::class, 'rapportFinalAffiche'])->name('rapportFinalAffiche');

    // La route pour envoyer le rapport
    Route::post('/stagiaire/rapport/final', [StagiaireController::class, 'RapportFinalUpdate'])->name('RapportFinalUpdate');

    // La route pour consulter son rapport final
    Route::get('/stagiaire/mon/rapport', [StagiaireController::class, 'consulterRapportFinal'])->name('consulterRapportFinal');

    //Pour marquer les notifications comme lues
    Route::get('/notifications/lues', [NotificationController::class, 'NotificationsLues'])->name('notifications.lues');

    // La liste des tâches à effectuer
    Route::get('/stagiaire/liste/projet/a/faire', [StagiaireController::class, 'ProjetListeFaire'])->name('ProjetListeFaire');

    // Pour mettre à jour le statut du projet
    Route::post('/stagiaire/liste/projet/a/faire/{id}', [StagiaireController::class, 'updateProjet'])->name('stagiaire.updateProjet');

    // Pour afficher la page de détail du projet
    Route::get('/stagiaire/affiche/detail/projet/{id}', [StagiaireController::class, 'voirProjet'])->name('voirProjetStagiaire');

    // Pour afficher la liste des projets déjà accomplis
    Route::get('/stagiaire/liste/projets/accomplis', [StagiaireController::class, 'listeProjetValider'])->name('ProjetListeValider');

    
});

// La page principale de tuteur
Route::get('/tuteur/dashboard', [TuteurController::class, 'index'])->name('dashboard.tuteur');

// Affichage du profil de tuteur
Route::get('/tuteur/profil', [TuteurController::class, 'edit'])->name('profil.tuteur');

// Modifier le profil
Route::put('/tuteur/profil/update', [TuteurController::class, 'updateProfile'])->name('profil.TuteurUpdate');

// Supprimer le profil
Route::delete('/tuteur/profil/delete-image', [TuteurController::class, 'deleteProfileImage'])->name('profil.deleteImages');

// Afficher la page pour attribuer la tâche à faire
Route::get('/tuteur/tache', [TuteurController::class, 'tacheAffiche'])->name('tacheAffiche');

// Pour envoyer la tâche
Route::post('/tuteur/tache', [TuteurController::class, 'tacheAttribuer'])->name('tacheAttribuer');

// Afficher la page pour attribuer un projet à faire
Route::get('/tuteur/projet', [TuteurController::class, 'projetAffiche'])->name('projetAffiche');

// Pour envoyer un projet
Route::post('/tuteur/projet', [TuteurController::class, 'projetAttribuer'])->name('projetAttribuer');

// Pour afficher la liste des projets à accomplir
Route::get('/tuteur/liste/projets/faire', [TuteurController::class, 'listeProjet'])->name('listeProjet');

// Pour afficher la page de détail du projet
Route::get('/tuteur/liste/projets/faire/{id}', [TuteurController::class, 'voirProjet'])->name('voirProjet');

// Pour afficher la liste des stagiaires affectés à un tuteur
Route::get('/tuteur/stagiaire/affecté', [TuteurController::class, 'listeStagiaireAffecte'])->name('listeStagiaire.tuteur');

// Pour afficher la liste des tâches à accomplir
Route::get('/tuteur/liste/taches/faire', [TuteurController::class, 'listeTacheAfaire'])->name('listeTacheAfaire.tuteur');

// Pour afficher la liste des tâches déjà accomplies
Route::get('/tuteur/liste/taches/accomplies', [TuteurController::class, 'listeTacheAccomplie'])->name('listeTacheAccomplie.tuteur');

// La route pour consulter le rapport final des stagiaires
Route::get('/tuteur/consulter/rapport', [TuteurController::class, 'consulteRapport'])->name('consulteRapport');

// La route pour consulter le rapport final des stagiaires
Route::get('/tuteur/recherche', [TuteurController::class, 'search'])->name('tuteurRecherche');


//Route::middleware(['auth', 'role:admin'])->group(function () {
//    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//});

Route::prefix('admin')->middleware('auth')->group(function () {
    // Affichage de la liste des stagiaires en attente
    Route::get('/stagiaires', [AdminController::class, 'stagiaire'])->name('stagiaire');

    // Affichage de la liste des tuteurs
    Route::get('/tuteurs', [AdminController::class, 'tuteur'])->name('tuteur');

    // Affichage de la liste complète des utilisateurs
    Route::get('/liste', [AdminController::class, 'liste'])->name('liste');

    // Affichage de la courbe
    Route::get('/courbe', [StagiaireController::class, 'courbe'])->name('statistic');

    Route::get('/affichage', [UserController::class, 'index'])->name('affichage');

    Route::get('/index', [AdminController::class, 'index'])->name('dashboard.index');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [AdminController::class, 'edit'])->name('profile');

    // Afficher la page d'ajout
    Route::get('/ajouter/tuteur', [AdminUserController::class, 'index'])->name('ajoutAffiche');

    // Ajouter un nouveau utilisateur
    Route::post('/ajouter/tuteur', [AdminUserController::class, 'store'])->name('admin.ajout');

    // Afficher la page de changement de statut
    Route::get('/changer-de-statut', [UserController::class, 'changeRoleAffiche'])->name('changeRoleAffiche');

    // Changer le statut
    Route::post('/{userId}/changer-de-statut', [UserController::class, 'changeRole'])->name('changeRole');

    // Modifier le profil
    Route::put('/profil/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Supprimer le profil
    Route::delete('/profil/delete-image', [AdminController::class, 'deleteProfileImage'])->name('profile.deleteImages');

    // Affichage de la liste des stagiaires acceptés
    Route::get('/stagiaire/valider', [AdminController::class, 'accepte'])->name('valider');

    // Affichage de la liste des stagiaires refusés
    Route::get('/stagiaire/refuser', [AdminController::class, 'refus'])->name('refuser');

    // Pour le changement de statut de la demande de stage
    Route::post('/accept/{id}', [StagiaireController::class, 'accept'])->name('user.accept');
    Route::post('/reject/{id}', [StagiaireController::class, 'reject'])->name('user.reject');

    Route::get('/affectation', [AffectationController::class, 'index'])->name('affectation.index');
    Route::post('/affectation/{stagiaire}/tuteur', [AffectationController::class, 'assignTuteur'])->name('affectation.assign');

    // Affichage de la liste de demande de stage
    Route::get('/liste/demande/stage', [AdminController::class, 'recevoirDemande'])->name('recevoirDemande');
    Route::patch('/liste/demande/stage/{id}', [AdminController::class, 'recevoirDemandeUpdate'])->name('recevoirDemandeUpdate');

    // La route pour consulter son rapport final
    Route::get('/liste/rapport/final', [AdminController::class, 'consulterRapport'])->name('consulterRapport');

    // Affichage de la recherche
    Route::get('/resultat', [AdminController::class, 'rechercher'])->name('resultat');

});

#Route::get('/dashboard', function () {
#    return view('admin.index');
#});

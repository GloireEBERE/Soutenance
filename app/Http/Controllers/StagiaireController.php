<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Projet;
use App\Models\Rapport;
use App\Models\Stagiaire;
use App\Models\Tache;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\DemandeDeStageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StagiaireController extends Controller
{
    // Afficher le statut de la demande dans Dashboard
    public function index()
    {
        $user = Auth::user();

        // Vérifie que la relation "stagiaire" existe
        if (!$user->stagiaire) {
            return view('stagiaire.dashboard', [
                'demandes' => collect(), // vue vide sans planter
            ]);
        }

        $stagiaireId = Auth::user()->stagiaire->id; // Récupération via la relation
        $demandes = Demande::where('stagiaire_id', $stagiaireId)->get();


        // Passer la demande à la vue
        return view('stagiaire.dashboard', compact('demandes'));
    }

    // Afficher la liste des tâches à effectuer
    public function TacheListeFaire()
    {
        $taches = Auth::user()->stagiaire->taches()->where('statut', 'en cours')->latest()->paginate(3); 
        // Récupère toutes les tâches du stagiaire connecté
        
        return view('stagiaire.TacheListeFaire', compact('taches'));
    }

    // Pour afficher la page où les tâches déjà faits s'affichent
    public function TacheListeValider()
    {
        $user = Auth::user();

        // Récupérer le stagiaire associé à l'utilisateur
        $stagiaire = $user->stagiaire;

        // Vérifier que le stagiaire existe (par précaution)
        if (!$stagiaire) {
            return redirect()->back()->with('message', 'Aucun stagiaire associé à cet utilisateur.');
        }

        // Récupérer les tâches du stagiaire qui ne sont pas "en cours"
        $taches = Tache::where('stagiaire_id', $stagiaire->id)
                    ->where('statut', '!=', 'en cours')
                    ->latest()->paginate(1);

        return view('stagiaire.TacheListeValider', compact('taches'));
    }

    // Changer le statut de la tâche à faire
    public function update(Request $request, $id)
    {
        // Validation du statut
        $request->validate([
            'statut' => 'required|in:' . Tache::STATUT_TERMINEE . ',' . Tache::STATUT_ANNULEE,
        ]);

        $tache = Auth::user()->stagiaire->taches()->findOrFail($id);

        // Vérifiez que la tâche appartient au stagiaire connecté
        if ($tache->stagiaire_id !== Auth::user()->stagiaire->id) {
            return redirect()->back()->with('message', 'Vous n\'êtes pas autorisé à modifier cette tâche.');
        }

        try {
            // Définir la date de fin si la tâche est terminée ou annulée
            $date_fin = null;
            if (in_array($request->input('statut'), [Tache::STATUT_TERMINEE, Tache::STATUT_ANNULEE])) {
                $date_fin = Carbon::now();  // La date actuelle
            }

            // Mettre à jour le statut et la date_fin
            $tache->update([
                'statut' => $request->input('statut'),
                'date_fin' => $date_fin,  // Mise à jour de la date_fin
            ]);

            return redirect()->route('TacheListeFaire')->with('message', 'Statut mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    // L'affichage de la page du rapport final
    public function rapportFinalAffiche()
    {
        $rapport = Rapport::all();

        return view('stagiaire.RapportFinal', compact('rapport'));
    }

    // Pour enregistrer le rapport final
    public function RapportFinalUpdate(Request $request)
    {
        // Validation des données
        $request->validate([
            'theme_rapport' => 'required|string|max:255',
            'document_rapport' => 'required|mimes:pdf|max:2048',
        ]);

        $stagiaire = Auth::user()->stagiaire; // Utilisateur connecté

        // Vérifier si un stagiaire existe pour cet utilisateur
        if (!$stagiaire) {
            return redirect()->route('welcome')->with('error', 'Aucun stagiaire associé à votre compte.');
        }

        // Vérifier si un rapport existe déjà pour ce stagiaire
        $rapportExistant = Rapport::where('stagiaire_id', $stagiaire->id)->first();

        if ($rapportExistant) {
            // Supprimer le fichier physique de l'ancien rapport
            if ($rapportExistant->document_rapport && Storage::exists('public/' . $rapportExistant->document_rapport)) {
                Storage::delete('public/' . $rapportExistant->document_rapport);
            }
    
            // Supprimer l'ancien rapport de la base de données
            $rapportExistant->delete();
        }

        $rapport = new Rapport();

        if ($request->hasFile('document_rapport'))
        {
            // Obtenir le fichier uploadé
            $fichier = $request->file('document_rapport');

            // Conserver le nom d'origine avec un préfixe unique pour éviter les conflits
            $nomFichier = time() . '_' . $fichier->getClientOriginalName();

            // Stocker le fichier dans le dossier "rapports" du disque "public"
            $chemin = $fichier->storeAs('rapports', $nomFichier, 'public');

            $rapport->document_rapport = $chemin;
        }

        $rapport->theme_rapport = $request->input('theme_rapport'); ;

        $rapport->date_soumission = now();

        // Associer la demande au stagiaire trouvé
        $rapport->stagiaire_id = $stagiaire->id;

        $rapport->save();

        return redirect()->route('dashboard.user')->with('success', 'Rapport soumis avec succès.');

    }

    // La page de consultation de son rapport final
    public function consulterRapportFinal()
    {
        $stagiaire = Auth::user()->stagiaire; 

        $rapportFinal = Rapport::where('stagiaire_id', $stagiaire->id)->latest()->first();
        return view('stagiaire.consulterRapportFinal', compact('rapportFinal'));
    }

    // Afficher la liste des projets à effectuer
    public function ProjetListeFaire()
    {
        $projets = Auth::user()->stagiaire->projets()->where('statut', 'en cours')->latest()->paginate(3); 
        // Récupère toutes les projets du stagiaire connecté
        
        return view('stagiaire.ProjetListeFaire', compact('projets'));
    }

    // Changer le statut du projet à faire
    public function updateProjet(Request $request, $id)
    {
        // Validation du statut
        $request->validate([
            'statut' => 'required|in:' . Projet::STATUT_TERMINE . ',' . Projet::STATUT_ANNULE,
        ]);

        // Récupérer le projet avec la relation plusieurs à plusieurs
        $projet = Projet::findOrFail($id);

        // Vérifier si le stagiaire est bien associé au projet via la table conjointe
        $stagiaire = Auth::user()->stagiaire;
        if (!$stagiaire->projets()->where('projets.id', $id)->exists()) {
            return redirect()->back()->with('message', 'Vous n\'êtes pas autorisé à modifier ce projet.');
        }

        try {
            // Définir la date de fin si le projet est terminé ou annulé
            $date_fin = null;
            if (in_array($request->input('statut'), [Projet::STATUT_TERMINE, Projet::STATUT_ANNULE])) {
                $date_fin = Carbon::now();  // La date actuelle
            }

            // Mettre à jour le statut et la date_fin
            $projet->update([
                'statut' => $request->input('statut'),
                'date_fin' => $date_fin,  // Mise à jour de la date_fin
            ]);

            return redirect()->route('ProjetListeFaire')->with('message', 'Statut mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    // Voir le détail du projet donné au stagiaire
    public function voirProjet($id)
    {
        $projet = Projet::findOrFail($id);
        
        return view('stagiaire.voirProjet', compact('projet'));
    }

    // Page qui affiche la liste des projets déjà accomplis
    public function listeProjetValider()
    {
        $stagiaire = Auth::user()->stagiaire;

        $projets = $stagiaire->projets()->where('statut', '!=', 'en cours')->latest()->paginate(2);

        return view('stagiaire.ProjetListeValider', compact('projets'));
    } 

    //La courbe qui affiche le nombre de stagiaire accepté
    public function courbe()
    {
        $rawData = DB::table('demandes')
            ->select(DB::raw("strftime('%Y', date_acceptation) as year, strftime('%m', date_acceptation) as month, COUNT(*) as count"))
            ->where('statut', 'acceptée') 
            ->whereNotNull('date_acceptation')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Débogage pour vérifier les données brutes
        //dd($rawData);

        $chartData = $rawData->map(function ($item) {
            return [
                'year' => (string) $item->year,
                'month' => str_pad($item->month, 2, '0', STR_PAD_LEFT),
                'count' => (int) $item->count,
            ];
        })->toArray();

        // Encoder en JSON pour éviter l'erreur avec @json
        $chartDataJson = json_encode($chartData);

        // Génération des mois manquants
        $startYear = 2025;
        $endYear = date('Y');
        $filledData = [];

        

        // Passer les données à la vue
        return view('admin.statistic', compact('chartDataJson'));
    }

}

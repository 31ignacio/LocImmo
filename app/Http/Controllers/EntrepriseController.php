<?php

namespace App\Http\Controllers;

use App\Mail\ActiverMail;
use App\Mail\DesactiverMail;
use App\Models\Appartement;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Mail;

class EntrepriseController extends Controller
{
    /**
     * Liste des entreprises inscrites (côté ADMIN)
     */
    public function index()
    {
        $entreprises = Entreprise::with('user')->latest()->paginate(10);

        return view('Entreprises.index', compact('entreprises'));
    }

    /**
     * Afficher l'espace de l'entreprise connecté avec ses annonces
     */
    public function espace()
    {
        $user = auth()->user()->id;
        $entreprise = Entreprise::where('user_id', $user)->first();
        
        if (!$entreprise) {
            return redirect()->back()->with('error', 'Aucune entreprise trouvée pour cet utilisateur.');
        }

        $entrepriseId = $entreprise->id;
        $nombreAppartements = Appartement::where('entreprise_id', $entrepriseId)->count();
        $totalViews = Appartement::where('entreprise_id', $entrepriseId)->sum('views');
        $appartements = Appartement::where('entreprise_id', $entrepriseId)->latest()->get();

        return view('Entreprises.espace', compact('appartements', 'totalViews', 'nombreAppartements', 'entreprise'));
    }

   

    /**
     * Activer un compte entreprise
     */
    public function activer($id)
    {
        return $this->toggleActivation($id, true);
    }

    /**
     * Désactiver un compte entreprise
     */
    public function desactiver($id)
    {
        return $this->toggleActivation($id, false);
    }

    /**
     * Logique commune d'activation/désactivation
     */
    private function toggleActivation($id, bool $active)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        $user = $entreprise->user;

        if (!$user) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Aucun utilisateur associé à cette entreprise.'], 400);
            }
            return redirect()->back()->with('error', 'Aucun utilisateur associé à cette entreprise.');
        }

        // Mettre à jour le statut
        $user->estActive = $active ? 1 : 0;
        $user->save();

        // Envoyer l'email
        $mailClass = $active ? ActiverMail::class : DesactiverMail::class;
        $action = $active ? 'activée' : 'désactivée';

        try {
            Mail::to($user->email)->send(new $mailClass($user));
        } catch (\Throwable $e) {
            report($e);
            
            if (request()->ajax()) {
                return response()->json([
                    'warning' => "Compte {$action} mais l'email n'a pas pu être envoyé.",
                    'status' => 'warning'
                ]);
            }
            
            return redirect()->back()
                ->with('warning', "Entreprise {$action}, mais l'e-mail n'a pas pu être envoyé.");
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => "Compte {$action} avec succès.",
                'status' => 'success',
                'estActive' => $active
            ]);
        }

        return redirect()->back()->with('success', "Entreprise {$action} avec succès.");
    }

    /**
     * Supprimer une entreprise (optionnel)
     */
    public function destroy($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        
        // Supprimer les annonces associées
        Appartement::where('entreprise_id', $id)->delete();
        
        // Supprimer l'entreprise
        $entreprise->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Entreprise supprimée avec succès.']);
        }

        return redirect()->back()->with('success', 'Entreprise supprimée avec succès.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Mail\ActiverMail;
use App\Mail\DesactiverMail;
use App\Models\Appartement;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EntrepriseController extends Controller
{
    //
    /**
     * Liste des entreprise inscrits ( coté ADMIN)
    */
    public function index(){

        $entreprises= Entreprise::latest()->paginate(5);

        return view('Entreprises.index',compact('entreprises'));
    }

    /**
     * Afficher l'espace de l'entreprise connecté avec ces annonces
    */
    public function espace(){

        $user= auth()->user()->id;
        $entreprises= Entreprise::where('user_id', $user)->first();
        $entreprise= $entreprises->id;
        //$appartements= Appartement::where('entreprise_id', $entreprise)->latest()->get();

        $nombreAppartements = Appartement::where('entreprise_id', $entreprise)->count();
        $totalViews = Appartement::where('entreprise_id', $entreprise)->sum('views');
        $appartements = Appartement::where('entreprise_id', $entreprise)->latest()->get();

        return view('Entreprises.espace',compact('appartements','totalViews','nombreAppartements'));
    }

    public function show($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        
        return view('Entreprises.show', compact('entreprise'));
    }

    public function activer($id)
    {
        return $this->toggleActivation($id, true);
    }

    public function desactiver($id)
    {
        return $this->toggleActivation($id, false);
    }

    private function toggleActivation($id, bool $active)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        $user = $entreprise->user;

        if (!$user) {
            return redirect()->back()->with('error', 'Aucun utilisateur associé à cette entreprise.');
        }

        $user->estActive = $active ? 1 : 0;
        $user->save();

        $mailClass = $active ? ActiverMail::class : DesactiverMail::class;
        $action    = $active ? 'activée' : 'désactivée';

        try {
            Mail::to($user->email)->send(new $mailClass($user));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->back()
                ->with('error', "Entreprise {$action}, mais l'e-mail n'a pas pu être envoyé.");
        }

        return redirect()->back()->with('success', "Entreprise {$action} avec succès.");
    }

}

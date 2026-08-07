<?php

namespace App\Http\Controllers;

use App\Mail\ContacteMail;
use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContacteController extends Controller
{
    //
    /**
     * Affiche le formulaie de contact
     */
    public function contacte(){

        return view("contacte.create");
    }

    /**
     * Envoyer un msg via le formulaire de contact
     */
    public function store(Request $request){

        $request->validate([
            'nom'=>'required',
            'prenom'=>'required',
            'sujet'=>'required',
            'message'=>'required',
            'email'=>'required'

        ], [
            'nom.required'=>'Votre nom est requis',
            'prenom.required'=>'Votre prénom est requis',
            'sujet.required'=>'Le sujet est requis',
            'message.required'=>'Le message est requis',
            'email.required'=>'Votre email est requis',
            
        ]);
            $adresse = config('mail.from.address');

            $nom = $request->nom;
            $prenom = $request->prenom;
            $sujet = $request->sujet;
            $message = $request->message;
            $email = $request->email;

            Mail::to($adresse)->send(new ContacteMail($nom, $prenom, $email, $sujet, $message));

                return back()->with('success', 'Votre message a bien été transmis .');
    }

  

  
    
}

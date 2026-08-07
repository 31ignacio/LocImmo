<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterInscriptionMail;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    //

    public function newsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Votre email est requis.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
        ]);

        $email = $request->email;

        // Contrôle manuel de doublon
        if (Newsletter::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Cet email est déjà inscrit à notre newsletter.');
            // ou pour une API : return response()->json(['message' => 'Cet email est déjà inscrit à notre newsletter.'], 422);
        }

        Newsletter::create(['email' => $email]);

        Mail::to($email)->send(new NewsletterInscriptionMail($email));

        return redirect()->back()->with('success', 'Vous avez été abonné à notre newsletter avec succès !');
    }


    /**
     * Se deshaboner de not newsletter
    */
    public function unsubscribe($email)
    {
        Newsletter::where('email', $email)->delete();

        return redirect()->route('home')
            ->with('success', 'Vous avez été désabonné avec succès.');
    }

}



 






        
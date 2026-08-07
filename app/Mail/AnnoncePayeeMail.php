<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnoncePayeeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appartement;

    public function __construct($appartement)
    {
        $this->appartement = $appartement;
    }

    public function build()
    {
        return $this->view('emails.annonce_payee')
                    ->subject('Votre annonce a été publiée');
    }
}

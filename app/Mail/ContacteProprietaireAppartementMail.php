<?php

namespace App\Mail;

use App\Models\Appartement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContacteProprietaireAppartementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $telephone;
    public $email;
    public $messageContent;
    public $appartement;

    public function __construct($nom, $telephone, $email, $messageContent, Appartement $appartement)
    {
        $this->nom            = $nom;
        $this->telephone      = $telephone;
        $this->email          = $email;
        $this->messageContent = $messageContent;
        $this->appartement    = $appartement;
    }

    public function build()
    {
        return $this->view('emails.contacteProprietaireAppartement')
                    ->subject('Nouveau message pour votre annonce "' . $this->appartement->type . ' — ' . $this->appartement->quartier . '"');
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContacteProprietaireAppartementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $telephone;
    public $email;
    public $message;



    public function __construct($nom, $telephone, $email, $message)
    {
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->message = $message;

    }

    public function build()
    {
        return $this->markdown('emails.contacteProprietaireAppartement')
                    ->subject('Vous avez reçu un nouveau message !');
    }}

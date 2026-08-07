<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContacteMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $nom;
    public $prenom;
    public $email;
    public $sujet;
    public $message;



    public function __construct($nom, $prenom, $email, $sujet, $message)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->sujet = $sujet;
        $this->message = $message;

    }

    public function build()
    {
        return $this->markdown('emails.contacte')
                    ->subject('Vous avez reçu un nouveau message !');
    }}

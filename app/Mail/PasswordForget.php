<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordForget extends Mailable
{
    use Queueable, SerializesModels;

    
     public $code;
     public $email;
     public $name;
    public function __construct($code, $email, $name)
    {
        //
        $this->code=$code;
        $this->email= $email;
        $this->name= $name;
    }

    public function build()
    {
        return $this->markdown('emails.passwordForget')
                    ->subject('Réinitialisation de votre mot de passe');
    }   
}

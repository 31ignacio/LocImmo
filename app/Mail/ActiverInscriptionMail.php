<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActiverInscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;
    public $prenom;

    public function __construct($code, $email, $prenom)
    {
        $this->code = $code;
        $this->email = $email;
        $this->prenom = $prenom;
    }

    public function build()
    {
        return $this->subject('Activation de votre compte')
                    ->view('emails.activation-compte');
    }
}

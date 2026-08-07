<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InscriptionEntrepriseNotification;

class NotifictionInscription implements ShouldQueue
{
    use Queueable;
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $code;
    protected $nom;
        /**
     * Create a new job instance.
     */
    public function __construct($email, $code, $nom)
    {
        $this->email = $email;
        $this->code = $code;
        $this->nom = $nom;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // Envoyer la notification par e-mail à l'utilisateur
        Notification::route('mail', $this->email)->notify(new InscriptionEntrepriseNotification($this->code, $this->email, $this->nom));
                
    }
}

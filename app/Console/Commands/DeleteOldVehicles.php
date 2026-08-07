<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicule;
use Carbon\Carbon;

class DeleteOldVehicles extends Command
{
    


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-vehicles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // Supprimer les véhicules plus anciens que la date actuelle
        Vehicule::whereDate('created_at', '<', Carbon::today())->delete();

        $this->info('Old vehicles have been deleted successfully.');
    }
}

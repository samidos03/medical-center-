<?php
namespace App\Console\Commands;
use App\Mail\RappelRdv;
use App\Models\Rendezvous;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelsRdv extends Command
{
    protected $signature = 'rdv:rappels';
    protected $description = 'Envoyer les rappels de RDV pour demain';

    public function handle()
    {
        $demain = now()->addDay()->format('Y-m-d');
        $rdvs = Rendezvous::with(['patient.user', 'medecin.user'])
            ->whereDate('date_rdv', $demain)
            ->where('statut', 'confirme')
            ->get();

        $count = 0;
        foreach ($rdvs as $rdv) {
            try {
                Mail::to($rdv->patient->user->email)->send(new RappelRdv($rdv));
                $count++;
            } catch (\Exception $e) {
                $this->error('Erreur: ' . $e->getMessage());
            }
        }
        $this->info($count . ' rappels envoyes pour le ' . $demain);
    }
}

<?php
namespace Database\Seeders;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rendezvous;
use App\Models\User;
use Illuminate\Database\Seeder;
class RendezvousSeeder extends Seeder
{
    public function run(): void
    {
        $medecin = Medecin::first();
        if (!$medecin) return;

        $patients = Patient::with('user')->take(4)->get();

        $rdvs = [
            [
                'date_rdv'  => now()->addDays(1)->format('Y-m-d'),
                'heure_rdv' => '09:00:00',
                'statut'    => 'confirme',
            ],
            [
                'date_rdv'  => now()->addDays(2)->format('Y-m-d'),
                'heure_rdv' => '10:30:00',
                'statut'    => 'en_attente',
            ],
            [
                'date_rdv'  => now()->addDays(3)->format('Y-m-d'),
                'heure_rdv' => '11:00:00',
                'statut'    => 'confirme',
            ],
            [
                'date_rdv'  => now()->subDays(2)->format('Y-m-d'),
                'heure_rdv' => '14:00:00',
                'statut'    => 'annule',
            ],
        ];

        foreach ($rdvs as $index => $rdv) {
            if (isset($patients[$index])) {
                Rendezvous::create([
                    'patient_id' => $patients[$index]->id,
                    'medecin_id' => $medecin->id,
                    'date_rdv'   => $rdv['date_rdv'],
                    'heure_rdv'  => $rdv['heure_rdv'],
                    'statut'     => $rdv['statut'],
                ]);
            }
        }
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Rendezvous;
use Illuminate\Support\Facades\DB;

class SecretaireController extends Controller
{
    public function dashboard()
    {
        $rdvToday = Rendezvous::with(['patient.user','medecin.user','medecin.specialite'])
            ->whereDate('date_rdv', today())
            ->orderBy('heure_rdv')->get();

        $prochains = Rendezvous::with(['patient.user','medecin.user','medecin.specialite'])
            ->whereDate('date_rdv', '>', today())
            ->orderBy('date_rdv')->orderBy('heure_rdv')
            ->take(10)->get();

        $rdvParMois = Rendezvous::select(
                DB::raw('MONTH(date_rdv) as mois'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('date_rdv', date('Y'))
            ->groupBy('mois')->orderBy('mois')
            ->get()->keyBy('mois');

        $rdvMoisData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rdvMoisData[] = $rdvParMois->get($i)?->total ?? 0;
        }

        $stats = [
            'rdv_today'     => $rdvToday->count(),
            'total_patients'=> Patient::count(),
            'rdv_confirmes' => Rendezvous::where('statut','confirme')->count(),
            'rdv_attente'   => Rendezvous::where('statut','en_attente')->count(),
            'rdv_annules'   => Rendezvous::where('statut','annule')->count(),
            'rdv_total'     => Rendezvous::count(),
        ];

        return view('secretaire.dashboard', compact('rdvToday','prochains','stats','rdvMoisData'));
    }
}


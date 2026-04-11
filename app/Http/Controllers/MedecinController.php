<?php
namespace App\Http\Controllers;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\Rendezvous;
use Illuminate\Support\Facades\DB;

class MedecinController extends Controller
{
    public function dashboard()
    {
        $medecin = auth()->user()->medecin;
        if (!$medecin) return view('medecin.dashboard', ['rdvs'=>collect(),'stats'=>[],'rdvMoisData'=>[],'prochains'=>collect()]);

        $rdvs = Rendezvous::with(['patient.user'])
            ->where('medecin_id', $medecin->id)
            ->whereDate('date_rdv', today())
            ->orderBy('heure_rdv')
            ->get();

        $prochains = Rendezvous::with(['patient.user'])
            ->where('medecin_id', $medecin->id)
            ->whereDate('date_rdv', '>=', today())
            ->where('statut', 'confirme')
            ->orderBy('date_rdv')->orderBy('heure_rdv')
            ->take(5)->get();

        $stats = [
            'rdv_today'    => $rdvs->count(),
            'rdv_total'    => Rendezvous::where('medecin_id', $medecin->id)->count(),
            'patients'     => Rendezvous::where('medecin_id', $medecin->id)->distinct('patient_id')->count(),
            'confirmes'    => Rendezvous::where('medecin_id', $medecin->id)->where('statut','confirme')->count(),
            'en_attente'   => Rendezvous::where('medecin_id', $medecin->id)->where('statut','en_attente')->count(),
            'consultations'=> Consultation::where('medecin_id', $medecin->id)->count(),
        ];

        $rdvParMois = Rendezvous::select(
                DB::raw('MONTH(date_rdv) as mois'),
                DB::raw('COUNT(*) as total')
            )
            ->where('medecin_id', $medecin->id)
            ->whereYear('date_rdv', date('Y'))
            ->groupBy('mois')->orderBy('mois')
            ->get()->keyBy('mois');

        $rdvMoisData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rdvMoisData[] = $rdvParMois->get($i)?->total ?? 0;
        }

        return view('medecin.dashboard', compact('rdvs','stats','rdvMoisData','prochains'));
    }
}

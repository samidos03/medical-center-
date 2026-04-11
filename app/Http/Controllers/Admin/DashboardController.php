<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rendezvous;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            "patients"    => Patient::count(),
            "medecins"    => Medecin::count(),
            "secretaires" => User::where("role", "secretaire")->count(),
            "rdv_today"   => Rendezvous::whereDate("date_rdv", today())->count(),
            "users"       => User::count(),
            "rdv_total"   => Rendezvous::count(),
            "confirmes"   => Rendezvous::where("statut", "confirme")->count(),
            "en_attente"  => Rendezvous::where("statut", "en_attente")->count(),
            "annules"     => Rendezvous::where("statut", "annule")->count(),
        ];

        $recentRdv = Rendezvous::with(["patient.user", "medecin.user"])
            ->latest()->take(5)->get();

        $rdvParMois = Rendezvous::select(
                DB::raw("MONTH(date_rdv) as mois"),
                DB::raw("COUNT(*) as total")
            )
            ->whereYear("date_rdv", date("Y"))
            ->groupBy("mois")
            ->orderBy("mois")
            ->get()->keyBy("mois");

        $rdvMoisData = [];
        for ($i = 1; $i <= 12; $i++) {
            $rdvMoisData[] = $rdvParMois->get($i)?->total ?? 0;
        }

        $patientsParMois = Patient::select(
                DB::raw("MONTH(created_at) as mois"),
                DB::raw("COUNT(*) as total")
            )
            ->whereYear("created_at", date("Y"))
            ->groupBy("mois")
            ->orderBy("mois")
            ->get()->keyBy("mois");

        $patientsMoisData = [];
        for ($i = 1; $i <= 12; $i++) {
            $patientsMoisData[] = $patientsParMois->get($i)?->total ?? 0;
        }

        $medecinsActifs = Medecin::with(["user", "specialite"])
            ->withCount("rendezvous")
            ->orderByDesc("rendezvous_count")
            ->take(5)->get();

        return view("admin.dashboard", compact(
            "stats", "recentRdv", "rdvMoisData",
            "patientsMoisData", "medecinsActifs"
        ));
    }
}

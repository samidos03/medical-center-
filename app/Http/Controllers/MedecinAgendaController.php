<?php
namespace App\Http\Controllers;
use App\Models\Rendezvous;

class MedecinAgendaController extends Controller
{
    public function index()
    {
        $medecin = auth()->user()->medecin;
        $rdvs = Rendezvous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->whereDate('date_rdv', '>=', now()->startOfMonth())
            ->whereDate('date_rdv', '<=', now()->endOfMonth())
            ->orderBy('date_rdv')->orderBy('heure_rdv')
            ->get()
            ->groupBy('date_rdv');
        $mois = now()->format('Y-m');
        return view('medecin.agenda', compact('rdvs', 'mois'));
    }
}

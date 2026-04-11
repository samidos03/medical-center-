<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Rendezvous;

class MedecinPatientController extends Controller
{
    public function index()
    {
        $medecin = auth()->user()->medecin;
        $patientIds = Rendezvous::where('medecin_id', $medecin->id)
            ->distinct()->pluck('patient_id');
        $patients = Patient::with('user')
            ->whereIn('id', $patientIds)
            ->get()
            ->map(function($p) use ($medecin) {
                $p->rdv_count = Rendezvous::where('medecin_id', $medecin->id)
                    ->where('patient_id', $p->id)->count();
                $p->dernier_rdv = Rendezvous::where('medecin_id', $medecin->id)
                    ->where('patient_id', $p->id)
                    ->latest('date_rdv')->first();
                return $p;
            });
        return view('medecin.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $medecin = auth()->user()->medecin;
        $patient->load('user');
        $rdvs = Rendezvous::with('consultation.ordonnance')
            ->where('medecin_id', $medecin->id)
            ->where('patient_id', $patient->id)
            ->orderByDesc('date_rdv')->get();
        return view('medecin.patients.show', compact('patient', 'rdvs'));
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Rendezvous;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;
        $rdvs = $patient
            ? Rendezvous::with(['medecin.user'])
                ->where('patient_id', $patient->id)
                ->latest('date_rdv')->get()
            : collect();

        $prochain = $patient
            ? Rendezvous::with(['medecin.user','medecin.specialite'])
                ->where('patient_id', $patient->id)
                ->where('statut','confirme')
                ->whereDate('date_rdv','>=',today())
                ->orderBy('date_rdv')->orderBy('heure_rdv')
                ->first()
            : null;

        return view('patient.dashboard', compact('rdvs','prochain'));
    }

    public function index(){}
    public function create(){}
    public function store(){}
    public function show(Patient $patient){}
    public function edit(Patient $patient){}
    public function update(){}
    public function destroy(Patient $patient){}
}

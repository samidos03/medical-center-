<?php
namespace App\Http\Controllers;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rendezvous;
use Illuminate\Http\Request;

class PatientRendezvousController extends Controller
{
    private function getPatient()
    {
        $patient = auth()->user()->patient;
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => auth()->id(),
            ]);
        }
        return $patient;
    }

    public function index()
    {
        $patient = $this->getPatient();
        $rdvs = Rendezvous::with(['medecin.user','medecin.specialite'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('date_rdv')->paginate(10);
        return view('patient.rendezvous.index', compact('rdvs'));
    }

    public function create()
    {
        $medecins = Medecin::with(['user','specialite'])->get();
        return view('patient.rendezvous.create', compact('medecins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_rdv'   => 'required|date|after_or_equal:today',
            'heure_rdv'  => 'required',
        ]);
        $patient = $this->getPatient();
        Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $request->medecin_id,
            'date_rdv'   => $request->date_rdv,
            'heure_rdv'  => $request->heure_rdv,
            'statut'     => 'en_attente',
        ]);
        return redirect()->route('patient.rendezvous.index')
            ->with('success', 'Appointment booked successfully.');
    }

    public function edit(Rendezvous $rendezvous)
    {
        $medecins = Medecin::with(['user','specialite'])->get();
        return view('patient.rendezvous.edit', compact('rendezvous','medecins'));
    }

    public function update(Request $request, Rendezvous $rendezvous)
    {
        $request->validate([
            'date_rdv'  => 'required|date|after_or_equal:today',
            'heure_rdv' => 'required',
        ]);
        $rendezvous->update([
            'date_rdv'  => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
        ]);
        return redirect()->route('patient.rendezvous.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function annuler(Rendezvous $rendezvous)
    {
        $rendezvous->update(['statut' => 'annule']);
        return back()->with('success', 'Appointment cancelled.');
    }

    public function historique()
    {
        $patient = $this->getPatient();
        $rdvs = Rendezvous::with(['medecin.user','medecin.specialite','consultation.ordonnance'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('date_rdv')->get();
        return view('patient.rendezvous.historique', compact('rdvs'));
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Rendezvous;
use Illuminate\Http\Request;

class MedecinConsultationController extends Controller
{
    public function index()
    {
        $medecin = auth()->user()->medecin;
        $consultations = Consultation::with(['patient.user', 'ordonnance'])
            ->where('medecin_id', $medecin->id)
            ->latest()->paginate(10);
        return view('medecin.consultations.index', compact('consultations'));
    }

    public function create(Request $request)
    {
        $medecin = auth()->user()->medecin;
        $rdvs = Rendezvous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->where('statut', 'confirme')
            ->whereDoesntHave('consultation')
            ->orderBy('date_rdv')
            ->get();
        return view('medecin.consultations.create', compact('rdvs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rendez_vous_id'   => 'required|exists:rendezvouses,id',
            'compte_rendu'     => 'required|string|min:10',
            'contenu_ordonnance' => 'nullable|string',
        ]);
        $rdv = Rendezvous::findOrFail($request->rendez_vous_id);
        $medecin = auth()->user()->medecin;
        $consultation = Consultation::create([
            'patient_id'       => $rdv->patient_id,
            'medecin_id'       => $medecin->id,
            'rendez_vous_id'   => $rdv->id,
            'date_consultation'=> now()->format('Y-m-d'),
            'compte_rendu'     => $request->compte_rendu,
        ]);
        if ($request->filled('contenu_ordonnance')) {
            Ordonnance::create([
                'consultation_id' => $consultation->id,
                'contenu'         => $request->contenu_ordonnance,
                'date_creation'   => now()->format('Y-m-d'),
            ]);
        }
        $rdv->update(['statut' => 'confirme']);
        return redirect()->route('medecin.consultations.index')
            ->with('success', 'Consultation enregistree avec succes.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['patient.user', 'medecin.user', 'ordonnance', 'rendezvous']);
        return view('medecin.consultations.show', compact('consultation'));
    }
}

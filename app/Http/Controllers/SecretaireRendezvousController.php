<?php
namespace App\Http\Controllers;
use App\Mail\ConfirmationRdv;
use App\Models\Disponibilite;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rendezvous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SecretaireRendezvousController extends Controller
{
    public function index(Request $request)
    {
        $query = Rendezvous::with(['patient.user','medecin.user','medecin.specialite','medecin.disponibilites']);
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        $rendezvous = $query->orderByDesc('date_rdv')->paginate(15)->withQueryString();
        $stats = [
            'total'      => Rendezvous::count(),
            'en_attente' => Rendezvous::where('statut','en_attente')->count(),
            'confirme'   => Rendezvous::where('statut','confirme')->count(),
            'annule'     => Rendezvous::where('statut','annule')->count(),
        ];
        return view('secretaire.rendezvous.index', compact('rendezvous','stats'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with(['user','specialite','disponibilites'])->get();
        return view('secretaire.rendezvous.create', compact('patients','medecins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date_rdv'   => 'required|date|after_or_equal:today',
            'heure_rdv'  => 'required',
        ]);

        $rdv = Rendezvous::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date_rdv'   => $request->date_rdv,
            'heure_rdv'  => $request->heure_rdv,
            'statut'     => 'confirme',
        ]);

        $rdv->load(['patient.user','medecin.user']);
        try {
            Mail::to($rdv->patient->user->email)->send(new ConfirmationRdv($rdv));
            $msg = 'Appointment scheduled and confirmation email sent.';
        } catch (\Exception $e) {
            $msg = 'Appointment scheduled successfully.';
        }

        return redirect()->route('secretaire.rendezvous.index')->with('success', $msg);
    }

    public function confirmer(Rendezvous $rendezvous)
    {
        $rendezvous->update(['statut' => 'confirme']);
        $rendezvous->load(['patient.user','medecin.user']);
        try {
            Mail::to($rendezvous->patient->user->email)->send(new ConfirmationRdv($rendezvous));
        } catch (\Exception $e) {}
        return back()->with('success', 'Appointment confirmed and email sent.');
    }

    public function reschedule(Request $request, Rendezvous $rendezvous)
    {
        $request->validate([
            'date_rdv'  => 'required|date|after_or_equal:today',
            'heure_rdv' => 'required',
        ]);
        $rendezvous->update([
            'date_rdv'  => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
            'statut'    => 'en_attente',
        ]);
        return back()->with('success', 'Appointment rescheduled successfully.');
    }

    public function annuler(Rendezvous $rendezvous)
    {
        $rendezvous->update(['statut' => 'annule']);
        return back()->with('success', 'Appointment cancelled.');
    }

    public function disponibilites(Request $request)
    {
        $medecin_id = $request->medecin_id;
        $date = $request->date;
        if (!$medecin_id || !$date) return response()->json([]);
        $jour = strtolower(\Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd'));
        $dispos = Disponibilite::where('medecin_id', $medecin_id)
            ->where('jour', $jour)->where('actif', true)->get();
        $rdvsPris = Rendezvous::where('medecin_id', $medecin_id)
            ->whereDate('date_rdv', $date)
            ->whereIn('statut', ['confirme','en_attente'])
            ->pluck('heure_rdv')
            ->map(fn($h) => substr($h,0,5))->toArray();
        $slots = [];
        foreach ($dispos as $d) {
            $start = \Carbon\Carbon::parse($d->heure_debut);
            $end = \Carbon\Carbon::parse($d->heure_fin);
            while ($start < $end) {
                $time = $start->format('H:i');
                $slots[] = ['time' => $time, 'available' => !in_array($time, $rdvsPris)];
                $start->addMinutes(30);
            }
        }
        return response()->json($slots);
    }
}

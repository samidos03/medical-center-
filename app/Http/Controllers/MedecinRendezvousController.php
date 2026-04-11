<?php
namespace App\Http\Controllers;
use App\Mail\ConfirmationRdv;
use App\Models\Rendezvous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MedecinRendezvousController extends Controller
{
    public function index(Request $request)
    {
        $medecin = auth()->user()->medecin;
        $query = Rendezvous::with(['patient.user'])
            ->where('medecin_id', $medecin->id);
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('date')) {
            $query->whereDate('date_rdv', $request->date);
        }
        $rendezvous = $query->orderByDesc('date_rdv')->paginate(15)->withQueryString();
        $stats = [
            'total'      => Rendezvous::where('medecin_id', $medecin->id)->count(),
            'en_attente' => Rendezvous::where('medecin_id', $medecin->id)->where('statut','en_attente')->count(),
            'confirme'   => Rendezvous::where('medecin_id', $medecin->id)->where('statut','confirme')->count(),
            'annule'     => Rendezvous::where('medecin_id', $medecin->id)->where('statut','annule')->count(),
        ];
        return view('medecin.rendezvous.index', compact('rendezvous','stats'));
    }

    public function confirmer(Rendezvous $rendezvous)
    {
        $rendezvous->update(['statut' => 'confirme']);
        $rendezvous->load(['patient.user','medecin.user']);
        try {
            Mail::to($rendezvous->patient->user->email)
                ->send(new ConfirmationRdv($rendezvous));
        } catch (\Exception $e) {}
        return back()->with('success', 'Appointment confirmed and email sent.');
    }

    public function annuler(Rendezvous $rendezvous)
    {
        $rendezvous->update(['statut' => 'annule']);
        return back()->with('success', 'Appointment cancelled.');
    }
}

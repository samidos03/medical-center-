<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationRdv;
use App\Models\Rendezvous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RendezvousController extends Controller
{
    public function index(Request $request)
    {
        $query = Rendezvous::with(['patient.user', 'medecin.user']);
        if ($request->filled('statut')) $query->where('statut', $request->statut);
        if ($request->filled('date')) $query->whereDate('date_rdv', $request->date);
        $rendezvous = $query->orderBy('date_rdv','desc')->paginate(15)->withQueryString();
        $stats = [
            'total'      => Rendezvous::count(),
            'confirme'   => Rendezvous::where('statut','confirme')->count(),
            'en_attente' => Rendezvous::where('statut','en_attente')->count(),
            'annule'     => Rendezvous::where('statut','annule')->count(),
        ];
        return view('admin.rendezvous.index', compact('rendezvous','stats'));
    }

    public function updateStatut(Request $request, Rendezvous $rendezvous)
    {
        $request->validate(['statut' => 'required|in:confirme,annule,en_attente']);
        $ancienStatut = $rendezvous->statut;
        $rendezvous->update(['statut' => $request->statut]);

        if ($request->statut === 'confirme' && $ancienStatut !== 'confirme') {
            try {
                $rendezvous->load(['patient.user', 'medecin.user']);
                Mail::to($rendezvous->patient->user->email)
                    ->send(new ConfirmationRdv($rendezvous));
            } catch (\Exception $e) {
                // Mail failed silently
            }
        }

        return back()->with('success', 'Statut mis a jour' . ($request->statut === 'confirme' ? ' - Email de confirmation envoye' : '') . '.');
    }
}

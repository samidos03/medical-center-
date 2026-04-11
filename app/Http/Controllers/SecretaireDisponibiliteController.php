<?php
namespace App\Http\Controllers;
use App\Models\Disponibilite;
use App\Models\Medecin;
use App\Models\Rendezvous;

class SecretaireDisponibiliteController extends Controller
{
    public function index()
    {
        $medecins = Medecin::with(['user','specialite','disponibilites'])
            ->whereHas('user', fn($q) => $q->where('actif', true))
            ->get()
            ->map(function($m) {
                $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                $m->planning = collect($jours)->map(function($jour) use ($m) {
                    $dispos = $m->disponibilites->where('jour', $jour)->values();
                    $rdvCount = Rendezvous::where('medecin_id', $m->id)
                        ->whereIn('statut', ['confirme','en_attente'])
                        ->whereRaw("DAYOFWEEK(date_rdv) = ?", [
                            array_search($jour, ['dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi']) + 1
                        ])->count();
                    return [
                        'jour'      => $jour,
                        'dispos'    => $dispos,
                        'rdv_count' => $rdvCount,
                        'actif'     => $dispos->isNotEmpty(),
                    ];
                });
                $m->rdv_total = Rendezvous::where('medecin_id', $m->id)
                    ->whereIn('statut', ['confirme','en_attente'])
                    ->whereDate('date_rdv', '>=', today())->count();
                return $m;
            });

        return view('secretaire.medecins.disponibilites', compact('medecins'));
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Disponibilite;
use Illuminate\Http\Request;

class MedecinDisponibiliteController extends Controller
{
    public function index()
    {
        $medecin = auth()->user()->medecin;
        $disponibilites = Disponibilite::where('medecin_id', $medecin->id)
            ->orderByRaw("FIELD(jour,'lundi','mardi','mercredi','jeudi','vendredi','samedi')")
            ->get();
        return view('medecin.disponibilites', compact('disponibilites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jour'        => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
            'heure_debut' => 'required',
            'heure_fin'   => 'required|after:heure_debut',
        ]);
        $medecin = auth()->user()->medecin;
        Disponibilite::create([
            'medecin_id'  => $medecin->id,
            'jour'        => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin'   => $request->heure_fin,
            'actif'       => true,
        ]);
        return back()->with('success', 'Disponibilite ajoutee.');
    }

    public function destroy(Disponibilite $disponibilite)
    {
        $disponibilite->delete();
        return back()->with('success', 'Disponibilite supprimee.');
    }
}

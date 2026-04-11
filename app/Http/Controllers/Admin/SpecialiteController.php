<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Specialite;
use Illuminate\Http\Request;
class SpecialiteController extends Controller
{
    public function index()
    {
        $specialites = Specialite::withCount('medecins')->orderBy('nom')->paginate(15);
        return view('admin.specialites.index', compact('specialites'));
    }
    public function create()
    {
        return view('admin.specialites.create');
    }
    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100|unique:specialites,nom']);
        Specialite::create(['nom' => $request->nom]);
        return redirect()->route('admin.specialites.index')->with('success', 'Specialite creee.');
    }
    public function edit(Specialite $specialite)
    {
        return view('admin.specialites.edit', compact('specialite'));
    }
    public function update(Request $request, Specialite $specialite)
    {
        $request->validate(['nom' => 'required|string|max:100|unique:specialites,nom,'.$specialite->id]);
        $specialite->update(['nom' => $request->nom]);
        return redirect()->route('admin.specialites.index')->with('success', 'Specialite mise a jour.');
    }
    public function destroy(Specialite $specialite)
    {
        if ($specialite->medecins()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des medecins utilisent cette specialite.');
        }
        $specialite->delete();
        return redirect()->route('admin.specialites.index')->with('success', 'Specialite supprimee.');
    }
}

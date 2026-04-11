<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecretairePatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->latest()->paginate(15);
        return view('secretaire.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('secretaire.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'phone'      => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|in:M,F',
            'blood_type' => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
            'phone'    => $request->phone,
            'actif'    => true,
        ]);

        Patient::create([
            'user_id'            => $user->id,
            'birth_date'         => $request->birth_date,
            'gender'             => $request->gender,
            'blood_type'         => $request->blood_type,
            'allergies'          => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'emergency_contact'  => $request->emergency_contact,
            'emergency_phone'    => $request->emergency_phone,
        ]);

        return redirect()->route('secretaire.patients.index')
            ->with('success', 'Patient added successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['user','rendezvous.medecin.user','rendezvous.consultation.ordonnance']);
        return view('secretaire.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('secretaire.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$patient->user_id,
        ]);

        $patient->user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $patient->update([
            'birth_date'         => $request->birth_date,
            'gender'             => $request->gender,
            'blood_type'         => $request->blood_type,
            'allergies'          => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'emergency_contact'  => $request->emergency_contact,
            'emergency_phone'    => $request->emergency_phone,
        ]);

        return redirect()->route('secretaire.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        return back()->with('success', 'Patient deleted successfully.');
    }
}


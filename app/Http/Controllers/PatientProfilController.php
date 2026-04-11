<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PatientProfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $patient = $user->patient;
        return view('patient.profil', compact('user','patient'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        auth()->user()->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);
        if (auth()->user()->patient) {
            auth()->user()->patient->update([
                'birth_date'         => $request->birth_date,
                'gender'             => $request->gender,
                'blood_type'         => $request->blood_type,
                'allergies'          => $request->allergies,
                'medical_conditions' => $request->medical_conditions,
                'emergency_contact'  => $request->emergency_contact,
                'emergency_phone'    => $request->emergency_phone,
            ]);
        }
        return back()->with('success', 'Profile updated successfully.');
    }
}

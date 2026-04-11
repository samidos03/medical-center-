<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Patient;
class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with("user")->latest()->paginate(15);
        return view("admin.patients.index", compact("patients"));
    }
    public function show(Patient $patient)
    {
        $patient->load(["user", "rendezvous.medecin.user"]);
        return view("admin.patients.show", compact("patient"));
    }
}
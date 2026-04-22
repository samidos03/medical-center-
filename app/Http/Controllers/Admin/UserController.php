<?php
// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with(['medecin.specialite', 'patient']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'      => User::count(),
            'admins'     => User::where('role', 'admin')->count(),
            'medecins'   => User::where('role', 'medecin')->count(),
            'patients'   => User::where('role', 'patient')->count(),
            'secretaires'=> User::where('role', 'secretaire')->count(),
            'inactifs'   => User::where('actif', false)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        $specialites = Specialite::orderBy('nom')->get();
        return view('admin.users.create', compact('specialites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|in:admin,medecin,secretaire,patient',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:500',
            // Médecin
            'specialite_id' => 'required_if:role,medecin|nullable|exists:specialites,id',
            'telephone'     => 'nullable|string|max:20',
            // Patient
            'birth_date'        => 'required_if:role,patient|nullable|date',
            'gender'            => 'nullable|in:M,F',
            'blood_type'        => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone'   => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'phone'    => $validated['phone'] ?? null,
            'address'  => $validated['address'] ?? null,
            'actif'    => true,
        ]);

        if ($user->role === 'medecin') {
            Medecin::create([
                'user_id'      => $user->id,
                'specialite_id'=> $validated['specialite_id'],
                'telephone'    => $validated['telephone'] ?? null,
            ]);
        }

        if ($user->role === 'patient') {
            Patient::create([
                'user_id'           => $user->id,
                'birth_date'        => $validated['birth_date'] ?? null,
                'gender'            => $validated['gender'] ?? null,
                'blood_type'        => $validated['blood_type'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'emergency_phone'   => $validated['emergency_phone'] ?? null,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} created successfully.");
    }

    public function edit(string $id)
    {
        $user        = User::with(['medecin', 'patient'])->findOrFail($id);
        $specialites = Specialite::orderBy('nom')->get();
        return view('admin.users.edit', compact('user', 'specialites'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'=> 'nullable|string|min:8|confirmed',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'actif'   => 'boolean',
            // Médecin
            'specialite_id' => 'required_if:role,medecin|nullable|exists:specialites,id',
            'telephone'     => 'nullable|string|max:20',
            // Patient
            'birth_date'        => 'nullable|date',
            'gender'            => 'nullable|in:M,F',
            'blood_type'        => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone'   => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'actif'   => $request->boolean('actif'),
            ...($validated['password'] ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        if ($user->role === 'medecin') {
            Medecin::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialite_id' => $validated['specialite_id'],
                    'telephone'     => $validated['telephone'] ?? null,
                ]
            );
        }

        if ($user->role === 'patient') {
            Patient::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'birth_date'        => $validated['birth_date'] ?? null,
                    'gender'            => $validated['gender'] ?? null,
                    'blood_type'        => $validated['blood_type'] ?? null,
                    'emergency_contact' => $validated['emergency_contact'] ?? null,
                    'emergency_phone'   => $validated['emergency_phone'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name}  updated successfully.");
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User deleted successfully.");
    }

    public function toggle(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->update(['actif' => !$user->actif]);
        $msg = $user->actif ? 'activated' : 'deactivated';

        return back()->with('success', "account of {$user->name} {$msg}.");
    }
}
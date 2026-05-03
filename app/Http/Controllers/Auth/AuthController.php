<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirection selon le rôle
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'medecin' => redirect()->route('medecin.dashboard'),
                'secretaire' => redirect()->route('secretaire.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                default => redirect()->route('login'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',

        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'phone' => $request->phone,
        ]);

        // Créer la fiche patient
        Patient::create([
            'user_id' => $user->id,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
        ]);

        // Connecter automatiquement
        Auth::login($user);

return redirect()->route('patient.dashboard')->with('success', 'Welcome to your patient space!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
return redirect('/login')->with('success', 'You have been logged out.');
    }
}
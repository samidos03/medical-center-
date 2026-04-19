<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;

Route::get('/test', function () {
    return 'Laravel fonctionne!';
});

Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'medecin'    => redirect()->route('medecin.dashboard'),
            'secretaire' => redirect()->route('secretaire.dashboard'),
            'patient'    => redirect()->route('patient.dashboard'),
        };
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
    Route::resource('specialites', \App\Http\Controllers\Admin\SpecialiteController::class);
    Route::get('patients', [\App\Http\Controllers\Admin\PatientController::class, 'index'])->name('patients.index');
    Route::get('patients/{patient}', [\App\Http\Controllers\Admin\PatientController::class, 'show'])->name('patients.show');
    Route::get('rendezvous', [\App\Http\Controllers\Admin\RendezvousController::class, 'index'])->name('rendezvous.index');
    Route::patch('rendezvous/{rendezvous}/statut', [\App\Http\Controllers\Admin\RendezvousController::class, 'updateStatut'])->name('rendezvous.statut');
});

Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/dashboard', [MedecinController::class, 'dashboard'])->name('dashboard');
    Route::resource('consultations', \App\Http\Controllers\MedecinConsultationController::class);
    Route::get('ordonnances/{ordonnance}/pdf', [\App\Http\Controllers\OrdonnanceController::class, 'pdf'])->name('ordonnances.pdf');
    Route::get('patients', [\App\Http\Controllers\MedecinPatientController::class, 'index'])->name('patients.index');
    Route::get('patients/{patient}', [\App\Http\Controllers\MedecinPatientController::class, 'show'])->name('patients.show');
    Route::get('agenda', [\App\Http\Controllers\MedecinAgendaController::class, 'index'])->name('agenda');
    Route::resource('disponibilites', \App\Http\Controllers\MedecinDisponibiliteController::class)->only(['index','store','destroy']);
    Route::get('rendezvous', [\App\Http\Controllers\MedecinRendezvousController::class, 'index'])->name('rendezvous.index');
    Route::patch('rendezvous/{rendezvous}/confirmer', [\App\Http\Controllers\MedecinRendezvousController::class, 'confirmer'])->name('rendezvous.confirmer');
    Route::patch('rendezvous/{rendezvous}/annuler', [\App\Http\Controllers\MedecinRendezvousController::class, 'annuler'])->name('rendezvous.annuler');
});


Route::middleware(['auth', 'role:secretaire'])->prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SecretaireController::class, 'dashboard'])->name('dashboard');
    Route::get('patients', [\App\Http\Controllers\SecretairePatientController::class, 'index'])->name('patients.index');
    Route::get('patients/create', [\App\Http\Controllers\SecretairePatientController::class, 'create'])->name('patients.create');
    Route::post('patients', [\App\Http\Controllers\SecretairePatientController::class, 'store'])->name('patients.store');
    Route::get('patients/{patient}', [\App\Http\Controllers\SecretairePatientController::class, 'show'])->name('patients.show');
    Route::get('patients/{patient}/edit', [\App\Http\Controllers\SecretairePatientController::class, 'edit'])->name('patients.edit');
    Route::put('patients/{patient}', [\App\Http\Controllers\SecretairePatientController::class, 'update'])->name('patients.update');
    Route::delete('patients/{patient}', [\App\Http\Controllers\SecretairePatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('rendezvous', [\App\Http\Controllers\SecretaireRendezvousController::class, 'index'])->name('rendezvous.index');
    Route::get('rendezvous/create', [\App\Http\Controllers\SecretaireRendezvousController::class, 'create'])->name('rendezvous.create');
    Route::post('rendezvous', [\App\Http\Controllers\SecretaireRendezvousController::class, 'store'])->name('rendezvous.store');
    Route::patch('rendezvous/{rendezvous}/annuler', [\App\Http\Controllers\SecretaireRendezvousController::class, 'annuler'])->name('rendezvous.annuler');
    Route::get('medecins/disponibilites', [\App\Http\Controllers\SecretaireDisponibiliteController::class, 'index'])->name('medecins.disponibilites');
    Route::patch('rendezvous/{rendezvous}/reschedule', [\App\Http\Controllers\SecretaireRendezvousController::class, 'reschedule'])->name('rendezvous.reschedule');
    Route::patch('rendezvous/{rendezvous}/confirmer', [\App\Http\Controllers\SecretaireRendezvousController::class, 'confirmer'])->name('rendezvous.confirmer');
    Route::get('disponibilites-medecin', [\App\Http\Controllers\SecretaireRendezvousController::class, 'disponibilites'])->name('disponibilites.medecin');
});

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('rendezvous', [\App\Http\Controllers\PatientRendezvousController::class, 'index'])->name('rendezvous.index');
    Route::get('rendezvous/create', [\App\Http\Controllers\PatientRendezvousController::class, 'create'])->name('rendezvous.create');
    Route::post('rendezvous', [\App\Http\Controllers\PatientRendezvousController::class, 'store'])->name('rendezvous.store');
    Route::get('rendezvous/{rendezvous}/edit', [\App\Http\Controllers\PatientRendezvousController::class, 'edit'])->name('rendezvous.edit');
    Route::put('rendezvous/{rendezvous}', [\App\Http\Controllers\PatientRendezvousController::class, 'update'])->name('rendezvous.update');
    Route::patch('rendezvous/{rendezvous}/annuler', [\App\Http\Controllers\PatientRendezvousController::class, 'annuler'])->name('rendezvous.annuler');
    Route::get('historique', [\App\Http\Controllers\PatientRendezvousController::class, 'historique'])->name('historique');
    Route::get('ordonnances/{ordonnance}/pdf', [\App\Http\Controllers\OrdonnanceController::class, 'pdf'])->name('ordonnances.pdf');
    Route::get('profil', [\App\Http\Controllers\PatientProfilController::class, 'edit'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\PatientProfilController::class, 'update'])->name('profil.update');
});

Route::resource('patients', PatientController::class)->middleware('auth');
Route::resource('rendezvous', \App\Http\Controllers\RendezvousController::class)->middleware('auth');
Route::resource('consultations', \App\Http\Controllers\ConsultationController::class)->middleware('auth');

require __DIR__.'/auth.php';











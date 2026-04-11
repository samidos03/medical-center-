@extends('admin.layouts.app')
@section('title', $patient->user->name)
@section('subtitle', 'Dossier patient')

@section('content')
<a href="{{ route('admin.patients.index') }}" class="btn-secondary" style="margin-bottom:20px;display:inline-flex">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Retour
</a>
<div class="grid2" style="margin-bottom:20px">
    <div class="form-card">
        <div class="form-section">Informations personnelles</div>
        <div style="display:flex;flex-direction:column;gap:12px;font-size:13px">
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Nom</span><span style="font-weight:600">{{ $patient->user->name }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Email</span><span>{{ $patient->user->email }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Naissance</span><span>{{ $patient->birth_date?->format('d/m/Y')??'-' }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Gender</span><span>{{ $patient->gender==='M'?'Male':($patient->gender==='F'?'Female':'-') }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Sang</span><span class="pill pill-red">{{ $patient->blood_type??'-' }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Tel.</span><span>{{ $patient->user->phone??'-' }}</span></div>
        </div>
    </div>
    <div class="form-card">
        <div class="form-section">Urgences</div>
        <div style="display:flex;flex-direction:column;gap:12px;font-size:13px">
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Contact</span><span style="font-weight:600">{{ $patient->emergency_contact??'-' }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Phone</span><span>{{ $patient->emergency_phone??'-' }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Allergies</span><span>{{ $patient->Allergies??'None' }}</span></div>
            <div style="display:flex;justify-content:space-between"><span style="color:#64748b">Conditions</span><span>{{ $patient->medical_Conditions??'None' }}</span></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header"><h2>Historique des Appointments</h2></div>
    <table>
        <thead><tr><th>Date</th><th>Time</th><th>Doctor</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($patient->rendezvous as $rdv)
            <tr>
                <td>{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                <td>{{ substr($rdv->heure_rdv,0,5) }}</td>
                <td>{{ $rdv->medecin->user->name??'-' }}</td>
                <td>
                    @if($rdv->statut==='Confirmed') <span class="pill pill-green">Confirmed</span>
                    @elseif($rdv->statut==='en_attente') <span class="pill pill-amber">Pending</span>
                    @else <span class="pill pill-red">Cancelled</span> @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="empty-state"><p>Aucun Appointments.</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection




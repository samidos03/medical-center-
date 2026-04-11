@extends('admin.layouts.app')
@section('title', 'Appointments')
@section('subtitle', 'Gestion des Appointments')

@section('content')
<div class="stats-mini" style="grid-template-columns:repeat(4,1fr)">
    <div class="stat-mini"><div class="stat-mini-num" style="color:#0369a1">{{ $stats['total'] }}</div><div class="stat-mini-label">Total</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#16a34a">{{ $stats['confirme'] }}</div><div class="stat-mini-label">Confirmes</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#d97706">{{ $stats['en_attente'] }}</div><div class="stat-mini-label">Pending</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#dc2626">{{ $stats['annule'] }}</div><div class="stat-mini-label">Annules</div></div>
</div>
<div class="card">
    <div class="card-header"><h2>Liste des Appointments</h2></div>
    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9">
        <form method="GET" class="search-bar">
            <select name="statut" class="search-select">
                <option value="">Tous les statuts</option>
                <option value="confirme" @selected(request('statut')==='confirme')>Confirmes</option>
                <option value="en_attente" @selected(request('statut')==='en_attente')>Pending</option>
                <option value="annule" @selected(request('statut')==='annule')>Annules</option>
            </select>
            <input type="date" name="date" value="{{ request('date') }}" class="search-input" style="max-width:180px">
            <button type="submit" class="btn-primary">Filter</button>
            @if(request()->hasAny(['statut','date']))
                <a href="{{ route('admin.rendezvous.index') }}" class="btn-secondary">Reset</a>
            @endif
        </form>
    </div>
    <table>
        <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th style="text-align:right">Action</th></tr></thead>
        <tbody>
            @forelse($rendezvous as $rdv)
            <tr>
                <td style="font-weight:600;color:#0f172a">{{ $rdv->patient->user->name??'-' }}</td>
                <td style="color:#64748b">{{ $rdv->medecin->user->name??'-' }}</td>
                <td style="color:#64748b">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                <td style="color:#64748b">{{ substr($rdv->heure_rdv,0,5) }}</td>
                <td>
                    @if($rdv->statut==='confirme') <span class="pill pill-green">Confirmed</span>
                    @elseif($rdv->statut==='en_attente') <span class="pill pill-amber">Pending</span>
                    @else <span class="pill pill-red">Cancelled</span> @endif
                </td>
                <td style="text-align:right">
                    <form action="{{ route('admin.rendezvous.statut', $rdv) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="statut" onchange="this.form.submit()" style="padding:6px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;outline:none;background:#f8fafc;cursor:pointer">
                            <option value="en_attente" @selected($rdv->statut==='en_attente')>Pending</option>
                            <option value="confirme" @selected($rdv->statut==='confirme')>Confirmer</option>
                            <option value="annule" @selected($rdv->statut==='annule')>Cancel</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-state"><p>Aucun Appointments trouve.</p></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($rendezvous->hasPages())
    <div class="pagination-wrap">{{ $rendezvous->links() }}</div>
    @endif
</div>
@endsection




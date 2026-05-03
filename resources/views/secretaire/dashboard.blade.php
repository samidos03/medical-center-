@extends('secretaire.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Vue générale — Bahjawa Medical')

@section('topbar-actions')
<a href="{{ route('secretaire.rendezvous.create') }}" class="btn-primary">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    <span>New Appointment</span>
</a>
@endsection

@section('content')

<!-- STATS -->
<div class="stats-grid">
    <div class="stat">
        <div style="width:40px;height:40px;background:#fdf2f8;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
            <svg width="20" height="20" fill="none" stroke="#993556" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="stat-num" style="color:#993556">{{ \App\Models\Rendezvous::whereDate('date_rdv', today())->count() }}</div>
        <div class="stat-label">RDV aujourd'hui</div>
    </div>
    <div class="stat">
        <div style="width:40px;height:40px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
            <svg width="20" height="20" fill="none" stroke="#0369a1" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="stat-num" style="color:#0369a1">{{ \App\Models\Patient::count() }}</div>
        <div class="stat-label">Total patients</div>
    </div>
    <div class="stat">
        <div style="width:40px;height:40px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
            <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-num" style="color:#16a34a">{{ \App\Models\Rendezvous::where('statut','confirme')->count() }}</div>
        <div class="stat-label">Confirmés</div>
    </div>
    <div class="stat">
        <div style="width:40px;height:40px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
            <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-num" style="color:#d97706">{{ \App\Models\Rendezvous::where('statut','en_attente')->count() }}</div>
        <div class="stat-label">En attente</div>
    </div>
</div>

<!-- ACTIONS RAPIDES -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
    <a href="{{ route('secretaire.rendezvous.create') }}"
        style="display:flex;align-items:center;gap:14px;padding:18px;background:linear-gradient(135deg,#993556,#4a1528);border-radius:16px;text-decoration:none;transition:opacity .2s"
        onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
        <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <div style="color:white;font-weight:700;font-size:14px">Nouveau RDV</div>
            <div style="color:rgba(255,255,255,.7);font-size:12px;margin-top:2px">Planifier une consultation</div>
        </div>
    </a>
    <a href="{{ route('secretaire.patients.create') }}"
        style="display:flex;align-items:center;gap:14px;padding:18px;background:linear-gradient(135deg,#0369a1,#1e3a5f);border-radius:16px;text-decoration:none;transition:opacity .2s"
        onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
        <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <div>
            <div style="color:white;font-weight:700;font-size:14px">Nouveau patient</div>
            <div style="color:rgba(255,255,255,.7);font-size:12px;margin-top:2px">Enregistrer un dossier</div>
        </div>
    </a>
</div>

<!-- RDV DU JOUR -->
<div class="card">
    <div class="card-header">
        <h2>Rendez-vous du jour — {{ now()->format('d/m/Y') }}</h2>
        <a href="{{ route('secretaire.rendezvous.index') }}" class="btn-secondary">Voir tout →</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Heure</th>
                <th>Statut</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Rendezvous::with(['patient.user','medecin.user'])->whereDate('date_rdv', today())->orderBy('heure_rdv')->get() as $rdv)
            <tr>
                <td data-label="Patient">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div class="avatar" style="background:#fdf2f8;color:#993556">{{ strtoupper(substr($rdv->patient->user->name??'P',0,2)) }}</div>
                        <span style="font-weight:600">{{ $rdv->patient->user->name??'—' }}</span>
                    </div>
                </td>
                <td data-label="Médecin" style="color:#64748b">{{ $rdv->medecin->user->name??'—' }}</td>
                <td data-label="Heure" style="font-weight:700;color:#993556">{{ substr($rdv->heure_rdv,0,5) }}</td>
                <td data-label="Statut">
                    @if($rdv->statut==='confirme')<span class="pill pg">Confirmé</span>
                    @elseif($rdv->statut==='en_attente')<span class="pill pa">En attente</span>
                    @elseif($rdv->statut==='annule')<span class="pill pr">Annulé</span>
                    @else<span class="pill" style="background:#f8fafc;color:#64748b">Terminé</span>@endif
                </td>
                <td data-label="Actions">
                    <div style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:wrap">
                        <a href="{{ route('secretaire.rendezvous.edit', $rdv) }}" class="btn-secondary" style="padding:6px 10px">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="empty-state">Aucun rendez-vous aujourd'hui.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
@extends('admin.layouts.app')
@section('title', 'Appointments')
@section('subtitle', 'Manage all appointments')

@section('content')

{{-- STATS --}}
<div class="stats-mini" style="grid-template-columns:repeat(4,1fr)">
    <div class="stat-mini">
        <div class="stat-mini-num" style="color:#0369a1">{{ $stats['total'] }}</div>
        <div class="stat-mini-label">Total</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num" style="color:#16a34a">{{ $stats['confirme'] }}</div>
        <div class="stat-mini-label">Confirmed</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num" style="color:#d97706">{{ $stats['en_attente'] }}</div>
        <div class="stat-mini-label">Pending</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num" style="color:#dc2626">{{ $stats['annule'] }}</div>
        <div class="stat-mini-label">Cancelled</div>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-header">
        <h2>All Appointments</h2>
    </div>

    {{-- FILTERS --}}
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9">
        <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
            <select name="statut"
                    style="padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;cursor:pointer">
                <option value="">All statuses</option>
                <option value="confirme" @selected(request('statut')==='confirme')>Confirmed</option>
                <option value="en_attente" @selected(request('statut')==='en_attente')>Pending</option>
                <option value="annule" @selected(request('statut')==='annule')>Cancelled</option>
            </select>
            <input type="date" name="date" value="{{ request('date') }}"
                   style="padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;max-width:180px">
            <button type="submit" class="btn-primary" style="padding:9px 16px">Filter</button>
            @if(request()->hasAny(['statut','date']))
                <a href="{{ route('admin.rendezvous.index') }}" class="btn-secondary" style="padding:9px 16px">Reset</a>
            @endif
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th style="text-align:right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rendezvous as $rdv)
            <tr>
                <td data-label="Patient" style="font-weight:600;color:#0f172a">
                    {{ $rdv->patient->user->name ?? '—' }}
                </td>
                <td data-label="Doctor" style="color:#64748b">
                    {{ $rdv->medecin->user->name ?? '—' }}
                </td>
                <td data-label="Date" style="color:#64748b">
                    {{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}
                </td>
                <td data-label="Time" style="font-weight:600;color:#0369a1">
                    {{ substr($rdv->heure_rdv,0,5) }}
                </td>
                <td data-label="Status">
                    @if($rdv->statut==='confirme')
                        <span class="pill pill-green">Confirmed</span>
                    @elseif($rdv->statut==='en_attente')
                        <span class="pill pill-amber">Pending</span>
                    @else
                        <span class="pill pill-red">Cancelled</span>
                    @endif
                </td>
                <td data-label="Action" style="text-align:right">
                    <form action="{{ route('admin.rendezvous.statut', $rdv) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="statut" onchange="this.form.submit()"
                                style="padding:6px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;outline:none;background:#f8fafc;cursor:pointer">
                            <option value="en_attente" @selected($rdv->statut==='en_attente')>Pending</option>
                            <option value="confirme" @selected($rdv->statut==='confirme')>Confirm</option>
                            <option value="annule" @selected($rdv->statut==='annule')>Cancel</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>No appointments found.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($rendezvous->hasPages())
    <div class="pagination-wrap">{{ $rendezvous->links() }}</div>
    @endif
</div>
@endsection
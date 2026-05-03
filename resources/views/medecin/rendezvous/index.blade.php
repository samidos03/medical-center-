@extends('medecin.layouts.app')

@section('title', 'My Appointments')
@section('subtitle', 'Manage and confirm your appointments')

@section('topbar-actions')
  <a href="{{ route('medecin.consultations.create') }}" class="btn-primary">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    <span>New Consultation</span>
  </a>
@endsection

@section('content')

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px">
  <div style="background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:24px;font-weight:700;color:#0369a1">{{ $stats['total'] }}</div>
    <div style="font-size:12px;color:#64748b;margin-top:3px">Total</div>
  </div>
  <div style="background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:24px;font-weight:700;color:#d97706">{{ $stats['en_attente'] }}</div>
    <div style="font-size:12px;color:#64748b;margin-top:3px">Pending</div>
  </div>
  <div style="background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:24px;font-weight:700;color:#16a34a">{{ $stats['confirme'] }}</div>
    <div style="font-size:12px;color:#64748b;margin-top:3px">Confirmed</div>
  </div>
  <div style="background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06)">
    <div style="font-size:24px;font-weight:700;color:#dc2626">{{ $stats['annule'] }}</div>
    <div style="font-size:12px;color:#64748b;margin-top:3px">Cancelled</div>
  </div>
</div>

{{-- TABLE --}}
<div class="card">
  <div class="card-header">
    <h2>All Appointments</h2>
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
      <select name="statut" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;cursor:pointer" onchange="this.form.submit()">
        <option value="">All statuses</option>
        <option value="en_attente" @selected(request('statut')==='en_attente')>Pending</option>
        <option value="confirme" @selected(request('statut')==='confirme')>Confirmed</option>
        <option value="annule" @selected(request('statut')==='annule')>Cancelled</option>
      </select>
      <input type="date" name="date" value="{{ request('date') }}" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc" onchange="this.form.submit()">
      @if(request()->hasAny(['statut','date']))
        <a href="{{ route('medecin.rendezvous.index') }}" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#64748b;text-decoration:none">Reset</a>
      @endif
    </form>
  </div>
  <table>
    <thead>
      <tr>
        <th>Patient</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rendezvous as $rdv)
      <tr>
        <td data-label="Patient">
          <div style="display:flex;align-items:center;gap:8px">
            <div class="avatar" style="background:#f0fdf4;color:#059669">
              {{ strtoupper(substr($rdv->patient->user->name??'?',0,2)) }}
            </div>
            <div>
              <div style="font-weight:600;color:#0f172a">{{ $rdv->patient->user->name??'-' }}</div>
              <div style="font-size:11px;color:#94a3b8">{{ $rdv->patient->user->email??'' }}</div>
            </div>
          </div>
        </td>
        <td data-label="Date">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
        <td data-label="Time" style="font-weight:600;color:#059669">{{ substr($rdv->heure_rdv,0,5) }}</td>
        <td data-label="Status">
          @if($rdv->statut==='confirme')<span class="pill pg">Confirmed</span>
          @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
          @else<span class="pill pr">Cancelled</span>@endif
        </td>
        <td data-label="Actions">
          <div style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:wrap">
            @if($rdv->statut==='en_attente')
            <form action="{{ route('medecin.rendezvous.confirmer', $rdv) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" style="display:inline-flex;align-items:center;gap:4px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:600;cursor:pointer">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Confirm
              </button>
            </form>
            @endif
            @if($rdv->statut !== 'annule')
            <form action="{{ route('medecin.rendezvous.annuler', $rdv) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
              @csrf @method('PATCH')
              <button type="submit" style="display:inline-flex;align-items:center;gap:4px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:600;cursor:pointer">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Cancel
              </button>
            </form>
            @endif
            @if($rdv->statut==='confirme')
            <a href="{{ route('medecin.consultations.create') }}" class="btn-primary" style="padding:6px 10px;font-size:11px">
              + Consultation
            </a>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="5"><div class="empty-state">No appointments found.</div></td></tr>
      @endforelse
    </tbody>
  </table>
  @if($rendezvous->hasPages())
  <div class="pagination-wrap">{{ $rendezvous->links() }}</div>
  @endif
</div>
@endsection
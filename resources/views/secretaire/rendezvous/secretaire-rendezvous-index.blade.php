@extends('secretaire.layouts.app')

@section('title', 'Appointments')
@section('subtitle', 'Manage and confirm appointments')

@section('topbar-actions')
  <a href="{{ route('secretaire.rendezvous.create') }}" class="btn-primary">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    <span>New Appointment</span>
  </a>
@endsection

@section('content')

<div class="stats-grid">
  <div class="stat"><div class="stat-num" style="color:#0369a1">{{ $stats['total'] }}</div><div class="stat-label">Total</div></div>
  <div class="stat"><div class="stat-num" style="color:#d97706">{{ $stats['en_attente'] }}</div><div class="stat-label">Pending</div></div>
  <div class="stat"><div class="stat-num" style="color:#16a34a">{{ $stats['confirme'] }}</div><div class="stat-label">Confirmed</div></div>
  <div class="stat"><div class="stat-num" style="color:#dc2626">{{ $stats['annule'] }}</div><div class="stat-label">Cancelled</div></div>
</div>

<div class="card">
  <div class="card-header">
    <h2>All Appointments</h2>
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
      <select name="statut" class="filter-select" onchange="this.form.submit()">
        <option value="">All statuses</option>
        <option value="en_attente" @selected(request('statut')==='en_attente')>Pending</option>
        <option value="confirme" @selected(request('statut')==='confirme')>Confirmed</option>
        <option value="annule" @selected(request('statut')==='annule')>Cancelled</option>
      </select>
      @if(request('statut'))
        <a href="{{ route('secretaire.rendezvous.index') }}" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#64748b;text-decoration:none">Reset</a>
      @endif
    </form>
  </div>
  <table>
    <thead>
      <tr><th>Patient</th><th>Doctor</th><th>Speciality</th><th>Date</th><th>Time</th><th>Status</th><th style="text-align:right">Actions</th></tr>
    </thead>
    <tbody>
      @forelse($rendezvous as $rdv)
      <tr>
        <td data-label="Patient" style="font-weight:600">{{ $rdv->patient->user->name??'-' }}</td>
        <td data-label="Doctor">{{ $rdv->medecin->user->name??'-' }}</td>
        <td data-label="Speciality" style="color:#64748b">{{ $rdv->medecin->specialite->nom??'-' }}</td>
        <td data-label="Date">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
        <td data-label="Time" style="font-weight:600;color:#993556">{{ substr($rdv->heure_rdv,0,5) }}</td>
        <td data-label="Status">
          @if($rdv->statut==='confirme')<span class="pill pg">Confirmed</span>
          @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
          @else<span class="pill pr">Cancelled</span>@endif
        </td>
        <td data-label="Actions">
          <div style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:wrap">
            @if($rdv->statut==='en_attente')
            <form action="{{ route('secretaire.rendezvous.confirmer', $rdv) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" class="btn-confirm">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Confirm
              </button>
            </form>
            <form action="{{ route('secretaire.rendezvous.annuler', $rdv) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
              @csrf @method('PATCH')
              <button type="submit" class="btn-cancel">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Cancel
              </button>
            </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7"><div class="empty-state">No appointments found.</div></td></tr>
      @endforelse
    </tbody>
  </table>
  @if($rendezvous->hasPages())
  <div class="pagination-wrap">{{ $rendezvous->links() }}</div>
  @endif
</div>
@endsection

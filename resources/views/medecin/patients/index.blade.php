@extends('medecin.layouts.app')

@section('title', 'My Patients')
@section('subtitle', '{{ $patients->count() }} patients suivis')

@section('content')

@push('styles')
<style>
.patients-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
.patient-card{background:white;border-radius:16px;border:1px solid #e2e8f0;padding:18px;transition:all .2s;text-decoration:none;display:block;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.patient-card:hover{transform:translateY(-2px);border-color:#059669;box-shadow:0 4px 20px rgba(5,150,105,.1)}
.p-header{display:flex;align-items:center;gap:12px;margin-bottom:14px}
.p-avatar{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;background:#f0fdf4;color:#059669}
.p-name{font-size:14px;font-weight:700;color:#0f172a}
.p-email{font-size:11px;color:#94a3b8}
.p-info{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px}
.info-box{background:#f8fafc;border-radius:8px;padding:8px 10px}
.info-lbl{font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase}
.info-val{font-size:12px;font-weight:600;color:#0f172a;margin-top:2px}
.p-footer{display:flex;justify-content:space-between;padding-top:10px;border-top:1px solid #f1f5f9;font-size:11px;color:#64748b}
@media(max-width:600px){.patients-grid{grid-template-columns:1fr}}
</style>
@endpush

<input type="text" id="search" placeholder="Search patient..."
  style="width:100%;padding:10px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:13px;outline:none;background:#f8fafc;margin-bottom:20px;max-width:400px;display:block"
  oninput="filterPatients(this.value)">

@if($patients->isEmpty())
  <div class="empty-state">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 12px;opacity:.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    <p>No patients yet.</p>
  </div>
@else
<div class="patients-grid" id="grid">
  @foreach($patients as $p)
  <a href="{{ route('medecin.patients.show', $p) }}" class="patient-card" data-name="{{ strtolower($p->user->name) }}">
    <div class="p-header">
      <div class="p-avatar">{{ strtoupper(substr($p->user->name,0,2)) }}</div>
      <div>
        <div class="p-name">{{ $p->user->name }}</div>
        <div class="p-email">{{ $p->user->email }}</div>
      </div>
    </div>
    <div class="p-info">
      <div class="info-box">
        <div class="info-lbl">Birth Date</div>
        <div class="info-val">{{ $p->birth_date?->format('d/m/Y')??'-' }}</div>
      </div>
      <div class="info-box">
        <div class="info-lbl">Blood Type</div>
        <div class="info-val" style="color:#dc2626">{{ $p->blood_type??'-' }}</div>
      </div>
      <div class="info-box">
        <div class="info-lbl">Gender</div>
        <div class="info-val">{{ $p->gender==='M'?'Male':($p->gender==='F'?'Female':'-') }}</div>
      </div>
      <div class="info-box">
        <div class="info-lbl">Allergies</div>
        <div class="info-val">{{ $p->Allergies??'None' }}</div>
      </div>
    </div>
    <div class="p-footer">
      <span>{{ $p->rdv_count }} appointments</span>
      @if($p->dernier_rdv)
        <span>Last: {{ \Carbon\Carbon::parse($p->dernier_rdv->date_rdv)->format('d/m/Y') }}</span>
      @endif
    </div>
  </a>
  @endforeach
</div>
@endif

@endsection

@push('scripts')
<script>
function filterPatients(v){
  document.querySelectorAll('.patient-card').forEach(c=>{
    c.style.display=c.dataset.name.includes(v.toLowerCase())?'':'none';
  });
}
</script>
@endpush
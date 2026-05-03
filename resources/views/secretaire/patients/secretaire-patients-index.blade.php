@extends('secretaire.layouts.app')

@section('title', 'Patients')
@section('subtitle', $patients->total() . ' patients registered')

@section('topbar-actions')
  <a href="{{ route('secretaire.patients.create') }}" class="btn-primary">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    <span>Add Patient</span>
  </a>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h2>Patient List</h2>
    <input type="text" id="search" placeholder="Search patient..." class="search-input" oninput="filterTable(this.value)" style="max-width:240px;width:100%">
  </div>
  <table id="ptable">
    <thead>
      <tr><th>Patient</th><th>Birth Date</th><th>Gender</th><th>Blood Type</th><th>Phone</th><th style="text-align:right">Actions</th></tr>
    </thead>
    <tbody>
      @forelse($patients as $p)
      <tr data-name="{{ strtolower($p->user->name) }}">
        <td data-label="Patient">
          <div style="display:flex;align-items:center;gap:10px">
            <div class="avatar" style="background:#fdf2f8;color:#993556">{{ strtoupper(substr($p->user->name??'?',0,2)) }}</div>
            <div>
              <div style="font-weight:600;color:#0f172a">{{ $p->user->name }}</div>
              <div style="font-size:12px;color:#94a3b8">{{ $p->user->email }}</div>
            </div>
          </div>
        </td>
        <td data-label="Birth Date">{{ $p->birth_date?->format('d/m/Y')??'-' }}</td>
        <td data-label="Gender">{{ $p->gender==='M'?'Male':($p->gender==='F'?'Female':'-') }}</td>
        <td data-label="Blood Type"><span class="pill pr">{{ $p->blood_type??'-' }}</span></td>
        <td data-label="Phone" style="color:#64748b">{{ $p->user->phone??'-' }}</td>
        <td data-label="Actions">
          <div style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:wrap">
            <a href="{{ route('secretaire.patients.edit', $p) }}" class="btn-secondary">
              <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              Edit
            </a>
            <form action="{{ route('secretaire.patients.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete {{ $p->user->name }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6"><div class="empty-state">No patients found.</div></td></tr>
      @endforelse
    </tbody>
  </table>
  @if($patients->hasPages())
  <div class="pagination-wrap">{{ $patients->links() }}</div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function filterTable(v){
  document.querySelectorAll('#ptable tbody tr[data-name]').forEach(r=>{
    r.style.display=r.dataset.name.includes(v.toLowerCase())?'':'none';
  });
}
</script>
@endpush

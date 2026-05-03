@extends('admin.layouts.app')
@section('title', 'Specialities')
@section('subtitle', 'Manage medical specialities')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $specialites->total() }} Specialities</h2>
        <a href="{{ route('admin.specialites.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Speciality
        </a>
    </div>
    <table>
        <thead><tr><th>#</th><th>Nom</th><th>Medecins</th><th style="text-align:right">Actions</th></tr></thead>
        <tbody>
            @forelse($specialites as $s)
            <tr>
                <td style="color:#94a3b8">{{ $s->id }}</td>
                <td style="font-weight:600;color:#0f172a">{{ $s->nom }}</td>
                <td><span class="pill pill-teal">{{ $s->medecins_count }} doctor(s)</span></td>
                <td>
                    <div style="display:flex;justify-content:flex-end;gap:6px">
                        <a href="{{ route('admin.specialites.edit', $s) }}" class="btn-secondary" style="padding:7px 12px">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.specialites.destroy', $s) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:7px 12px">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="empty-state"><p>None Speciality.</p></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($specialites->hasPages())
    <div class="pagination-wrap">{{ $specialites->links() }}</div>
    @endif
</div>
@endsection




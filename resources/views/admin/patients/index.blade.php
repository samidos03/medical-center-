@extends('admin.layouts.app')
@section('title', 'Patients')
@section('subtitle', $patients->total() . ' patients enregistres')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des patients</h2>
    </div>
    <table>
        <thead><tr><th>Patient</th><th>Naissance</th><th>Gender</th><th>Sang</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
        <tbody>
            @forelse($patients as $p)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <div class="avatar" style="background:#faf5ff;color:#7c3aed">{{ strtoupper(substr($p->user->name??'?',0,2)) }}</div>
                        <div>
                            <div style="font-weight:600;color:#0f172a">{{ $p->user->name??'N/A' }}</div>
                            <div style="font-size:12px;color:#94a3b8">{{ $p->user->email??'' }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#64748b">{{ $p->birth_date?$p->birth_date->format('d/m/Y'):'-' }}</td>
                <td>
                    @if($p->gender==='M') <span class="pill pill-blue">M</span>
                    @elseif($p->gender==='F') <span class="pill" style="background:#fdf2f8;color:#be185d">F</span>
                    @else <span style="color:#94a3b8">-</span> @endif
                </td>
                <td><span class="pill pill-red">{{ $p->blood_type??'-' }}</span></td>
                <td>
                    @if($p->user?->actif) <span class="pill pill-green">Active</span>
                    @else <span class="pill pill-red">Inactive</span> @endif
                </td>
                <td style="text-align:right">
                    <a href="{{ route('admin.patients.show', $p) }}" class="btn-secondary" style="padding:7px 12px">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-state"><p>No patients found.</p></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($patients->hasPages())
    <div class="pagination-wrap">{{ $patients->links() }}</div>
    @endif
</div>
@endsection




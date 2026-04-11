@extends('admin.layouts.app')
@section('title', 'Users')
@section('subtitle', 'Gestion des comptes')

@section('content')
<div class="stats-mini">
    <div class="stat-mini"><div class="stat-mini-num" style="color:#0369a1">{{ $stats['total'] }}</div><div class="stat-mini-label">Total</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#059669">{{ $stats['medecins'] }}</div><div class="stat-mini-label">Medecins</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#7c3aed">{{ $stats['patients'] }}</div><div class="stat-mini-label">Patients</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#d97706">{{ $stats['secretaires'] }}</div><div class="stat-mini-label">Secretaires</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#64748b">{{ $stats['admins'] }}</div><div class="stat-mini-label">Admins</div></div>
    <div class="stat-mini"><div class="stat-mini-num" style="color:#dc2626">{{ $stats['inactifs'] }}</div><div class="stat-mini-label">Inactifs</div></div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Liste des Users</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New User
        </a>
    </div>
    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9">
        <form method="GET" class="search-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom ou email..." class="search-input">
            <select name="role" class="search-select">
                <option value="">Tous les roles</option>
                @foreach(['admin','medecin','secretaire','patient'] as $r)
                    <option value="{{ $r }}" @selected(request('role')===$r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filter</button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Reset</a>
            @endif
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <div class="avatar" style="background:#eff6ff;color:#0369a1">{{ strtoupper(substr($user->name,0,2)) }}</div>
                        <div>
                            <div style="font-weight:600;color:#0f172a">{{ $user->name }}</div>
                            <div style="font-size:12px;color:#94a3b8">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @php $colors=['admin'=>'pill-blue','medecin'=>'pill-teal','secretaire'=>'pill-amber','patient'=>'pill-purple']; @endphp
                    <span class="pill {{ $colors[$user->role] ?? 'pill-blue' }}">{{ ucfirst($user->role) }}</span>
                    @if($user->role==='medecin' && $user->medecin?->Speciality)
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px">{{ $user->medecin->Speciality->nom }}</div>
                    @endif
                </td>
                <td style="color:#64748b">{{ $user->phone ?? '—' }}</td>
                <td>
                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="pill {{ $user->actif ? 'pill-green' : 'pill-red' }}" style="border:none;cursor:pointer;transition:all .2s">
                            {{ $user->actif ? 'Actif' : 'Inactif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary" style="padding:7px 12px">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:7px 12px">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="empty-state"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg><p>Aucun utilisateur trouve.</p></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())
    <div class="pagination-wrap">{{ $users->links() }}</div>
    @endif
</div>
@endsection




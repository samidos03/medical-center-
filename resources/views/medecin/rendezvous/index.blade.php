<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - Bahjawa Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0fdf4;min-height:100vh;display:flex}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#065f46,#059669,#34d399);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50}
        .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.12)}
        .logo-inner{display:flex;align-items:center;gap:10px}
        .logo-icon{width:40px;height:40px;background:white;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .logo-name{font-size:13px;font-weight:700;color:white;line-height:1.3}
        .logo-sub{font-size:10px;color:rgba(255,255,255,.6);display:block}
        .sidebar-nav{flex:1;padding:16px 12px;overflow-y:auto}
        .nav-section{font-size:10px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.8px;padding:0 10px;margin:16px 0 8px}
        .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;color:rgba(255,255,255,.75);font-size:13px;font-weight:500;text-decoration:none;transition:all .2s;margin-bottom:2px}
        .nav-item:hover{background:rgba(255,255,255,.12);color:white}
        .nav-item.active{background:rgba(255,255,255,.2);color:white;font-weight:600}
        .nav-item svg{width:18px;height:18px;flex-shrink:0}
        .sidebar-footer{padding:16px 12px;border-top:1px solid rgba(255,255,255,.12)}
        .user-card{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:12px}
        .user-avatar{width:36px;height:36px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#059669;flex-shrink:0}
        .user-name{font-size:13px;font-weight:600;color:white}
        .user-role{font-size:11px;color:rgba(255,255,255,.6)}
        .btn-logout{width:100%;margin-top:8px;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.8);font-size:12px;font-weight:600;cursor:pointer}
        .btn-logout:hover{background:rgba(239,68,68,.3);color:white}
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .topbar h1{font-size:18px;font-weight:700;color:#0f172a}
        .topbar p{font-size:12px;color:#94a3b8;margin-top:2px}
        .content{padding:24px 28px;flex:1}
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
        .stat{background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center}
        .stat-num{font-size:26px;font-weight:700}
        .stat-label{font-size:12px;color:#64748b;margin-top:3px}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
        .card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
        .card-header h2{font-size:15px;font-weight:700;color:#0f172a}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
        td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#f0fdf4}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .btn-confirm{display:inline-flex;align-items:center;gap:4px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-confirm:hover{background:#dcfce7}
        .btn-cancel{display:inline-flex;align-items:center;gap:4px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-cancel:hover{background:#fee2e2}
        .filter-select{padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;cursor:pointer}
        .filter-input{padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc}
        .filter-select:focus,.filter-input:focus{border-color:#059669}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:13px;margin-bottom:20px}
        .pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#059669,#065f46);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#dcfce7" stroke="#059669" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <div><span class="logo-name">Bahjawa Medical</span><span class="logo-sub">Doctor Space</span></div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('medecin.dashboard') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('medecin.rendezvous.index') }}" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Appointments
            @if($stats['en_attente'] > 0)
                <span style="background:#f59e0b;color:white;border-radius:20px;padding:2px 8px;font-size:10px;font-weight:700;margin-left:auto">{{ $stats['en_attente'] }}</span>
            @endif
        </a>
        <a href="{{ route('medecin.agenda') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Agenda
        </a>
        <a href="{{ route('medecin.patients.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            My Patients
        </a>
        <a href="{{ route('medecin.consultations.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Consultations
        </a>
        <a href="{{ route('medecin.disponibilites.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Availability
        </a>
        <div class="nav-section">Actions</div>
        <a href="{{ route('medecin.consultations.create') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Consultation
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->medecin?->specialite?->nom ?? 'Doctor' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <h1>My Appointments</h1>
            <p>Manage and confirm your appointments</p>
        </div>
        <a href="{{ route('medecin.consultations.create') }}" class="btn-primary">+ New Consultation</a>
    </div>
    <div class="content">
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif

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
                    <input type="date" name="date" value="{{ request('date') }}" class="filter-input" onchange="this.form.submit()">
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
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:30px;height:30px;border-radius:50%;background:#f0fdf4;color:#059669;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0">
                                    {{ strtoupper(substr($rdv->patient->user->name??'?',0,2)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#0f172a">{{ $rdv->patient->user->name??'-' }}</div>
                                    <div style="font-size:11px;color:#94a3b8">{{ $rdv->patient->user->email??'' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                        <td style="font-weight:600;color:#059669">{{ substr($rdv->heure_rdv,0,5) }}</td>
                        <td>
                            @if($rdv->statut==='confirme')<span class="pill pg">Confirmed</span>
                            @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
                            @else<span class="pill pr">Cancelled</span>@endif
                        </td>
                        <td>
                            <div style="display:flex;justify-content:flex-end;gap:6px">
                                @if($rdv->statut==='en_attente')
                                <form action="{{ route('medecin.rendezvous.confirmer', $rdv) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-confirm">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Confirm
                                    </button>
                                </form>
                                @endif
                                @if($rdv->statut !== 'annule')
                                <form action="{{ route('medecin.rendezvous.annuler', $rdv) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-cancel">
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
                    <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:32px">No appointments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($rendezvous->hasPages())
            <div class="pagination-wrap">{{ $rendezvous->links() }}</div>
            @endif
        </div>
    </div>
</div>
</body>
</html>





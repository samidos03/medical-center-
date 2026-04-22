<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Availability - Bahjawa Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#fdf2f8;min-height:100vh;display:flex}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#4B1528,#993556,#D4537E);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50}
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
        .user-avatar{width:36px;height:36px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#993556;flex-shrink:0}
        .user-name{font-size:13px;font-weight:600;color:white}
        .user-role{font-size:11px;color:rgba(255,255,255,.6)}
        .btn-logout{width:100%;margin-top:8px;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.8);font-size:12px;font-weight:600;cursor:pointer}
        .btn-logout:hover{background:rgba(239,68,68,.3);color:white}
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .topbar h1{font-size:18px;font-weight:700;color:#0f172a}
        .topbar p{font-size:12px;color:#94a3b8;margin-top:2px}
        .content{padding:24px 28px;flex:1}
        .medecin-card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px;transition:box-shadow .2s}
        .medecin-card:hover{box-shadow:0 4px 20px rgba(153,53,86,.1)}
        .medecin-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
        .medecin-info{display:flex;align-items:center;gap:12px}
        .avatar{width:44px;height:44px;border-radius:50%;background:#fdf2f8;color:#993556;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;flex-shrink:0}
        .medecin-name{font-size:15px;font-weight:700;color:#0f172a}
        .medecin-spec{font-size:12px;color:#94a3b8;margin-top:2px}
        .rdv-badge{background:#fdf2f8;color:#993556;border:1px solid #f9a8d4;border-radius:20px;padding:4px 14px;font-size:12px;font-weight:700}
        .planning-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:1px;background:#f1f5f9}
        .day-col{background:white;padding:0}
        .day-header{padding:10px;text-align:center;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #f1f5f9}
        .day-header.has-dispo{background:#fdf2f8;color:#993556}
        .day-header.no-dispo{background:#f8fafc;color:#94a3b8}
        .day-slots{padding:10px;min-height:80px}
        .slot{background:#fdf2f8;border:1px solid #f9a8d4;border-radius:8px;padding:5px 8px;font-size:11px;font-weight:600;color:#993556;margin-bottom:4px;text-align:center}
        .no-slot{text-align:center;color:#cbd5e1;font-size:11px;padding:10px 0}
        .status-available{display:inline-flex;align-items:center;gap:4px;background:#f0fdf4;color:#16a34a;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600}
        .status-busy{display:inline-flex;align-items:center;gap:4px;background:#fef2f2;color:#dc2626;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600}
        .dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#993556,#4B1528);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
        .legend{display:flex;gap:16px;margin-bottom:20px;align-items:center;flex-wrap:wrap}
        .legend-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#64748b}
        .legend-dot{width:10px;height:10px;border-radius:3px}
        .empty{text-align:center;padding:60px;color:#94a3b8;font-size:14px}
        .filter-bar{display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap}
        .search-input{padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;min-width:240px}
        .search-input:focus{border-color:#993556;background:white}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#fdf2f8" stroke="#993556" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#993556" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <div><span class="logo-name">Bahjawa Medical</span><span class="logo-sub">Secretary Space</span></div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('secretaire.dashboard') }}" class="nav-item {{ request()->routeIs('secretaire.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('secretaire.patients.index') }}" class="nav-item {{ request()->routeIs('secretaire.patients.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Patients
        </a>
        <a href="{{ route('secretaire.rendezvous.index') }}" class="nav-item {{ request()->routeIs('secretaire.rendezvous.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Appointments
        </a>
        <a href="{{ route('secretaire.medecins.disponibilites') }}" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Doctors Schedule
        </a>
        <div class="nav-section">Actions</div>
        <a href="{{ route('secretaire.patients.create') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Add Patient
        </a>
        <a href="{{ route('secretaire.rendezvous.create') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Appointment
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Secretary</div>
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
            <h1>Doctors Schedule</h1>
            <p>View availability and appointments for each doctor</p>
        </div>
        <a href="{{ route('secretaire.rendezvous.create') }}" class="btn-primary">+ New Appointment</a>
    </div>
    <div class="content">
        <div class="legend">
            <div class="legend-item"><div class="legend-dot" style="background:#fdf2f8;border:1px solid #f9a8d4"></div>Available slot</div>
            <div class="legend-item"><div class="legend-dot" style="background:#f8fafc;border:1px solid #e2e8f0"></div>Not available</div>
            <div class="legend-item">
                <span class="status-available"><span class="dot" style="background:#16a34a"></span>Available</span>
                Doctor has free slots
            </div>
            <div class="legend-item">
                <span class="status-busy"><span class="dot" style="background:#dc2626"></span>Busy</span>
                Has upcoming appointments
            </div>
        </div>

        <div class="filter-bar">
            <input type="text" id="search-doc" placeholder="Search doctor or speciality..." class="search-input" oninput="filterDoctors(this.value)">
        </div>

        @forelse($medecins as $m)
        <div class="medecin-card" data-name="{{ strtolower($m->user->name . ' ' . $m->specialite->nom) }}">
            <div class="medecin-header">
                <div class="medecin-info">
                    <div class="avatar">{{ strtoupper(substr($m->user->name??'?',0,2)) }}</div>
                    <div>
                        <div class="medecin-name">{{ $m->user->name }}</div>
                        <div class="medecin-spec">{{ $m->specialite->nom??'General' }}- {{ $m->telephone??'N/A' }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                    @if($m->rdv_total > 0)
                        <span class="status-busy"><span class="dot" style="background:#dc2626"></span>{{ $m->rdv_total }} upcoming RDV</span>
                    @else
                        <span class="status-available"><span class="dot" style="background:#16a34a"></span>Available</span>
                    @endif
                    @if($m->disponibilites->isEmpty())
                        <span style="background:#f8fafc;color:#94a3b8;border-radius:20px;padding:4px 12px;font-size:11px;font-weight:600;border:1px solid #e2e8f0">No schedule defined</span>
                    @else
                        <span class="rdv-badge">{{ $m->disponibilites->count() }} slot(s)</span>
                    @endif
                </div>
            </div>

            @if($m->disponibilites->isEmpty())
                <div class="empty" style="padding:24px">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:32px;height:32px;margin:0 auto 8px;opacity:.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>No availability defined for this doctor.</p>
                </div>
            @else
                <div class="planning-grid">
                    @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi'] as $jour)
                        @php
                            $dayDispos = $m->disponibilites->where('jour', $jour)->values();
                            $hasSlots = $dayDispos->isNotEmpty();
                        @endphp
                        <div class="day-col">
                            <div class="day-header {{ $hasSlots ? 'has-dispo' : 'no-dispo' }}">
                                {{ ucfirst(substr($jour,0,3)) }}
                            </div>
                            <div class="day-slots">
                                @if($hasSlots)
                                    @foreach($dayDispos as $d)
                                        <div class="slot">
                                            {{ substr($d->heure_debut,0,5) }}<br>{{ substr($d->heure_fin,0,5) }}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-slot">
                                    
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @empty
            <div class="empty">No doctors found.</div>
        @endforelse
    </div>
</div>
<script>
function filterDoctors(v) {
    document.querySelectorAll('.medecin-card').forEach(c => {
        c.style.display = c.dataset.name.includes(v.toLowerCase()) ? '' : 'none';
    });
}
</script>
</body>
</html>






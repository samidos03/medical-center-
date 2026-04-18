<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patients - Bahjawa Medical</title>
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
        .search-input{width:100%;padding:11px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:13px;outline:none;background:#f8fafc;margin-bottom:20px}
        .search-input:focus{border-color:#059669;background:white;box-shadow:0 0 0 3px rgba(5,150,105,.1)}
        .patients-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
        .patient-card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:20px;transition:all .2s;text-decoration:none;display:block}
        .patient-card:hover{transform:translateY(-2px);border-color:#059669;box-shadow:0 4px 20px rgba(5,150,105,.1)}
        .p-header{display:flex;align-items:center;gap:12px;margin-bottom:14px}
        .p-avatar{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;flex-shrink:0;background:#f0fdf4;color:#059669}
        .p-name{font-size:14px;font-weight:700;color:#0f172a}
        .p-email{font-size:12px;color:#94a3b8}
        .p-info{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px}
        .info-box{background:#f8fafc;border-radius:8px;padding:8px 10px}
        .info-lbl{font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase}
        .info-val{font-size:12px;font-weight:600;color:#0f172a;margin-top:2px}
        .p-footer{display:flex;justify-content:space-between;padding-top:10px;border-top:1px solid #f1f5f9;font-size:12px;color:#64748b}
        .empty-state{text-align:center;padding:60px;color:#94a3b8}
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
        <a href="{{ route('medecin.dashboard') }}" class="nav-item {{ request()->routeIs('medecin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('medecin.rendezvous.index') }}" class="nav-item {{ request()->routeIs('medecin.rendezvous.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Appointments
        </a>
        <a href="{{ route('medecin.agenda') }}" class="nav-item {{ request()->routeIs('medecin.agenda') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Agenda
        </a>
        <a href="{{ route('medecin.patients.index') }}" class="nav-item {{ request()->routeIs('medecin.patients.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            My Patients
        </a>
        <a href="{{ route('medecin.consultations.index') }}" class="nav-item {{ request()->routeIs('medecin.consultations.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Consultations
        </a>
        <a href="{{ route('medecin.disponibilites.index') }}" class="nav-item {{ request()->routeIs('medecin.disponibilites.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Availability
        </a>
        <div class="nav-section">Actions</div>
        <a href="{{ route('medecin.consultations.create') }}" class="nav-item {{ request()->routeIs('medecin.consultations.create') ? 'active' : '' }}">
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
                    <div class="user-role">{{ auth()->user()->medecin?->specialite?->nom ?? 'Medecin' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">DeSign In</button>
            </form>
        </div>
    </div>
</aside>
<div class="main">
    <div class="topbar">
        <div>
            <h1>My Patients</h1>
            <p>{{ $patients->count() }} patients suivis</p>
        </div>
    </div>
    <div class="content">
        <input type="text" id="search" placeholder="Rechercher un patient..." class="search-input" oninput="filterPatients(this.value)">
        @if($patients->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 12px;opacity:.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p>Aucun patient pour le moment.</p>
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
                    <div class="info-box"><div class="info-lbl">Naissance</div><div class="info-val">{{ $p->birth_date?->format('d/m/Y')??'-' }}</div></div>
                    <div class="info-box"><div class="info-lbl">Blood Type</div><div class="info-val" style="color:#dc2626">{{ $p->blood_type??'-' }}</div></div>
                    <div class="info-box"><div class="info-lbl">Gender</div><div class="info-val">{{ $p->gender==='M'?'Male':($p->gender==='F'?'Female':'-') }}</div></div>
                    <div class="info-box"><div class="info-lbl">Allergies</div><div class="info-val">{{ $p->Allergies??'None' }}</div></div>
                </div>
                <div class="p-footer">
                    <span>{{ $p->rdv_count }} RDV avec moi</span>
                    @if($p->dernier_rdv)<span>Dernier : {{ \Carbon\Carbon::parse($p->dernier_rdv->date_rdv)->format('d/m/Y') }}</span>@endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
<script>
function filterPatients(v){
    document.querySelectorAll('.patient-card').forEach(c=>{
        c.style.display=c.dataset.name.includes(v.toLowerCase())?'':'none';
    });
}
</script>
</body>
</html>











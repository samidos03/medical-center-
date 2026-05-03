<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History - Bahjawa Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        html,body{overflow-x:hidden;max-width:100%}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#fffbeb;min-height:100vh;display:flex}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#78350f,#b45309,#f59e0b);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50;transition:transform .3s ease}
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
        .user-avatar{width:36px;height:36px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#b45309;flex-shrink:0}
        .user-name{font-size:13px;font-weight:600;color:white}
        .user-role{font-size:11px;color:rgba(255,255,255,.6)}
        .btn-logout{width:100%;margin-top:8px;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.8);font-size:12px;font-weight:600;cursor:pointer}
        .btn-logout:hover{background:rgba(239,68,68,.3);color:white}
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column;min-width:0;overflow-x:hidden}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;gap:10px}
        .topbar h1{font-size:18px;font-weight:700;color:#0f172a}
        .topbar p{font-size:12px;color:#94a3b8;margin-top:2px}
        .content{padding:24px 28px;flex:1;min-width:0}
        .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
        .stat{background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center}
        .stat-num{font-size:24px;font-weight:700}
        .stat-lbl{font-size:12px;color:#64748b;margin-top:3px}
        .timeline{display:flex;flex-direction:column;gap:16px}
        .rdv-card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden;transition:box-shadow .2s}
        .rdv-card:hover{box-shadow:0 4px 20px rgba(180,83,9,.1)}
        .rdv-card.confirmed{border-left:4px solid #16a34a}
        .rdv-card.cancelled{border-left:4px solid #dc2626}
        .rdv-card.pending{border-left:4px solid #d97706}
        .rdv-header{padding:16px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
        .rdv-left{display:flex;align-items:center;gap:12px}
        .rdv-avatar{width:42px;height:42px;border-radius:50%;background:#f0fdf4;color:#059669;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0}
        .rdv-doctor{font-size:14px;font-weight:700;color:#0f172a}
        .rdv-spec{font-size:12px;color:#94a3b8;margin-top:2px}
        .rdv-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .rdv-date{font-size:13px;font-weight:600;color:#b45309;background:#fffbeb;padding:5px 12px;border-radius:10px}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .consultation-box{background:#f8fafc;border-top:1px solid #f1f5f9;padding:16px 20px}
        .consult-title{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px}
        .consult-text{font-size:13px;color:#334155;line-height:1.6;background:white;border:1px solid #e2e8f0;border-radius:10px;padding:12px}
        .Prescription-box{background:#f0fdf4;border-top:1px solid #bbf7d0;padding:16px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
        .btn-pdf{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#059669,#065f46);color:white;border:none;border-radius:10px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
        .btn-pdf:hover{opacity:.9}
        .no-consult{padding:16px 20px;font-size:13px;color:#94a3b8;font-style:italic;border-top:1px solid #f1f5f9}
        .empty-state{text-align:center;padding:60px;color:#94a3b8}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#b45309,#78350f);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;white-space:nowrap}
.hamburger{display:none;width:34px;height:34px;border-radius:9px;border:1px solid #e2e8f0;background:white;align-items:center;justify-content:center;cursor:pointer;color:#64748b;flex-shrink:0}
        .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:49}
        .overlay.open{display:block}
        @media(max-width:768px){
          .hamburger{display:flex}
          .sidebar{transform:translateX(-100%)}
          .sidebar.open{transform:translateX(0)}
          .main{margin-left:0}
          .topbar{padding:12px 16px 12px 56px}
          .topbar h1{font-size:15px}
          .content{padding:16px 12px}
          .stats-row{grid-template-columns:1fr 1fr}
          .rdv-header{flex-direction:column;align-items:flex-start}
        }
        @media(max-width:480px){
          .topbar p{display:none}
          .Prescription-box{flex-direction:column;align-items:flex-start}
        }
    </style>
</head>
<body>
<button class="hamburger" onclick="toggleSidebar()">
  <svg width="20" height="20" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#fffbeb" stroke="#b45309" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#b45309" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <div><span class="logo-name">Bahjawa Medical</span><span class="logo-sub">Patient Space</span></div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('patient.dashboard') }}" class="nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('patient.rendezvous.index') }}" class="nav-item {{ request()->routeIs('patient.rendezvous.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Appointments
        </a>
        <a href="{{ route('patient.historique') }}" class="nav-item {{ request()->routeIs('patient.historique') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            History
        </a>
        <a href="{{ route('patient.profil') }}" class="nav-item {{ request()->routeIs('patient.profil') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            My Profile
        </a>
        <div class="nav-section">Actions</div>
        <a href="{{ route('patient.rendezvous.create') }}" class="nav-item {{ request()->routeIs('patient.rendezvous.create') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Book Appointment
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Patient</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </div>
</aside>
<div class="main" id="main">
    <div class="topbar">
        <div><h1>Medical History</h1><p>Your consultations and prescriptions</p></div>
        <a href="{{ route('patient.rendezvous.create') }}" class="btn-primary">+ Book Appointment</a>
    </div>
    <div class="content">
        <div class="stats-row">
           <div class="stat"><div class="stat-num" style="color:#b45309">{{ $rdvs->count() }}</div><div class="stat-lbl">Total Records</div></div>
            <div class="stat"><div class="stat-num" style="color:#16a34a">{{ $rdvs->where('statut','Confirmed')->count() }}</div><div class="stat-lbl">Confirmed</div></div>
            <div class="stat"><div class="stat-num" style="color:#7c3aed">{{ $rdvs->filter(fn($r) => $r->consultation)->count() }}</div><div class="stat-lbl">Consultations</div></div>
            <div class="stat"><div class="stat-num" style="color:#059669">{{ $rdvs->filter(fn($r) => $r->consultation?->Prescription)->count() }}</div><div class="stat-lbl">Prescriptions</div></div>
        </div>
        @if($rdvs->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:56px;height:56px;margin:0 auto 16px;opacity:.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p>No medical history found.</p>
                <a href="{{ route('patient.rendezvous.create') }}" class="btn-primary" style="margin-top:16px">Book your first appointment</a>
            </div>
        @else
        <div class="timeline">
            @foreach($rdvs->sortByDesc('date_rdv') as $rdv)
            <div class="rdv-card {{ $rdv->statut === 'Confirmed' ? 'confirmed' : ($rdv->statut === 'Cancelled' ? 'cancelled' : 'pending') }}">
                <div class="rdv-header">
                    <div class="rdv-left">
                        <div class="rdv-avatar">{{ strtoupper(substr($rdv->medecin->user->name??'?',0,2)) }}</div>
                        <div>
                            <div class="rdv-doctor">{{ $rdv->medecin->user->name??' - ' }}</div>
                            <div class="rdv-spec">{{ $rdv->medecin->specialite->nom??' - ' }}</div>
                        </div>
                    </div>
                    <div class="rdv-right">
                        <span class="rdv-date">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }} at {{ substr($rdv->heure_rdv,0,5) }}</span>
                        @if($rdv->statut==='Confirmed')<span class="pill pg">Confirmed</span>
                        @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
                        @else<span class="pill pr">Cancelled</span>@endif
                    </div>
                </div>
                @if($rdv->consultation)
                    <div class="consultation-box">
                        <div class="consult-title">Consultation Summary</div>
                        <div class="consult-text">{{ $rdv->consultation->compte_rendu }}</div>
                    </div>
                    @if($rdv->consultation->Prescription)
                    <div class="Prescription-box">
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#065f46">Prescription Available</div>
                            <div style="font-size:12px;color:#64748b;margin-top:2px">Issued on {{ \Carbon\Carbon::parse($rdv->consultation->Prescription->date_creation)->format('d/m/Y') }}</div>
                        </div>
                        <a href="{{ route('patient.Prescriptions.pdf', $rdv->consultation->Prescription) }}" class="btn-pdf">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download PDF
                        </a>
                    </div>
                    @else
                    <div class="no-consult" style="background:#fefce8;border-top:1px solid #fde68a;color:#92400e">Consultation done — No prescription issued</div>
                    @endif
                @else
                    <div class="no-consult">
                        @if($rdv->statut==='Confirmed') Appointment confirmed — Consultation not yet done
                        @elseif($rdv->statut==='Cancelled') Appointment was cancelled
                        @else Awaiting confirmation @endif
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<script>
function toggleSidebar(){

  document.getElementById('sidebar').classList.toggle('open');

  document.getElementById('overlay').classList.toggle('open');

}

document.querySelectorAll('.nav-item').forEach(function(link){

  link.addEventListener('click',function(){

    if(window.innerWidth<=768){

      document.getElementById('sidebar').classList.remove('open');

      document.getElementById('overlay').classList.remove('open');

    }

  });

});

window.addEventListener('resize',function(){

  if(window.innerWidth>768){

    document.getElementById('sidebar').classList.remove('open');

    document.getElementById('overlay').classList.remove('open');

  }

});
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Secretary') — Bahjawa Medical</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{box-sizing:border-box;margin:0;padding:0}
html,body{overflow-x:hidden;max-width:100%}
body{font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:#fdf2f8;min-height:100vh;display:flex;color:#0f172a}

/* ── SIDEBAR ── */
.sidebar{width:240px;min-height:100vh;background:linear-gradient(180deg,#4a1528,#993556,#D4537E);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50;transition:transform .3s ease}
.sidebar-logo{padding:22px 18px;border-bottom:1px solid rgba(255,255,255,.12)}
.logo-inner{display:flex;align-items:center;gap:10px}
.logo-icon{width:38px;height:38px;background:white;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.logo-name{font-size:13px;font-weight:700;color:white;line-height:1.3}
.logo-sub{font-size:10px;color:rgba(255,255,255,.55);display:block}
.sidebar-nav{flex:1;padding:14px 10px;overflow-y:auto}
.nav-section{font-size:9px;font-weight:700;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:1px;padding:0 10px;margin:16px 0 6px}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:rgba(255,255,255,.75);font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;margin-bottom:2px}
.nav-item:hover{background:rgba(255,255,255,.12);color:white}
.nav-item.active{background:rgba(255,255,255,.22);color:white;font-weight:600}
.nav-item svg{width:17px;height:17px;flex-shrink:0}
.sidebar-footer{padding:14px 10px;border-top:1px solid rgba(255,255,255,.12)}
.user-card{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:11px 12px}
.user-row{display:flex;align-items:center;gap:10px;margin-bottom:10px}
.user-avatar{width:34px;height:34px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:#993556;flex-shrink:0}
.user-name{font-size:13px;font-weight:600;color:white}
.user-role{font-size:10px;color:rgba(255,255,255,.55)}
.btn-logout{width:100%;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.85);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
.btn-logout:hover{background:rgba(239,68,68,.3);color:white}

/* ── MAIN ── */
.main{flex:1;margin-left:240px;min-height:100vh;display:flex;flex-direction:column;min-width:0;overflow-x:hidden;transition:margin-left .3s ease}
.topbar{background:white;border-bottom:1px solid #e2e8f0;padding:14px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;gap:12px}
.topbar-left{display:flex;align-items:center;gap:12px}
.topbar-title h1{font-size:17px;font-weight:700;color:#0f172a}
.topbar-title p{font-size:11px;color:#94a3b8;margin-top:1px}
.topbar-right{display:flex;align-items:center;gap:10px}
.hamburger{display:none;width:34px;height:34px;border-radius:9px;border:1px solid #e2e8f0;background:white;align-items:center;justify-content:center;cursor:pointer;color:#64748b;flex-shrink:0}

/* ── CONTENT ── */
.content{padding:22px 26px;flex:1;min-width:0;overflow-x:hidden}

/* ── SHARED COMPONENTS ── */
.card{background:white;border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04)}
.card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
.card-header h2{font-size:14px;font-weight:700;color:#0f172a}
.btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#993556,#4a1528);color:white;border:none;border-radius:10px;padding:9px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;white-space:nowrap}
.btn-primary:hover{opacity:.9}
.btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:7px 12px;font-size:12px;font-weight:600;text-decoration:none}
.btn-secondary:hover{background:#f1f5f9}
.btn-danger{display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:600;cursor:pointer;text-decoration:none}
.btn-danger:hover{background:#fee2e2}
.btn-confirm{display:inline-flex;align-items:center;gap:4px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:600;cursor:pointer}
.btn-cancel{display:inline-flex;align-items:center;gap:4px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:600;cursor:pointer}
table{width:100%;border-collapse:collapse}
th{text-align:left;padding:10px 16px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;background:#f8fafc;border-bottom:1px solid #e2e8f0}
td{padding:11px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fdf2f8}
.avatar{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
.pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-flex;align-items:center;gap:5px}
.pill::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0}
.pg{background:#f0fdf4;color:#16a34a}.pg::before{background:#16a34a}
.pa{background:#fffbeb;color:#d97706}.pa::before{background:#d97706}
.pr{background:#fef2f2;color:#dc2626}.pr::before{background:#dc2626}
.alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:13px;margin-bottom:16px}
.alert-error{background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;color:#dc2626;font-size:13px;margin-bottom:16px}
.field{margin-bottom:14px}
.field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
.field input,.field select,.field textarea{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
.field input:focus,.field select:focus,.field textarea:focus{border-color:#993556;background:white;box-shadow:0 0 0 3px rgba(153,53,86,.1)}
.field .err{color:#dc2626;font-size:12px;margin-top:4px}
.form-card{background:white;border-radius:16px;border:1px solid #e2e8f0;padding:22px;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.form-section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.search-input{padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;transition:all .2s}
.search-input:focus{border-color:#993556;background:white}
.filter-select{padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;cursor:pointer}
.filter-select:focus{border-color:#993556}
.pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}
.stat{background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.stat-num{font-size:26px;font-weight:700}
.stat-label{font-size:12px;color:#64748b;margin-top:3px}
.empty-state{text-align:center;padding:32px;color:#94a3b8;font-size:13px}

/* ── OVERLAY ── */
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:49}
.overlay.open{display:block}

/* ── RESPONSIVE ── */
@media(max-width:1200px){
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .grid3{grid-template-columns:1fr 1fr}
}
@media(max-width:900px){
  .grid2{grid-template-columns:1fr}
  .grid3{grid-template-columns:1fr}
}
@media(max-width:768px){
  .hamburger{display:flex}
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main{margin-left:0}
  .topbar{padding:12px 14px 12px 56px}
  .topbar-title h1{font-size:15px}
  .content{padding:14px 12px}
  .btn-primary span{display:none}
  table thead{display:none}
  table tr{display:flex;flex-direction:column;padding:10px 14px;border-bottom:1px solid #e2e8f0}
  table td{padding:3px 0;border:none;font-size:12px}
  table td::before{content:attr(data-label);font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;display:block;margin-bottom:2px}
  .stats-grid{grid-template-columns:1fr 1fr}
  .card-header{flex-direction:column;align-items:flex-start}
}
@media(max-width:480px){
  .stats-grid{grid-template-columns:1fr 1fr}
  .topbar-title p{display:none}
}
</style>
</head>
<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-inner">
      <div class="logo-icon">
        <svg width="24" height="24" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#fdf2f8" stroke="#993556" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#993556" stroke-width="2.5" stroke-linecap="round"/></svg>
      </div>
      <div>
        <span class="logo-name">Bahjawa Medical</span>
        <span class="logo-sub">Secretary Space</span>
      </div>
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
    <a href="{{ route('secretaire.medecins.disponibilites') }}" class="nav-item {{ request()->routeIs('secretaire.medecins.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Doctors Schedule
    </a>
    <div class="nav-section">Actions</div>
    <a href="{{ route('secretaire.patients.create') }}" class="nav-item {{ request()->routeIs('secretaire.patients.create') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
      Add Patient
    </a>
    <a href="{{ route('secretaire.rendezvous.create') }}" class="nav-item {{ request()->routeIs('secretaire.rendezvous.create') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      New Appointment
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-card">
      <div class="user-row">
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

<!-- MAIN -->
<div class="main" id="main">
  <div class="topbar">
    <div class="topbar-left">
      <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <div class="topbar-title">
        <h1>@yield('title', 'Dashboard')</h1>
        <p>@yield('subtitle', '')</p>
      </div>
    </div>
    <div class="topbar-right">
      @yield('topbar-actions')
    </div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert-error">{{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>

@stack('scripts')

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


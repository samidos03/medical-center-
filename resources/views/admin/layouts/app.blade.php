<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Bahjawa Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        html,body{overflow-x:hidden;max-width:100%}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0f7ff;min-height:100vh;display:flex;color:#0f172a}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#0369a1,#0284c7,#0ea5e9);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50;transition:transform .3s ease}
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
        .user-avatar{width:36px;height:36px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#0369a1;flex-shrink:0}
        .user-name{font-size:13px;font-weight:600;color:white}
        .user-role{font-size:11px;color:rgba(255,255,255,.6)}
        .btn-logout{width:100%;margin-top:8px;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.8);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-logout:hover{background:rgba(239,68,68,.3);color:white}
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column;min-width:0;overflow-x:hidden;transition:margin-left .3s ease}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;gap:12px}
        .topbar-left{display:flex;align-items:center;gap:12px}
        .topbar-left h1{font-size:18px;font-weight:700;color:#0f172a}
        .topbar-left p{font-size:12px;color:#94a3b8;margin-top:2px}
        .topbar-date{font-size:13px;color:#64748b;background:#f8fafc;padding:6px 14px;border-radius:10px;border:1px solid #e2e8f0;white-space:nowrap}
        .hamburger{display:none;width:36px;height:36px;border-radius:10px;border:1px solid #e2e8f0;background:white;align-items:center;justify-content:center;cursor:pointer;color:#64748b;flex-shrink:0}
        .content{padding:24px 28px;flex:1;min-width:0;overflow-x:hidden}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
        .card-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
        .card-header h2{font-size:15px;font-weight:700;color:#0f172a}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#0ea5e9,#0369a1);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;transition:opacity .2s;white-space:nowrap}
        .btn-primary:hover{opacity:.9}
        .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
        .btn-secondary:hover{background:#f1f5f9}
        .btn-danger{display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
        .btn-danger:hover{background:#fee2e2}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:11px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc;border-bottom:1px solid #f1f5f9}
        td{padding:13px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#f8fafc}
        .avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
        .pill{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pill-blue{background:#eff6ff;color:#0369a1}
        .pill-green{background:#f0fdf4;color:#16a34a}
        .pill-amber{background:#fffbeb;color:#d97706}
        .pill-red{background:#fef2f2;color:#dc2626}
        .pill-teal{background:#f0fdfa;color:#0f766e}
        .pill-purple{background:#faf5ff;color:#7c3aed}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:13px;margin-bottom:20px}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;color:#dc2626;font-size:13px;margin-bottom:20px}
        .field{margin-bottom:16px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
        .field input,.field select,.field textarea{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
        .field .err{color:#dc2626;font-size:12px;margin-top:4px}
        .form-card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px}
        .form-section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
        .pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end}
        .search-bar{display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap}
        .search-input{flex:1;min-width:200px;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;transition:all .2s}
        .search-input:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
        .search-select{padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;transition:all .2s}
        .search-select:focus{border-color:#0ea5e9;background:white}
        .empty-state{text-align:center;padding:48px 20px;color:#94a3b8}
        .empty-state svg{width:48px;height:48px;margin:0 auto 12px;opacity:.3}
        .empty-state p{font-size:14px}
        .stats-mini{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px}
        .stat-mini{background:white;border-radius:14px;border:1px solid #e2e8f0;padding:14px;text-align:center}
        .stat-mini-num{font-size:22px;font-weight:700}
        .stat-mini-label{font-size:11px;color:#64748b;margin-top:2px}
        .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:49}
        .overlay.open{display:block}

        /* ── RESPONSIVE ── */
        @media(max-width:1200px){
          .stats-mini{grid-template-columns:repeat(3,1fr)}
          .grid3{grid-template-columns:1fr 1fr}
        }
        @media(max-width:900px){
          .grid2{grid-template-columns:1fr}
          .grid3{grid-template-columns:1fr}
          .stats-mini{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:768px){
          .hamburger{display:flex}
          .sidebar{transform:translateX(-100%)}
          .sidebar.open{transform:translateX(0)}
          .main{margin-left:0}
          .topbar{padding:12px 14px 12px 56px}
          .topbar-left h1{font-size:15px}
          .topbar-date{display:none}
          .content{padding:16px 12px}
          table thead{display:none}
          table tr{display:flex;flex-direction:column;padding:10px 14px;border-bottom:1px solid #e2e8f0}
          table td{padding:3px 0;border:none;font-size:12px}
          table td::before{content:attr(data-label);font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;display:block;margin-bottom:2px}
          .card-header{flex-direction:column;align-items:flex-start}
          .stats-mini{grid-template-columns:1fr 1fr}
        }
        @media(max-width:480px){
          .topbar-left p{display:none}
          .stats-mini{grid-template-columns:1fr 1fr}
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0369a1" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#0369a1" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <div>
                <span class="logo-name">Bahjawa Medical</span>
                <span class="logo-sub">Administration Panel</span>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Users
        </a>
        <a href="{{ route('admin.specialites.index') }}" class="nav-item {{ request()->routeIs('admin.specialites.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            Specialities
        </a>
        <a href="{{ route('admin.patients.index') }}" class="nav-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Patients
        </a>
        <a href="{{ route('admin.rendezvous.index') }}" class="nav-item {{ request()->routeIs('admin.rendezvous.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Appointments
        </a>
        <div class="nav-section">System</div>
        <a href="{{ route('admin.users.create') }}" class="nav-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Add User
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Administrator</div>
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
        <div class="topbar-left">
            <button class="hamburger" onclick="toggleSidebar()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <h1>@yield('title', 'Dashboard')</h1>
                <p>@yield('subtitle', '')</p>
            </div>
        </div>
        <div class="topbar-date">{{ now()->format('d/m/Y') }}</div>
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
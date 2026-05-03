<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Space — Bahjawa Medical</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#fffbeb;
  --white:#fff;
  --border:#e2e8f0;
  --text-primary:#0f172a;
  --text-secondary:#64748b;
  --text-muted:#94a3b8;
  --shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);
  --shadow-md:0 4px 24px rgba(0,0,0,.08);
  --radius:16px;
}
body{font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:var(--bg);min-height:100vh;display:flex;color:var(--text-primary)}

/* ── SIDEBAR ── */
.sidebar{width:240px;min-height:100vh;background:linear-gradient(180deg,#78350f,#b45309,#f59e0b);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50;transition:transform .3s ease}
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
.user-avatar{width:34px;height:34px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:#b45309;flex-shrink:0}
.user-name{font-size:13px;font-weight:600;color:white}
.user-role{font-size:10px;color:rgba(255,255,255,.55)}
.btn-logout{width:100%;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.85);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
.btn-logout:hover{background:rgba(239,68,68,.3);color:white}

/* ── MAIN ── */
.main{flex:1;margin-left:240px;min-height:100vh;display:flex;flex-direction:column;transition:margin-left .3s ease}
.topbar{background:var(--white);border-bottom:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;gap:12px}
.topbar-left{display:flex;align-items:center;gap:12px}
.topbar-title h1{font-size:17px;font-weight:700;color:var(--text-primary)}
.topbar-title p{font-size:11px;color:var(--text-muted);margin-top:1px}
.topbar-right{display:flex;align-items:center;gap:10px}
.topbar-date{font-size:12px;color:var(--text-secondary);background:var(--bg);padding:6px 12px;border-radius:8px;border:1px solid var(--border);white-space:nowrap}
.btn-book{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#b45309,#78350f);color:white;border:none;border-radius:10px;padding:9px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;white-space:nowrap}
.btn-book:hover{opacity:.9}
.hamburger{display:none;width:34px;height:34px;border-radius:9px;border:1px solid var(--border);background:var(--white);align-items:center;justify-content:center;cursor:pointer;color:var(--text-secondary);flex-shrink:0}

/* ── CONTENT ── */
.content{padding:22px 26px;flex:1}

/* ── STATS ── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
.stat-card{background:var(--white);border-radius:var(--radius);padding:18px;border:1px solid var(--border);box-shadow:var(--shadow);transition:transform .2s,box-shadow .2s;position:relative;overflow:hidden}
.stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-md)}
.stat-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px}
.stat-icon{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.stat-trend{font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px}
.trend-up{background:#f0fdf4;color:#16a34a}
.trend-same{background:#f8fafc;color:#64748b}
.stat-num{font-size:28px;font-weight:700;color:var(--text-primary);line-height:1;margin-bottom:4px}
.stat-label{font-size:12px;color:var(--text-secondary);font-weight:500}
.stat-badge{display:inline-flex;align-items:center;font-size:10px;font-weight:600;padding:3px 8px;border-radius:20px;margin-top:8px}
.stat-glow{position:absolute;top:-30px;right:-30px;width:100px;height:100px;border-radius:50%;opacity:.06}

/* ── MEDICAL RECORD ── */
.medical-card{background:var(--white);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);padding:20px;margin-bottom:20px}
.medical-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid #f1f5f9}
.medical-header h3{font-size:14px;font-weight:700;color:var(--text-primary)}
.medical-badge{font-size:10px;font-weight:600;padding:4px 10px;border-radius:20px;background:#fffbeb;color:#b45309}
.medical-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
.info-row{padding:10px 12px;border-bottom:1px solid #f8fafc;font-size:13px;display:flex;justify-content:space-between;align-items:center}
.info-row:last-child{border-bottom:none}
.info-lbl{color:var(--text-muted);font-size:12px}
.info-val{font-weight:600;color:var(--text-primary)}
.blood-badge{background:#fef2f2;color:#dc2626;font-weight:700;padding:3px 10px;border-radius:20px;font-size:12px}

/* ── TABLE ── */
.tcard{background:var(--white);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);overflow:hidden}
.tcard-header{padding:16px 18px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
.tcard-header h3{font-size:14px;font-weight:700;color:var(--text-primary)}
.tcard-header a{font-size:12px;color:#b45309;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px}
table{width:100%;border-collapse:collapse}
th{text-align:left;padding:10px 16px;font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;background:#f8fafc;border-bottom:1px solid var(--border)}
td{padding:12px 16px;font-size:13px;color:var(--text-primary);border-bottom:1px solid #f8fafc}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fffbeb}
.avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
.pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-flex;align-items:center;gap:5px}
.pill::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0}
.pg{background:#f0fdf4;color:#16a34a}.pg::before{background:#16a34a}
.pa{background:#fffbeb;color:#d97706}.pa::before{background:#d97706}
.pr{background:#fef2f2;color:#dc2626}.pr::before{background:#dc2626}
.pdf-btn{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:#b45309;background:#fffbeb;border:none;border-radius:8px;padding:4px 10px;cursor:pointer;text-decoration:none}
.pdf-btn:hover{background:#fef3c7}
.empty-state{text-align:center;padding:40px;color:var(--text-muted);font-size:13px}

/* ── OVERLAY ── */
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:49}
.overlay.open{display:block}

/* ── RESPONSIVE ── */
@media(max-width:1100px){
  .medical-grid{grid-template-columns:1fr}
}
@media(max-width:900px){
  .stats-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:768px){
  .hamburger{display:flex}
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main{margin-left:0}
  .topbar{padding:12px 14px 12px 56px}
  .topbar-title h1{font-size:15px}
  .topbar-date{display:none}
  .content{padding:14px 12px}
  table thead{display:none}
  table tr{display:flex;flex-direction:column;padding:10px 14px;border-bottom:1px solid var(--border)}
  table td{padding:3px 0;border:none;font-size:12px}
  table td::before{content:attr(data-label);font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;display:block;margin-bottom:2px}
}
@media(max-width:480px){
  .stats-grid{grid-template-columns:1fr}
  .stat-num{font-size:24px}
  .stat-card{padding:14px}
  .btn-book span{display:none}
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
        <svg width="24" height="24" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#fffbeb" stroke="#b45309" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#b45309" stroke-width="2.5" stroke-linecap="round"/></svg>
      </div>
      <div>
        <span class="logo-name">Bahjawa Medical</span>
        <span class="logo-sub">Patient Space</span>
      </div>
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
      <div class="user-row">
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

<!-- MAIN -->
<div class="main" id="main">
  <div class="topbar">
    <div class="topbar-left">
      <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <div class="topbar-title">
        <h1>Hello, {{ auth()->user()->name }}</h1>
        <p>{{ now()->format('l d F Y') }}</p>
      </div>
    </div>
    <div class="topbar-right">
      <div class="topbar-date">{{ now()->format('d/m/Y') }}</div>
      <a href="{{ route('patient.rendezvous.create') }}" class="btn-book">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <span>Book Appointment</span>
      </a>
    </div>
  </div>

  <div class="content">

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-glow" style="background:#b45309"></div>
        <div class="stat-top">
          <div class="stat-icon" style="background:#fffbeb">
            <svg width="20" height="20" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          </div>
          <span class="stat-trend trend-same">Total</span>
        </div>
        <div class="stat-num">{{ $rdvs->count() }}</div>
        <div class="stat-label">Total Appointments</div>
        <span class="stat-badge" style="background:#fffbeb;color:#b45309">All time</span>
      </div>

      <div class="stat-card">
        <div class="stat-glow" style="background:#059669"></div>
        <div class="stat-top">
          <div class="stat-icon" style="background:#f0fdf4">
            <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <span class="stat-trend trend-up">Confirmed</span>
        </div>
        <div class="stat-num">{{ $rdvs->where('Status','Confirmed')->count() }}</div>
        <div class="stat-label">Confirmed</div>
        <span class="stat-badge" style="background:#f0fdf4;color:#059669">Confirmed</span>
      </div>

      <div class="stat-card">
        <div class="stat-glow" style="background:#d97706"></div>
        <div class="stat-top">
          <div class="stat-icon" style="background:#fffbeb">
            <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <span class="stat-trend trend-same">Pending</span>
        </div>
        <div class="stat-num">{{ $rdvs->where('Status','en_attente')->count() }}</div>
        <div class="stat-label">Pending</div>
        <span class="stat-badge" style="background:#fffbeb;color:#d97706">Pending</span>
      </div>
    </div>

    <!-- MEDICAL RECORD -->
    @if(auth()->user()->patient)
    <div class="medical-card">
      <div class="medical-header">
        <h3>My Medical Record</h3>
        <span class="medical-badge">Personal Info</span>
      </div>
      <div class="medical-grid">
        <div class="info-row">
          <span class="info-lbl">Blood Type</span>
          <span class="blood-badge">{{ auth()->user()->patient->blood_type ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-lbl">Gender</span>
          <span class="info-val">{{ auth()->user()->patient->gender === 'M' ? 'Male' : (auth()->user()->patient->gender === 'F' ? 'Female' : '-') }}</span>
        </div>
        <div class="info-row">
          <span class="info-lbl">Allergies</span>
          <span class="info-val">{{ auth()->user()->patient->Allergies ?? 'None' }}</span>
        </div>
        <div class="info-row">
          <span class="info-lbl">Conditions</span>
          <span class="info-val">{{ auth()->user()->patient->medical_Conditions ?? 'None' }}</span>
        </div>
      </div>
    </div>
    @endif

    <!-- TABLE -->
    <div class="tcard">
      <div class="tcard-header">
        <h3>My Appointments</h3>
        <a href="{{ route('patient.rendezvous.index') }}">
          View all
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
      <table>
        <thead>
          <tr><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th>Ordonnance</th></tr>
        </thead>
        <tbody>
          @forelse($rdvs as $rdv)
          <tr>
            <td data-label="Doctor">
              <div style="display:flex;align-items:center;gap:8px">
                <div class="avatar" style="background:#f0fdf4;color:#059669">
                  {{ strtoupper(substr($rdv->Doctor->user->name ?? '?', 0, 2)) }}
                </div>
                <div>
                  <div style="font-weight:500;font-size:13px">{{ $rdv->Doctor->user->name ?? '-' }}</div>
                  <div style="font-size:11px;color:#94a3b8">{{ $rdv->Doctor->specialite->nom ?? '' }}</div>
                </div>
              </div>
            </td>
            <td data-label="Date" style="color:#64748b">
              {{ \Carbon\Carbon::parse($rdv->Date_rdv)->format('d/m/Y') }}
            </td>
            <td data-label="Time" style="font-weight:600;color:#b45309">
              {{ substr($rdv->Time_rdv, 0, 5) }}
            </td>
            <td data-label="Status">
              @if($rdv->Status === 'Confirmed')
                <span class="pill pg">Confirmed</span>
              @elseif($rdv->Status === 'en_attente')
                <span class="pill pa">Pending</span>
              @else
                <span class="pill pr">Cancelled</span>
              @endif
            </td>
            <td data-label="Ordonnance">
              @if($rdv->consultation && $rdv->consultation->ordonnance)
                <a href="{{ route('patient.ordonnances.pdf', $rdv->consultation->ordonnance->id) }}" class="pdf-btn">
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                  PDF
                </a>
              @else
                <span style="font-size:12px;color:#94a3b8">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                No appointments found.
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

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

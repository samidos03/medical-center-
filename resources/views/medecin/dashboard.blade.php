<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Space - Bahjawa Medical Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
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
        .btn-logout{width:100%;margin-top:8px;padding:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:10px;color:rgba(255,255,255,.8);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-logout:hover{background:rgba(239,68,68,.3);color:white}
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .topbar h1{font-size:18px;font-weight:700;color:#0f172a}
        .topbar p{font-size:12px;color:#94a3b8;margin-top:2px}
        .content{padding:24px 28px;flex:1}
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:white;border-radius:18px;padding:20px;border:1px solid #e2e8f0;transition:transform .2s}
        .stat-card:hover{transform:translateY(-2px)}
        .stat-icon{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
        .stat-num{font-size:30px;font-weight:700;color:#0f172a;line-height:1}
        .stat-label{font-size:13px;color:#64748b;margin-top:4px}
        .stat-badge{display:inline-block;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;margin-top:10px}
        .charts-row{display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px}
        .chart-card{background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0}
        .chart-card h3{font-size:15px;font-weight:700;color:#0f172a;margin-bottom:2px}
        .chart-sub{font-size:12px;color:#94a3b8;margin-bottom:18px}
        .tables-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .tcard{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
        .tcard-header{padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
        .tcard-header h3{font-size:15px;font-weight:700;color:#0f172a}
        .tcard-header a{font-size:12px;color:#059669;text-decoration:none;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc}
        td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#f8fafc}
        .avatar{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#059669,#065f46);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
        .rdv-item{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid #f8fafc;transition:background .15s}
        .rdv-item:last-child{border-bottom:none}
        .rdv-item:hover{background:#f8fafc}
        .rdv-time{font-size:13px;font-weight:700;color:#059669;background:#f0fdf4;padding:4px 10px;border-radius:8px;flex-shrink:0;min-width:50px;text-align:center}
        .rdv-name{font-size:13px;font-weight:600;color:#0f172a}
        .rdv-info{font-size:11px;color:#94a3b8}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#dcfce7" stroke="#059669" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <div>
                <span class="logo-name">Bahjawa Medical</span>
                <span class="logo-sub">Doctor Space</span>
            </div>
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
                    <div class="user-role">{{ auth()->user()->medecin?->Speciality?->nom ?? 'Medecin' }}</div>
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
            <h1>Hello, {{ auth()->user()->name }}</h1>
            <p>{{ now()->format('l d F Y') }} — Bahjawa Medical Center</p>
        </div>
        <a href="{{ route('medecin.consultations.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Consultation
        </a>
    </div>

    <div class="content">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4">
                    <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#dcfce7" stroke="#059669" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/></svg>
                </div>
                <div class="stat-num">{{ $stats['rdv_today'] ?? 0 }}</div>
                <div class="stat-label">Today's Appointments</div>
                <span class="stat-badge" style="background:#f0fdf4;color:#059669">Aujourd hui</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff">
                    <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#dcfce7" stroke="#059669" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/></svg>
                </div>
                <div class="stat-num">{{ $stats['patients'] ?? 0 }}</div>
                <div class="stat-label">My Patients</div>
                <span class="stat-badge" style="background:#eff6ff;color:#0369a1">Total</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#faf5ff">
                    <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#dcfce7" stroke="#059669" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/></svg>
                </div>
                <div class="stat-num">{{ $stats['Consultations'] ?? 0 }}</div>
                <div class="stat-label">Consultations</div>
                <span class="stat-badge" style="background:#faf5ff;color:#7c3aed">Total</span>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h3>Mes Appointments par mois</h3>
                <p class="chart-sub">Annee {{ date('Y') }}</p>
                <canvas id="rdvChart" height="80"></canvas>
            </div>
            <div class="chart-card">
                <h3>Statuts RDV</h3>
                <p class="chart-sub">Total : {{ $stats['rdv_total'] ?? 0 }}</p>
                <canvas id="statutChart" height="160"></canvas>
                <div style="margin-top:14px;display:flex;flex-direction:column;gap:8px">
                    <div style="display:flex;justify-content:space-between;font-size:13px">
                        <div style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:50%;background:#22c55e;display:inline-block"></span>Confirmes</div>
                        <span style="font-weight:700">{{ $stats['confirmes'] ?? 0 }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px">
                        <div style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block"></span>Pending</div>
                        <span style="font-weight:700">{{ $stats['en_attente'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tables-row">
            <div class="tcard">
                <div class="tcard-header">
                    <h3>Today's Appointments</h3>
                    <span style="font-size:12px;color:#94a3b8">{{ now()->format('d/m/Y') }}</span>
                </div>
                @forelse($rdvs as $rdv)
                <div class="rdv-item">
                    <div class="rdv-time">{{ substr($rdv->heure_rdv,0,5) }}</div>
                    <div class="avatar" style="background:#eff6ff;color:#0369a1">{{ strtoupper(substr($rdv->patient->user->name??'?',0,2)) }}</div>
                    <div style="flex:1">
                        <div class="rdv-name">{{ $rdv->patient->user->name ?? '-' }}</div>
                        <div class="rdv-info">{{ $rdv->patient->user->email ?? '' }}</div>
                    </div>
                    @if($rdv->statut==='Confirmed') <span class="pill pg">Confirmed</span>
                    @elseif($rdv->statut==='en_attente') <span class="pill pa">Pending</span>
                    @else <span class="pill pr">Cancelled</span> @endif
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:#94a3b8;font-size:13px">No appointments aujourd hui.</div>
                @endforelse
            </div>
            <div class="tcard">
                <div class="tcard-header">
                    <h3>Upcoming Appointments</h3>
                    <a href="{{ route('medecin.consultations.create') }}">+ Consultation</a>
                </div>
                @forelse($prochains as $rdv)
                <div class="rdv-item">
                    <div style="flex-shrink:0;text-align:center;min-width:44px">
                        <div style="font-size:16px;font-weight:700;color:#059669">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d') }}</div>
                        <div style="font-size:10px;color:#94a3b8;text-transform:uppercase">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('M') }}</div>
                    </div>
                    <div class="avatar" style="background:#f0fdf4;color:#059669">{{ strtoupper(substr($rdv->patient->user->name??'?',0,2)) }}</div>
                    <div style="flex:1">
                        <div class="rdv-name">{{ $rdv->patient->user->name ?? '-' }}</div>
                        <div class="rdv-info">{{ substr($rdv->heure_rdv,0,5) }}</div>
                    </div>
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:#94a3b8;font-size:13px">Aucun prochain RDV.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
const mois=['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'];
new Chart(document.getElementById('rdvChart'),{
    type:'bar',
    data:{
        labels:mois,
        datasets:[{
            label:'RDV',
            data:@json($rdvMoisData),
            backgroundColor:'rgba(5,150,105,0.12)',
            borderColor:'rgba(5,150,105,0.8)',
            borderWidth:2,
            borderRadius:8
        }]
    },
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'rgba(0,0,0,0.04)'}},x:{grid:{display:false}}}}
});
new Chart(document.getElementById('statutChart'),{
    type:'doughnut',
    data:{
        labels:['Confirmes','Pending','Annules'],
        datasets:[{data:[{{ $stats['confirmes']??0 }},{{ $stats['en_attente']??0 }},0],backgroundColor:['#22c55e','#f59e0b','#ef4444'],borderWidth:0}]
    },
    options:{responsive:true,plugins:{legend:{display:false}},cutout:'72%'}
});
</script>
</body>
</html>













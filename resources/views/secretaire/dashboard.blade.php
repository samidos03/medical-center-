<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretary Space</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#FBEAF0;min-height:100vh;display:flex}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#4a1528,#993556,#D4537E);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:50}
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
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:white;border-radius:18px;padding:20px;border:1px solid #e2e8f0;transition:transform .2s;overflow:hidden;position:relative}
        .stat-card:hover{transform:translateY(-2px)}
        .stat-icon{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
        .stat-num{font-size:30px;font-weight:700;color:#0f172a;line-height:1}
        .stat-label{font-size:13px;color:#64748b;margin-top:4px}
        .stat-badge{display:inline-block;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;margin-top:10px}
        .charts-row{display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px}
        .chart-card{background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0}
        .chart-card h3{font-size:15px;font-weight:700;color:#0f172a;margin-bottom:2px}
        .chart-sub{font-size:12px;color:#94a3b8;margin-bottom:18px}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px}
        .card-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
        .card-header h3{font-size:15px;font-weight:700;color:#0f172a}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
        td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#FBEAF0}
        .avatar{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .donut-legend{display:flex;flex-direction:column;gap:10px;margin-top:16px}
        .legend-row{display:flex;justify-content:space-between;align-items:center;font-size:13px}
        .legend-dot{width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:8px}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-inner">
            <div class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#fdf2f8" stroke="#993556" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#993556" stroke-width="2.5" stroke-linecap="round"/></svg>
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
            <h1>Hello, {{ auth()->user()->name }}</h1>
            <p>{{ now()->format('l d F Y') }}</p>
        </div>
        <div style="font-size:13px;color:#64748b;background:#f8fafc;padding:6px 14px;border-radius:10px;border:1px solid #e2e8f0">
            {{ now()->format('d/m/Y') }}
        </div>
    </div>
    <div class="content">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#FBEAF0">
                    <svg width="22" height="22" fill="none" stroke="#993556" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="stat-num">{{ $stats['rdv_today'] }}</div>
                <div class="stat-label">Appointments Today</div>
                <span class="stat-badge" style="background:#FBEAF0;color:#993556">Today</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff">
                    <svg width="22" height="22" fill="none" stroke="#0369a1" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="stat-num">{{ $stats['total_patients'] }}</div>
                <div class="stat-label">Total Patients</div>
                <span class="stat-badge" style="background:#eff6ff;color:#0369a1">Registered</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4">
                    <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="stat-num">{{ $stats['rdv_confirmes'] }}</div>
                <div class="stat-label">Confirmed Appts</div>
                <span class="stat-badge" style="background:#f0fdf4;color:#059669">Confirmed</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffbeb">
                    <svg width="22" height="22" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="stat-num">{{ $stats['rdv_attente'] }}</div>
                <div class="stat-label">Pending</div>
                <span class="stat-badge" style="background:#fffbeb;color:#d97706">Pending</span>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h3>Appointments per Month</h3>
                <p class="chart-sub">Year {{ date('Y') }}</p>
                <canvas id="rdvChart" height="80"></canvas>
            </div>
            <div class="chart-card">
                <h3>Appointment Status</h3>
                <p class="chart-sub">Total: {{ $stats['rdv_total'] }}</p>
                <canvas id="StatusChart" height="160"></canvas>
                <div class="donut-legend">
                    <div class="legend-row">
                        <div><span class="legend-dot" style="background:#22c55e"></span>Confirmed</div>
                        <span style="font-weight:700">{{ $stats['rdv_confirmes'] }}</span>
                    </div>
                    <div class="legend-row">
                        <div><span class="legend-dot" style="background:#f59e0b"></span>Pending</div>
                        <span style="font-weight:700">{{ $stats['rdv_attente'] }}</span>
                    </div>
                    <div class="legend-row">
                        <div><span class="legend-dot" style="background:#ef4444"></span>Cancelled</div>
                        <span style="font-weight:700">{{ $stats['rdv_annules'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Today's Appointments  -  {{ now()->format('d/m/Y') }}</h3>
            </div>
            <table>
                <thead><tr><th>Patient</th><th>Doctor</th><th>Time</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($rdvToday as $rdv)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div class="avatar" style="background:#FBEAF0;color:#993556">{{ strtoupper(substr($rdv->Patient->user->name??'?',0,2)) }}</div>
                                <span style="font-weight:500">{{ $rdv->Patient->user->name??'-' }}</span>
                            </div>
                        </td>
                        <td style="color:#64748b">{{ $rdv->Doctor->user->name??'-' }}</td>
                        <td style="font-weight:600;color:#993556">{{ substr($rdv->Time_rdv,0,5) }}</td>
                        <td>
                            @if($rdv->Status==='Confirmed')<span class="pill pg">Confirmed</span>
                            @elseif($rdv->Status==='en_attente')<span class="pill pa">Pending</span>
                            @else<span class="pill pr">Cancelled</span>@endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:32px">No appointments today.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-header"><h3>Upcoming Appointments</h3></div>
            <table>
                <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($prochains as $rdv)
                    <tr>
                        <td style="font-weight:500">{{ $rdv->Patient->user->name??'-' }}</td>
                        <td style="color:#64748b">{{ $rdv->Doctor->user->name??'-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($rdv->Date_rdv)->format('d/m/Y') }}</td>
                        <td style="color:#993556;font-weight:600">{{ substr($rdv->Time_rdv,0,5) }}</td>
                        <td>
                            @if($rdv->Status==='Confirmed')<span class="pill pg">Confirmed</span>
                            @elseif($rdv->Status==='en_attente')<span class="pill pa">Pending</span>
                            @else<span class="pill pr">Cancelled</span>@endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:32px">No upcoming appointments.</td></tr>
                    @endforelse
                </tbody>
            </table>
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
            backgroundColor:'rgba(194,65,12,0.12)',
            borderColor:'rgba(194,65,12,0.8)',
            borderWidth:2,
            borderRadius:8
        }]
    },
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'rgba(0,0,0,0.04)'}},x:{grid:{display:false}}}}
});
new Chart(document.getElementById('StatusChart'),{
    type:'doughnut',
    data:{
        labels:['Confirmed','Pending','Cancelled'],
        datasets:[{
            data:[{{ $stats['rdv_confirmes'] }},{{ $stats['rdv_attente'] }},{{ $stats['rdv_annules'] }}],
            backgroundColor:['#22c55e','#f59e0b','#ef4444'],
            borderWidth:0
        }]
    },
    options:{responsive:true,plugins:{legend:{display:false}},cutout:'72%'}
});
</script>
</body>
</html>




















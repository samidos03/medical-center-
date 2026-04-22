<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Bahjawa Medical</title>
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
        .calendar-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:1px;background:#e2e8f0;border-radius:16px;overflow:hidden;margin-bottom:24px}
        .cal-header{background:#059669;color:white;text-align:center;padding:10px 4px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
        .cal-day{background:white;min-height:90px;padding:8px;position:relative;transition:background .15s}
        .cal-day:hover{background:#f0fdf4}
        .cal-day.today{background:#f0fdf4;border:2px solid #059669}
        .cal-day.other-month{background:#f8fafc}
        .cal-day.other-month .day-num{color:#cbd5e1}
        .day-num{font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px}
        .day-num.today-num{width:26px;height:26px;background:#059669;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px}
        .rdv-pill{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:2px 6px;font-size:10px;color:#059669;font-weight:600;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;cursor:pointer}
        .rdv-pill.en-attente{background:#fffbeb;border-color:#fde68a;color:#d97706}
        .rdv-pill.annule{background:#fef2f2;border-color:#fecaca;color:#dc2626}
        .more-rdv{font-size:10px;color:#94a3b8;padding:2px 4px}
        .legend{display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap}
        .legend-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#64748b}
        .legend-dot{width:10px;height:10px;border-radius:3px}
        .month-nav{display:flex;align-items:center;gap:12px}
        .month-btn{padding:8px 16px;border:1.5px solid #e2e8f0;border-radius:10px;background:white;font-size:13px;font-weight:600;cursor:pointer;color:#374151;transition:all .2s;text-decoration:none}
        .month-btn:hover{border-color:#059669;color:#059669}
        .month-title{font-size:16px;font-weight:700;color:#0f172a;min-width:160px;text-align:center}
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
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <h1>My Agenda</h1>
            <p>{{ now()->locale('fr')->isoFormat('MMMM YYYY') }}</p>
        </div>
        <a href="{{ route('medecin.consultations.create') }}" style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#059669,#065f46);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;text-decoration:none">
            + New Consultation
        </a>
    </div>
    <div class="content">
        <div class="legend">
            <div class="legend-item"><div class="legend-dot" style="background:#bbf7d0"></div>Confirmed</div>
            <div class="legend-item"><div class="legend-dot" style="background:#fde68a"></div>Pending</div>
            <div class="legend-item"><div class="legend-dot" style="background:#fecaca"></div>Cancelled</div>
        </div>

        @php
            $debut = now()->startOfMonth();
            $fin = now()->endOfMonth();
            $premierJour = $debut->dayOfWeek === 0 ? 6 : $debut->dayOfWeek - 1;
            $today = now()->format('Y-m-d');
        @endphp

        <div class="calendar-grid">
            @foreach(['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'] as $j)
                <div class="cal-header">{{ $j }}</div>
            @endforeach

            @for($i = 0; $i < $premierJour; $i++)
                <div class="cal-day other-month"></div>
            @endfor

            @for($d = 1; $d <= $fin->day; $d++)
                @php
                    $date = now()->startOfMonth()->addDays($d-1)->format('Y-m-d');
                    $dayRdvs = $rdvs->get($date, collect());
                    $isToday = $date === $today;
                @endphp
                <div class="cal-day {{ $isToday ? 'today' : '' }}">
                    <div class="day-num {{ $isToday ? 'today-num' : '' }}">{{ $d }}</div>
                    @foreach($dayRdvs->take(2) as $rdv)
                        <div class="rdv-pill {{ $rdv->statut === 'en_attente' ? 'en-attente' : ($rdv->statut === 'Cancelled' ? 'Cancelled' : '') }}" title="{{ $rdv->patient->user->name }} - {{ substr($rdv->heure_rdv,0,5) }}">
                            {{ substr($rdv->heure_rdv,0,5) }} {{ Str::limit($rdv->patient->user->name,10) }}
                        </div>
                    @endforeach
                    @if($dayRdvs->count() > 2)
                        <div class="more-rdv">+{{ $dayRdvs->count() - 2 }} autres</div>
                    @endif
                </div>
            @endfor

            @php $reste = (7 - ($premierJour + $fin->day) % 7) % 7; @endphp
            @for($i = 0; $i < $reste; $i++)
                <div class="cal-day other-month"></div>
            @endfor
        </div>

        @if($rdvs->isNotEmpty())
        <div style="background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden">
            <div style="padding:18px 20px;border-bottom:1px solid #f1f5f9;font-size:15px;font-weight:700;color:#0f172a">
                RDV ce mois  -  {{ $rdvs->flatten()->count() }} au total
            </div>
            <table style="width:100%;border-collapse:collapse">
                <thead><tr>
                    <th style="text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc">Date</th>
                    <th style="text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc">Time</th>
                    <th style="text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc">Patient</th>
                    <th style="text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc">Status</th>
                </tr></thead>
                <tbody>
                    @foreach($rdvs as $date => $dayRdvs)
                        @foreach($dayRdvs as $rdv)
                        <tr style="border-bottom:1px solid #f8fafc">
                            <td style="padding:12px 16px;font-size:13px;color:#334155">{{ \Carbon\Carbon::parse($date)->format('D d M') }}</td>
                            <td style="padding:12px 16px;font-size:13px;font-weight:600;color:#059669">{{ substr($rdv->heure_rdv,0,5) }}</td>
                            <td style="padding:12px 16px;font-size:13px;font-weight:500;color:#0f172a">{{ $rdv->patient->user->name }}</td>
                            <td style="padding:12px 16px">
                                @if($rdv->statut==='Confirmed')<span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#f0fdf4;color:#16a34a">Confirmed</span>
                                @elseif($rdv->statut==='en_attente')<span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#fffbeb;color:#d97706">Pending</span>
                                @else<span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#fef2f2;color:#dc2626">Cancelled</span>@endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
</body>
</html>











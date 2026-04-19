<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record - Bahjawa Medical</title>
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
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:22px;margin-bottom:16px}
        .card-full{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
        .card-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
        .card-header h3{font-size:15px;font-weight:700;color:#0f172a}
        .section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .info-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:13px;padding-bottom:10px;border-bottom:1px solid #f8fafc}
        .info-row:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0}
        .info-lbl{color:#64748b}
        .info-val{font-weight:600;color:#0f172a;text-align:right;max-width:60%}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
        td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#fdf2f8}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#993556,#4B1528);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
        .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:13px;font-weight:600;text-decoration:none}
        .back{display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:13px;text-decoration:none;margin-bottom:20px}
        .patient-hero{background:linear-gradient(135deg,#4B1528,#993556);border-radius:18px;padding:24px;margin-bottom:20px;display:flex;align-items:center;gap:20px}
        .patient-hero-avatar{width:64px;height:64px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:22px;color:white;flex-shrink:0;border:2px solid rgba(255,255,255,.3)}
        .patient-hero-name{font-size:22px;font-weight:700;color:white}
        .patient-hero-email{font-size:13px;color:rgba(255,255,255,.7);margin-top:4px}
        .patient-hero-badges{display:flex;gap:8px;margin-top:10px;flex-wrap:wrap}
        .hero-badge{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);border-radius:20px;padding:4px 12px;font-size:12px;color:white;font-weight:600}
        .stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
        .stat-mini{background:white;border-radius:14px;border:1px solid #e2e8f0;padding:16px;text-align:center}
        .stat-num{font-size:24px;font-weight:700}
        .stat-lbl{font-size:12px;color:#64748b;margin-top:3px}
        .empty{text-align:center;color:#94a3b8;padding:32px;font-size:13px}
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
        <a href="{{ route('secretaire.dashboard') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('secretaire.patients.index') }}" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Patients
        </a>
        <a href="{{ route('secretaire.rendezvous.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Appointments
        </a>
        <a href="{{ route('secretaire.medecins.disponibilites') }}" class="nav-item">
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
            <h1>Patient Record</h1>
            <p>Complete medical file</p>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('secretaire.patients.edit', $patient) }}" class="btn-primary">Edit Patient</a>
            <a href="{{ route('secretaire.patients.index') }}" class="btn-secondary">Back to List</a>
        </div>
    </div>
    <div class="content">

        {{-- Hero --}}
        <div class="patient-hero">
            <div class="patient-hero-avatar">{{ strtoupper(substr($patient->user->name,0,2)) }}</div>
            <div>
                <div class="patient-hero-name">{{ $patient->user->name }}</div>
                <div class="patient-hero-email">{{ $patient->user->email }}</div>
                <div class="patient-hero-badges">
                    @if($patient->blood_type)<span class="hero-badge">Blood: {{ $patient->blood_type }}</span>@endif
                    @if($patient->gender)<span class="hero-badge">{{ $patient->gender==='M'?'Male':'Female' }}</span>@endif
                    @if($patient->birth_date)<span class="hero-badge">Age: {{ $patient->birth_date->age }} years</span>@endif
                    <span class="hero-badge" style="background:{{ $patient->user->actif ? 'rgba(34,197,94,.3)' : 'rgba(239,68,68,.3)' }}">
                        {{ $patient->user->actif ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-mini">
                <div class="stat-num" style="color:#993556">{{ $patient->rendezvous->count() }}</div>
                <div class="stat-lbl">Total Appointments</div>
            </div>
            <div class="stat-mini">
                <div class="stat-num" style="color:#16a34a">{{ $patient->rendezvous->where('statut','Confirmed')->count() }}</div>
                <div class="stat-lbl">Confirmed</div>
            </div>
            <div class="stat-mini">
                <div class="stat-num" style="color:#d97706">{{ $patient->rendezvous->where('statut','en_attente')->count() }}</div>
                <div class="stat-lbl">Pending</div>
            </div>
        </div>

        {{-- Info cards --}}
        <div class="grid2">
            <div class="card">
                <div class="section">Personal Information</div>
                <div class="info-row"><span class="info-lbl">Full Name</span><span class="info-val">{{ $patient->user->name }}</span></div>
                <div class="info-row"><span class="info-lbl">Email</span><span class="info-val" style="font-size:12px">{{ $patient->user->email }}</span></div>
                <div class="info-row"><span class="info-lbl">Phone</span><span class="info-val">{{ $patient->user->phone??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Address</span><span class="info-val">{{ $patient->user->address??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Birth Date</span><span class="info-val">{{ $patient->birth_date?->format('d/m/Y')??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Gender</span><span class="info-val">{{ $patient->gender==='M'?'Male':($patient->gender==='F'?'Female':' - ') }}</span></div>
            </div>
            <div class="card">
                <div class="section">Medical Information</div>
                <div class="info-row"><span class="info-lbl">Blood Type</span><span class="info-val" style="color:#dc2626">{{ $patient->blood_type??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Allergies</span><span class="info-val">{{ $patient->Allergies??'None' }}</span></div>
                <div class="info-row"><span class="info-lbl">Medical Conditions</span><span class="info-val">{{ $patient->medical_Conditions??'None' }}</span></div>
                <div class="info-row"><span class="info-lbl">Emergency Contact</span><span class="info-val">{{ $patient->emergency_contact??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Emergency Phone</span><span class="info-val">{{ $patient->emergency_phone??' - ' }}</span></div>
                <div class="info-row"><span class="info-lbl">Account Status</span>
                    <span class="info-val">
                        @if($patient->user->actif)<span class="pill pg">Active</span>
                        @else<span class="pill pr">Inactive</span>@endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Appointments history --}}
        <div class="card-full">
            <div class="card-header">
                <h3>Appointment History</h3>
                <a href="{{ route('secretaire.rendezvous.create') }}" class="btn-primary" style="font-size:12px;padding:7px 14px">+ New Appointment</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Speciality</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Consultation</th>
                        <th>Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patient->rendezvous->sortByDesc('date_rdv') as $rdv)
                    <tr>
                        <td style="font-weight:500">{{ $rdv->medecin->user->name??' - ' }}</td>
                        <td style="color:#64748b">{{ $rdv->medecin->specialite->nom??' - ' }}</td>
                        <td>{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                        <td style="font-weight:600;color:#993556">{{ substr($rdv->heure_rdv,0,5) }}</td>
                        <td>
                            @if($rdv->statut==='Confirmed')<span class="pill pg">Confirmed</span>
                            @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
                            @else<span class="pill pr">Cancelled</span>@endif
                        </td>
                        <td>
                            @if($rdv->consultation)<span class="pill pg">Done</span>
                            @else<span style="color:#94a3b8"> - </span>@endif
                        </td>
                        <td>
                            @if($rdv->consultation?->Prescription)
                                <span class="pill pg">Available</span>
                            @else
                                <span style="color:#94a3b8"> - </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="empty">No appointments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>




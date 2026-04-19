<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment - Bahjawa Medical</title>
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
        .main{flex:1;margin-left:260px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:white;border-bottom:1px solid #e2e8f0;padding:16px 28px}
        .topbar h1{font-size:18px;font-weight:700;color:#0f172a}
        .content{padding:24px 28px;flex:1;max-width:680px}
        .form-card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px;margin-bottom:16px}
        .form-section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .field{margin-bottom:14px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
        .field select,.field input{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field select:focus,.field input:focus{border-color:#993556;background:white;box-shadow:0 0 0 3px rgba(153,53,86,.1)}
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#993556,#4B1528);color:white;border:none;border-radius:10px;padding:12px 24px;font-size:14px;font-weight:600;cursor:pointer}
        .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:12px 24px;font-size:14px;font-weight:600;text-decoration:none}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;color:#dc2626;font-size:13px;margin-bottom:16px}
        .back{display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:13px;text-decoration:none;margin-bottom:20px}
        .slots-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:8px}
        .slot{padding:8px;border:1.5px solid #e2e8f0;border-radius:8px;text-align:center;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;background:white}
        .slot.available:hover{border-color:#993556;background:#fdf2f8;color:#993556}
        .slot.taken{background:#f8fafc;color:#cbd5e1;cursor:not-allowed;border-color:#f1f5f9}
        .slot.selected{border-color:#993556;background:#993556;color:white}
        .no-slots{text-align:center;color:#94a3b8;font-size:13px;padding:16px;background:#f8fafc;border-radius:10px}
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
        <h1>New Appointment</h1>
    </div>
    <div class="content">
        <a href="{{ route('secretaire.rendezvous.index') }}" class="back">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div> -  {{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ route('secretaire.rendezvous.store') }}">
            @csrf
            <div class="form-card">
                <div class="form-section">Appointment Details</div>
                <div class="field">
                    <label>Patient</label>
                    <select name="patient_id" required>
                        <option value="">Select patient...</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" @selected(old('patient_id')==$p->id)>{{ $p->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid2">
                    <div class="field">
                        <label>Doctor</label>
                        <select name="medecin_id" id="medecin_id" required onchange="loadSlots()">
                            <option value="">Select doctor...</option>
                            @foreach($medecins as $m)
                                <option value="{{ $m->id }}" @selected(old('medecin_id')==$m->id)>
                                    {{ $m->user->name }}  -  {{ $m->specialite->nom??'General' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Date</label>
                        <input type="date" id="date_rdv_input" min="{{ date('Y-m-d') }}" onchange="loadSlots()">
                    </div>
                </div>
                <div class="field">
                    <label>Available Time Slots</label>
                    <input type="hidden" name="date_rdv" id="date_rdv">
                    <input type="hidden" name="heure_rdv" id="heure_rdv">
                    <div id="slots-container"><div class="no-slots">Select a doctor and date to see available slots.</div></div>
                </div>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-primary">Schedule Appointment</button>
                <a href="{{ route('secretaire.rendezvous.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
function loadSlots() {
    const medecin = document.getElementById('medecin_id').value;
    const date = document.getElementById('date_rdv_input').value;
    if (!medecin || !date) return;
    document.getElementById('date_rdv').value = date;
    document.getElementById('slots-container').innerHTML = '<div class="no-slots">Loading...</div>';
    fetch(`{{ route('secretaire.disponibilites.medecin') }}?medecin_id=${medecin}&date=${date}`)
        .then(r => r.json())
        .then(slots => {
            if (!slots.length) {
                document.getElementById('slots-container').innerHTML = '<div class="no-slots">No available slots for this doctor on this day.</div>';
                return;
            }
            let html = '<div class="slots-grid">';
            slots.forEach(s => {
                if (s.available) {
                    html += `<div class="slot available" onclick="selectSlot('${s.time}',this)">${s.time}</div>`;
                } else {
                    html += `<div class="slot taken">${s.time} ?</div>`;
                }
            });
            html += '</div>';
            document.getElementById('slots-container').innerHTML = html;
        });
}
function selectSlot(time, el) {
    document.querySelectorAll('.slot').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('heure_rdv').value = time;
}
</script>
</body>
</html>







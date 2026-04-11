<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($patient) ? 'Edit' : 'Add' }} Patient - Bahjawa Medical</title>
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
    .card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px}
    .card-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
    .card-header h2{font-size:15px;font-weight:700;color:#0f172a}
    .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#993556,#4B1528);color:white;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
    .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:13px;font-weight:600;text-decoration:none}
    .btn-danger{display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:10px;padding:7px 12px;font-size:12px;font-weight:600;cursor:pointer;text-decoration:none}
    table{width:100%;border-collapse:collapse}
    th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
    td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#fdf2f8}
    .avatar{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
    .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
    .pg{background:#f0fdf4;color:#16a34a}
    .pa{background:#fffbeb;color:#d97706}
    .pr{background:#fef2f2;color:#dc2626}
    .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:13px;margin-bottom:20px}
    .alert-error{background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;color:#dc2626;font-size:13px;margin-bottom:20px}
    .field{margin-bottom:14px}
    .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
    .field input,.field select,.field textarea{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:#993556;background:white;box-shadow:0 0 0 3px rgba(153,53,86,.1)}
    .field .err{color:#dc2626;font-size:12px;margin-top:4px}
    .form-card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px;margin-bottom:16px}
    .form-section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
    .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
    .search-input{padding:10px 16px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;background:#f8fafc;width:100%;max-width:300px}
    .search-input:focus{border-color:#993556;background:white}
    .pagination-wrap{padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end}
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
        <div>
            <h1>{{ isset($patient) ? 'Edit Patient' : 'Add Patient' }}</h1>
            <p>{{ isset($patient) ? $patient->user->name : 'New patient registration' }}</p>
        </div>
    </div>
    <div class="content" style="max-width:700px">
        <a href="{{ route('secretaire.patients.index') }}" class="btn-secondary" style="margin-bottom:20px;display:inline-flex">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ isset($patient) ? route('secretaire.patients.update', $patient) : route('secretaire.patients.store') }}">
            @csrf
            @if(isset($patient)) @method('PUT') @endif
            <div class="form-card">
                <div class="form-section">Personal Information</div>
                <div class="grid2">
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $patient->user->name??'') }}" required placeholder="Mohamed Alami">
                        @error('name')<p class="err">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $patient->user->email??'') }}" required>
                        @error('email')<p class="err">{{ $message }}</p>@enderror
                    </div>
                </div>
                @if(!isset($patient))
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Min. 8 characters">
                    @error('password')<p class="err">{{ $message }}</p>@enderror
                </div>
                @endif
                <div class="field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->user->phone??'') }}" placeholder="0600000000">
                </div>
            </div>
            <div class="form-card">
                <div class="form-section">Medical Information</div>
                <div class="grid3">
                    <div class="field">
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')??'') }}">
                    </div>
                    <div class="field">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">—</option>
                            <option value="M" @selected(old('gender',$patient->gender??'')==='M')>Male</option>
                            <option value="F" @selected(old('gender',$patient->gender??'')==='F')>Female</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Blood Type</label>
                        <input type="text" name="blood_type" value="{{ old('blood_type', $patient->blood_type??'') }}" placeholder="A+, O-...">
                    </div>
                </div>
                <div class="grid2">
                    <div class="field">
                        <label>Allergies</label>
                        <input type="text" name="Allergies" value="{{ old('Allergies', $patient->Allergies??'') }}" placeholder="None">
                    </div>
                    <div class="field">
                        <label>Medical Conditions</label>
                        <input type="text" name="medical_Conditions" value="{{ old('medical_Conditions', $patient->medical_Conditions??'') }}" placeholder="None">
                    </div>
                </div>
                <div class="grid2">
                    <div class="field">
                        <label>Emergency Contact</label>
                        <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact??'') }}">
                    </div>
                    <div class="field">
                        <label>Emergency Phone</label>
                        <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $patient->emergency_phone??'') }}">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-primary" style="padding:12px 24px;font-size:14px">
                    {{ isset($patient) ? 'Update Patient' : 'Add Patient' }}
                </button>
                <a href="{{ route('secretaire.patients.index') }}" class="btn-secondary" style="padding:12px 24px;font-size:14px">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>









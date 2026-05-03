<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Bahjawa Medical</title>
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
        .content{padding:24px 28px;flex:1;max-width:750px;min-width:0}
        .form-card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px;margin-bottom:16px}
        .section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
        .field{margin-bottom:14px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
        .field input,.field select{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field input:focus,.field select:focus{border-color:#b45309;background:white;box-shadow:0 0 0 3px rgba(180,83,9,.1)}
        .field input[readonly]{background:#f1f5f9;color:#64748b;cursor:not-allowed}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#b45309,#78350f);color:white;border:none;border-radius:10px;padding:12px 24px;font-size:14px;font-weight:600;cursor:pointer}
        .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;border:1px solid #e2e8f0;border-radius:10px;padding:12px 24px;font-size:14px;font-weight:600;text-decoration:none}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:13px;margin-bottom:16px}
        .hero{background:linear-gradient(135deg,#78350f,#b45309);border-radius:18px;padding:24px;margin-bottom:20px;display:flex;align-items:center;gap:16px}
        .hero-avatar{width:60px;height:60px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px;color:white;border:2px solid rgba(255,255,255,.3);flex-shrink:0}
        .hero-name{font-size:20px;font-weight:700;color:white}
        .hero-email{font-size:13px;color:rgba(255,255,255,.7);margin-top:3px}
.hamburger{display:none;width:34px;height:34px;border-radius:9px;border:1px solid #e2e8f0;background:white;align-items:center;justify-content:center;cursor:pointer;color:#64748b;flex-shrink:0}        .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:49}
        .overlay.open{display:block}
        @media(max-width:768px){
          .hamburger{display:flex}
          .sidebar{transform:translateX(-100%)}
          .sidebar.open{transform:translateX(0)}
          .main{margin-left:0}
          .topbar{padding:12px 16px 12px 56px}
          .topbar h1{font-size:15px}
          .content{padding:16px 12px;max-width:100%!important}
          .grid2{grid-template-columns:1fr}
          .grid3{grid-template-columns:1fr}
          .hero{flex-direction:column;text-align:center}
        }
        @media(max-width:480px){
          .topbar p{display:none}
          .btn-primary,.btn-secondary{padding:10px 16px;font-size:13px}
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
        <a href="{{ route('patient.dashboard') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('patient.rendezvous.index') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Appointments
        </a>
        <a href="{{ route('patient.historique') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            History
        </a>
        <a href="{{ route('patient.profil') }}" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            My Profile
        </a>
        <div class="nav-section">Actions</div>
        <a href="{{ route('patient.rendezvous.create') }}" class="nav-item">
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
        <div><h1>My Profile</h1><p>Update your personal information</p></div>
    </div>
    <div class="content">
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <div class="hero">
            <div class="hero-avatar">{{ strtoupper(substr($user->name,0,2)) }}</div>
            <div>
                <div class="hero-name">{{ $user->name }}</div>
                <div class="hero-email">{{ $user->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('patient.profil.update') }}">
            @csrf @method('PUT')
            <div class="form-card">
                <div class="section">Personal Information</div>
                <div class="grid2">
                    <div class="field"><label>Full Name</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required></div>
                    <div class="field"><label>Email (read only)</label><input type="email" value="{{ $user->email }}" readonly></div>
                </div>
                <div class="grid2">
                    <div class="field"><label>Phone</label><input type="text" name="phone" value="{{ old('phone',$user->phone) }}" placeholder="0600000000"></div>
                    <div class="field"><label>Address</label><input type="text" name="address" value="{{ old('address',$user->address) }}" placeholder="Marrakech"></div>
                </div>
            </div>
            <div class="form-card">
                <div class="section">Medical Information</div>
                <div class="grid3">
                    <div class="field"><label>Birth Date</label><input type="date" name="birth_date" value="{{ old('birth_date',$patient?->birth_date?->format('Y-m-d')) }}"></div>
                    <div class="field">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">—</option>
                            <option value="M" @selected(old('gender',$patient?->gender)==='M')>Male</option>
                            <option value="F" @selected(old('gender',$patient?->gender)==='F')>Female</option>
                        </select>
                    </div>
                    <div class="field"><label>Blood Type</label><input type="text" name="blood_type" value="{{ old('blood_type',$patient?->blood_type) }}" placeholder="A+, O-..."></div>
                </div>
                <div class="grid2">
                    <div class="field"><label>Allergies</label><input type="text" name="Allergies" value="{{ old('Allergies',$patient?->Allergies) }}" placeholder="None"></div>
                    <div class="field"><label>Medical Conditions</label><input type="text" name="medical_Conditions" value="{{ old('medical_Conditions',$patient?->medical_Conditions) }}" placeholder="None"></div>
                </div>
                <div class="grid2">
                    <div class="field"><label>Emergency Contact</label><input type="text" name="emergency_contact" value="{{ old('emergency_contact',$patient?->emergency_contact) }}"></div>
                    <div class="field"><label>Emergency Phone</label><input type="text" name="emergency_phone" value="{{ old('emergency_phone',$patient?->emergency_phone) }}"></div>
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button type="submit" class="btn-primary">Save Changes</button>
                <a href="{{ route('patient.dashboard') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahjawa Medical Center - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;min-height:100vh;background:linear-gradient(135deg,#0ea5e9,#0369a1);display:flex;align-items:center;justify-content:center;padding:20px}
        .card{display:flex;width:100%;max-width:920px;border-radius:24px;overflow:hidden;box-shadow:0 25px 60px rgba(2,132,199,.4)}
        .left{width:40%;background:#0369a1;background-image:url('{{ asset("images/medical-team.jpg") }}');background-size:cover;background-position:center;background-blend-mode:multiply;padding:40px 32px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
        .left::before{content:"";position:absolute;top:-80px;right:-80px;width:280px;height:280px;background:rgba(255,255,255,.06);border-radius:50%}
        .left::after{content:"";position:absolute;bottom:-80px;left:-60px;width:260px;height:260px;background:rgba(255,255,255,.04);border-radius:50%}
        .right{width:60%;background:white;padding:36px 40px}
        .logo{display:flex;align-items:center;gap:10px;position:relative;z-index:1}
        .logo-text{font-size:15px;font-weight:700;color:white;line-height:1.2}
        .logo-sub{font-size:10px;color:#bae6fd;display:block}
        .left-body{position:relative;z-index:1;margin-top:28px}
        .left-body h2{color:white;font-size:24px;font-weight:700;line-height:1.3;margin-bottom:10px}
        .left-body p{color:#bae6fd;font-size:13px;line-height:1.6;margin-bottom:18px}
        .feat{display:flex;align-items:center;gap:8px;color:white;font-size:12px;margin-bottom:8px}
        .fdot{width:6px;height:6px;border-radius:50%;background:#38bdf8;flex-shrink:0}
        .roles-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;position:relative;z-index:1;margin-top:24px}
        .role-card{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:10px 8px;display:flex;align-items:center;gap:8px}
        .role-card-name{color:white;font-size:11px;font-weight:600}
        .form-title{font-size:22px;font-weight:700;color:#0f172a;margin-bottom:4px}
        .form-sub{font-size:13px;color:#64748b;margin-bottom:20px}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .field{margin-bottom:13px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
        .field input,.field select{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field input:focus,.field select:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
        .btn{width:100%;padding:13px;background:linear-gradient(135deg,#0ea5e9,#0369a1);color:white;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;margin-top:4px}
        .login-link{text-align:center;font-size:13px;color:#64748b;margin-top:14px}
        .login-link a{color:#0369a1;font-weight:600;text-decoration:none}
        .error-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#dc2626}
    </style>
</head>
<body>
<div class="card">
    <div class="left">
        <div class="logo">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0284c7" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round"/></svg>
            <div><span class="logo-text">Bahjawa Medical Center</span><span class="logo-sub">Medical Management Platform</span></div>
        </div>
        <div class="left-body">
            <h2>Join our platform</h2>
            <p>Create your account and access all services.</p>
            <div class="feat"><div class="fdot"></div>Online appointment booking</div>
            <div class="feat"><div class="fdot"></div>Secure medical records</div>
            <div class="feat"><div class="fdot"></div>Consultation tracking</div>
            <div class="feat"><div class="fdot"></div>Electronic prescriptions</div>
            <div class="feat"><div class="fdot"></div>Real-time notifications</div>
        </div>
        <div class="roles-grid">
            <div class="role-card"><svg width="32" height="32" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#E6F1FB" stroke="#185FA5" stroke-width="2"/><ellipse cx="70" cy="110" rx="35" ry="22" fill="#185FA5"/><circle cx="70" cy="55" r="22" fill="#B5D4F4"/><path d="M58 75 L70 68 L82 75 L82 90 Q70 97 58 90 Z" fill="#185FA5"/></svg><span class="role-card-name">Admin</span></div>
            <div class="role-card"><svg width="32" height="32" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#EAF3DE" stroke="#3B6D11" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#3B6D11"/><circle cx="70" cy="55" r="22" fill="#C0DD97"/><path d="M52 78 Q44 88 50 96 Q56 104 64 100" fill="none" stroke="#27500A" stroke-width="2.5" stroke-linecap="round"/><circle cx="64" cy="101" r="4" fill="#27500A"/></svg><span class="role-card-name">Doctor</span></div>
            <div class="role-card"><svg width="32" height="32" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#FAEEDA" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#854F0B"/><circle cx="70" cy="55" r="22" fill="#FAC775"/><rect x="54" y="74" width="22" height="18" rx="2" fill="#633806"/></svg><span class="role-card-name">Secretary</span></div>
            <div class="role-card"><svg width="32" height="32" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#FBEAF0" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#993556"/><circle cx="70" cy="55" r="22" fill="#F4C0D1"/><polyline points="52,83 58,83 61,75 65,91 69,79 73,83 88,83" fill="none" stroke="#72243E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="role-card-name">Patient</span></div>
        </div>
    </div>
    <div class="right">
        <h1 class="form-title">Create Account</h1>
        <p class="form-sub">Fill in the form to get started</p>
        @if ($errors->any())
            <div class="error-box">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="g2">
                <div class="field">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Mohamed Alami" required>
                </div>
                <div class="field">
                    <label>Role</label>
                    <select name="role">
                        <option value="patient" @selected(old('role')=='patient')>Patient</option>
                        <option value="Doctor" @selected(old('role')=='Doctor')>Doctor</option>
                        <option value="Secretary" @selected(old('role')=='Secretary')>Secretary</option>
                    </select>
                </div>
            </div>
            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@cabinet.ma" required>
            </div>
            <div class="g2">
                <div class="field">
                    <label>Password</label>
                    <input type="Password" name="Password" placeholder="Min. 8 characters" required>
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <input type="Password" name="Password_Confirm Password" placeholder="Repeat Password" required>
                </div>
            </div>
            <button type="submit" class="btn">Create Account</button>
        </form>
        <div class="login-link">Already have an account? <a href="{{ route('login') }}">Sign In</a></div>
    </div>
</div>
</body>
</html>










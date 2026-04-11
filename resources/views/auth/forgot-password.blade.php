<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahjawa Medical Center - Reinitialisation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;min-height:100vh;background:linear-gradient(135deg,#0ea5e9,#0369a1);display:flex;align-items:center;justify-content:center;padding:20px}
        .card{width:100%;max-width:460px;background:white;border-radius:24px;padding:44px 40px;box-shadow:0 25px 60px rgba(2,132,199,.35)}
        .logo{display:flex;align-items:center;gap:10px;margin-bottom:28px;justify-content:center}
        .logo-text{font-size:15px;font-weight:700;color:#0369a1}
        .logo-sub{font-size:10px;color:#94a3b8;display:block}
        .icon-wrap{width:72px;height:72px;background:#eff6ff;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px}
        h1{font-size:22px;font-weight:700;color:#0f172a;text-align:center;margin-bottom:8px}
        .sub{font-size:13px;color:#64748b;text-align:center;margin-bottom:28px;line-height:1.6}
        .field{margin-bottom:16px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px}
        .field input{width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field input:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
        .btn{width:100%;padding:13px;background:linear-gradient(135deg,#0ea5e9,#0369a1);color:white;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;margin-bottom:16px}
        .back{display:flex;align-items:center;justify-content:center;gap:6px;font-size:13px;color:#64748b;text-decoration:none}
        .back:hover{color:#0369a1}
        .success-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#16a34a;text-align:center}
        .divider{display:flex;align-items:center;gap:12px;margin:22px 0 14px;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:.5px}
        .divider::before,.divider::after{content:"";flex:1;height:0.5px;background:#e2e8f0}
        .roles-row{display:flex;justify-content:center;gap:16px}
        .role-item{display:flex;flex-direction:column;align-items:center;gap:4px}
        .role-item span{font-size:10px;font-weight:600;color:#94a3b8}
        .err{color:#dc2626;font-size:12px;margin-top:5px}
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0284c7" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round"/></svg>
        <div><span class="logo-text">Bahjawa Medical Center</span><span class="logo-sub">Medical Management Platform</span></div>
    </div>
    <div class="icon-wrap">
        <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0284c7" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round"/></svg>
    </div>
    <h1>Forgot Password?</h1>
    <p class="sub">Enter your email address and we will send you a reset link.</p>
    @if (session('status'))
        <div class="success-box">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@cabinet.ma" required autofocus>
            @error('email') <p class="err">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn">Send Reset Link</button>
    </form>
    <a href="{{ route('login') }}" class="back">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Sign In
    </a>
    <div class="divider">All workspaces</div>
    <div class="roles-row">
        <div class="role-item"><svg width="38" height="38" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#E6F1FB" stroke="#185FA5" stroke-width="2"/><ellipse cx="70" cy="110" rx="35" ry="22" fill="#185FA5"/><circle cx="70" cy="55" r="22" fill="#B5D4F4"/><path d="M58 75 L70 68 L82 75 L82 90 Q70 97 58 90 Z" fill="#185FA5"/></svg><span>Admin</span></div>
        <div class="role-item"><svg width="38" height="38" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#EAF3DE" stroke="#3B6D11" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#3B6D11"/><circle cx="70" cy="55" r="22" fill="#C0DD97"/><path d="M52 78 Q44 88 50 96 Q56 104 64 100" fill="none" stroke="#27500A" stroke-width="2.5" stroke-linecap="round"/><circle cx="64" cy="101" r="4" fill="#27500A"/></svg><span>Doctor</span></div>
        <div class="role-item"><svg width="38" height="38" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#FAEEDA" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#854F0B"/><circle cx="70" cy="55" r="22" fill="#FAC775"/><rect x="54" y="74" width="22" height="18" rx="2" fill="#633806"/></svg><span>Secretary</span></div>
        <div class="role-item"><svg width="38" height="38" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"><circle cx="70" cy="70" r="65" fill="#FBEAF0" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#993556"/><circle cx="70" cy="55" r="22" fill="#F4C0D1"/><polyline points="52,83 58,83 61,75 65,91 69,79 73,83 88,83" fill="none" stroke="#72243E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Patient</span></div>
    </div>
</div>
</body>
</html>









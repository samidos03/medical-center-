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
        .left{width:40%;background:#0369a1;padding:40px 32px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
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
        .form-title{font-size:22px;font-weight:700;color:#0f172a;margin-bottom:4px}
        .form-sub{font-size:13px;color:#64748b;margin-bottom:20px}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .field{margin-bottom:13px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
        .field input{width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field input:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
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
            <p>Create your patient account and access all services.</p>
            <div class="feat"><div class="fdot"></div>Online appointment booking</div>
            <div class="feat"><div class="fdot"></div>Secure medical records</div>
            <div class="feat"><div class="fdot"></div>Consultation tracking</div>
            <div class="feat"><div class="fdot"></div>Electronic prescriptions</div>
            <div class="feat"><div class="fdot"></div>Real-time notifications</div>
        </div>
    </div>
    <div class="right">
        <h1 class="form-title">Create Patient Account</h1>
        <p class="form-sub">Fill in the form to get started</p>
        @if ($errors->any())
            <div class="error-box">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Mohamed Alami" required>
            </div>
            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@cabinet.ma" required>
            </div>
            <div class="g2">
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 8 characters" required>
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required>
                </div>
            </div>
            <button type="submit" class="btn">Create Account</button>
        </form>
        <div class="login-link">Already have an account? <a href="{{ route('login') }}">Sign In</a></div>
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bahjawa Medical Center - Login</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Segoe UI,system-ui,sans-serif;min-height:100vh;background:linear-gradient(135deg,#0ea5e9,#0369a1);display:flex;align-items:center;justify-content:center;padding:16px}

/* CARD */
.card{display:flex;width:100%;max-width:980px;min-height:580px;border-radius:24px;overflow:hidden;box-shadow:0 25px 60px rgba(2,132,199,.4)}

/* LEFT IMAGE PANEL */
.panel-img{width:30%;position:relative;overflow:hidden;background:#e0f2fe}
.panel-img img{width:100%;height:100%;object-fit:cover;object-position:center}
.panel-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,105,161,.1),rgba(3,105,161,.5));z-index:1}
.panel-img-text{position:absolute;bottom:20px;left:0;right:0;text-align:center;z-index:2;padding:0 16px}
.panel-img-text p{color:white;font-size:13px;font-weight:600;text-shadow:0 1px 4px rgba(0,0,0,.4)}

/* CENTER FORM */
.left{width:40%;background:white;padding:36px 32px;display:flex;flex-direction:column;justify-content:space-between}
.logo{display:flex;align-items:center;gap:10px;margin-bottom:24px}
.logo-text{font-size:14px;font-weight:700;color:#0369a1;line-height:1.2}
.logo-sub{font-size:10px;color:#94a3b8;display:block}
.form-title{font-size:21px;font-weight:700;color:#0f172a;margin-bottom:4px}
.form-sub{font-size:13px;color:#64748b;margin-bottom:18px}
.field{margin-bottom:13px}
.field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.6px}
.field input{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
.field input:focus{border-color:#0ea5e9;background:white;box-shadow:0 0 0 3px rgba(14,165,233,.1)}
.row{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;font-size:12px}
.remember{display:flex;align-items:center;gap:6px;color:#64748b;cursor:pointer}
.forgot{color:#0ea5e9;text-decoration:none;font-weight:600}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#0ea5e9,#0369a1);color:white;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;letter-spacing:.3px}
.btn-login:hover{opacity:.9}
.roles-label{font-size:11px;font-weight:700;color:#94a3b8;text-align:center;margin:14px 0 10px;text-transform:uppercase;letter-spacing:.6px}
.roles{display:grid;grid-template-columns:repeat(4,1fr);gap:7px}
.role-btn{border:1.5px solid #e2e8f0;border-radius:12px;padding:9px 4px;text-align:center;cursor:pointer;transition:all .2s;background:white}
.role-btn:hover{border-color:#0ea5e9;transform:translateY(-2px)}
.role-btn.active{border-color:#0369a1;background:#f0f9ff;box-shadow:0 0 0 3px rgba(14,165,233,.12)}
.role-name{font-size:10px;font-weight:700;color:#1e293b;margin-top:4px}
.register-link{text-align:center;font-size:13px;color:#64748b;margin-top:11px}
.register-link a{color:#0369a1;font-weight:600;text-decoration:none}
.error-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#dc2626}
.hint{font-size:11px;color:#94a3b8;text-align:center;margin-top:6px}

/* RIGHT PANEL */
.right{width:30%;position:relative;overflow:hidden;transition:background .6s}
.c1{position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(255,255,255,.06);border-radius:50%}
.c2{position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;background:rgba(255,255,255,.04);border-radius:50%}
.right-center{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:5}
.illus{position:absolute;transition:opacity .4s,transform .4s;opacity:0;transform:scale(.9)}
.illus.active{opacity:1;transform:scale(1)}
.right-bottom{position:absolute;bottom:0;left:0;right:0;padding:22px 24px;z-index:10}
.badge{background:white;border-radius:14px;padding:9px 13px;display:inline-flex;align-items:center;gap:8px;margin-bottom:9px}
.bdot{width:8px;height:8px;border-radius:50%;background:#22c55e;animation:pulse 2s infinite;flex-shrink:0}
@keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.4)}}
.btext{font-size:12px;font-weight:600;color:#0f172a}
.rtitle{color:white;font-size:18px;font-weight:700;margin-bottom:3px;text-shadow:0 2px 8px rgba(0,0,0,.2)}
.rdesc{color:rgba(255,255,255,.8);font-size:12px}

/* ========================
   RESPONSIVE
======================== */

/* TABLETTE 768px */
@media(max-width:900px){
  .card{flex-direction:column;max-width:480px;min-height:auto}
  .panel-img{display:none}
  .left{width:100%;padding:28px 24px}
  .right{width:100%;min-height:160px;border-radius:0}
  .right-center{display:none}
  .right-bottom{position:relative;padding:20px 24px}
  .rtitle{font-size:15px}
  .rdesc{font-size:11px}
  .roles{grid-template-columns:repeat(4,1fr)}
}

/* MOBILE 480px */
@media(max-width:480px){
  body{padding:10px}
  .card{border-radius:18px;max-width:100%}
  .left{padding:22px 18px}
  .form-title{font-size:18px}
  .roles{grid-template-columns:repeat(4,1fr);gap:5px}
  .role-btn{padding:7px 2px;border-radius:10px}
  .role-btn svg{width:36px;height:36px}
  .role-name{font-size:9px}
  .btn-login{padding:12px;font-size:14px}
  .right{min-height:130px}
  .right-bottom{padding:16px}
  .rtitle{font-size:14px}
  .badge{padding:7px 10px}
  .btext{font-size:11px}
}

/* TRÈS PETIT 360px */
@media(max-width:360px){
  .roles{grid-template-columns:repeat(2,1fr)}
  .left{padding:18px 14px}
}
</style>
</head>
<body>
<div class="card">

    <!-- LEFT IMAGE PANEL -->
    <div class="panel-img">
        <img src="{{ asset('images/medical-team.jpg') }}"
             alt="Medical Team"
             onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(160deg,#0369a1,#0ea5e9)'">
        <div class="panel-img-overlay"></div>
        <div class="panel-img-text"><p>Bahjawa Medical Center</p></div>
    </div>

    <!-- CENTER FORM -->
    <div class="left">
        <div>
            <div class="logo">
                <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0284c7" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round"/></svg>
                <div>
                    <span class="logo-text">Bahjawa Medical Center</span>
                    <span class="logo-sub">Medical Management Platform</span>
                </div>
            </div>
            <h1 class="form-title">Sign In</h1>
            <p class="form-sub">Access your personal workspace</p>
            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label>Email Address</label>
                    <input type="email" name="email" id="email-input" value="{{ old('email','admin@cabinet.ma') }}" placeholder="example@bahjawa.ma" required>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" id="pass-input" placeholder="Enter your password" required>
                </div>
                <div class="row">
                    <label class="remember"><input type="checkbox" name="remember"> Remember me</label>
                    <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            <div class="hint">Click a role to fill credentials</div>
        </div>
        <div>
            <div class="roles-label">SELECT YOUR WORKSPACE</div>
            <div class="roles">
                <div class="role-btn active" onclick="setRole(0,this)">
                    <svg width="48" height="48" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#E6F1FB" stroke="#185FA5" stroke-width="2"/><ellipse cx="70" cy="110" rx="35" ry="22" fill="#185FA5"/><circle cx="70" cy="55" r="22" fill="#B5D4F4"/><path d="M58 75 L70 68 L82 75 L82 90 Q70 97 58 90 Z" fill="#185FA5" stroke="#0C447C" stroke-width="1"/></svg>
                    <div class="role-name">Admin</div>
                </div>
                <div class="role-btn" onclick="setRole(1,this)">
                    <svg width="48" height="48" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#EAF3DE" stroke="#3B6D11" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#3B6D11"/><circle cx="70" cy="55" r="22" fill="#C0DD97"/><path d="M52 78 Q44 88 50 96 Q56 104 64 100" fill="none" stroke="#27500A" stroke-width="2.5" stroke-linecap="round"/><circle cx="64" cy="101" r="4" fill="#27500A"/><line x1="64" y1="78" x2="88" y2="78" stroke="#27500A" stroke-width="2.5" stroke-linecap="round"/></svg>
                    <div class="role-name">Doctor</div>
                </div>
                <div class="role-btn" onclick="setRole(2,this)">
                    <svg width="48" height="48" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#FBEAF0" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#993556"/><circle cx="70" cy="55" r="22" fill="#FAC775"/><rect x="54" y="74" width="22" height="18" rx="2" fill="#633806"/><rect x="60" y="71" width="10" height="5" rx="2" fill="#412402"/></svg>
                    <div class="role-name">Secretary</div>
                </div>
                <div class="role-btn" onclick="setRole(3,this)">
                    <svg width="48" height="48" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#FAEEDA" stroke="#854F0B" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#854F0B"/><circle cx="70" cy="55" r="22" fill="#F4C0D1"/><polyline points="52,83 58,83 61,75 65,91 69,79 73,83 88,83" fill="none" stroke="#72243E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <div class="role-name">Patient</div>
                </div>
            </div>
            <div class="register-link">No account yet? <a href="{{ route('register') }}">Create one</a></div>
        </div>
    </div>

    <!-- RIGHT DYNAMIC PANEL -->
    <div class="right" id="rp" style="background:linear-gradient(160deg,#0369a1,#0ea5e9,#38bdf8)">
        <div class="c1"></div><div class="c2"></div>
        <div class="right-center">
            <div class="illus active" id="i0">
                <svg width="150" height="150" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#E6F1FB" stroke="#185FA5" stroke-width="2"/><ellipse cx="70" cy="110" rx="35" ry="22" fill="#185FA5"/><circle cx="70" cy="55" r="22" fill="#B5D4F4"/><path d="M58 75 L70 68 L82 75 L82 90 Q70 97 58 90 Z" fill="#185FA5" stroke="#0C447C" stroke-width="1"/></svg>
            </div>
            <div class="illus" id="i1">
                <svg width="150" height="150" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#EAF3DE" stroke="#3B6D11" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#3B6D11"/><circle cx="70" cy="55" r="22" fill="#C0DD97"/></svg>
            </div>
            <div class="illus" id="i2">
                <svg width="150" height="150" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#FBEAF0" stroke="#993556" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#993556"/><circle cx="70" cy="55" r="22" fill="#FAC775"/></svg>
            </div>
            <div class="illus" id="i3">
                <svg width="150" height="150" viewBox="0 0 140 140"><circle cx="70" cy="70" r="65" fill="#FAEEDA" stroke="#854F0B" stroke-width="2"/><ellipse cx="70" cy="112" rx="35" ry="22" fill="#854F0B"/><circle cx="70" cy="55" r="22" fill="#F4C0D1"/></svg>
            </div>
        </div>
        <div class="right-bottom">
            <div class="badge"><div class="bdot"></div><span class="btext" id="bt">Secure access - Administrator</span></div>
            <div class="rtitle" id="rt">Administrator Workspace</div>
            <div class="rdesc" id="rd">Full access to medical cabinet management</div>
        </div>
    </div>

</div>

<script>
const d=[
    {bg:"linear-gradient(160deg,#0369a1,#0ea5e9,#38bdf8)",b:"Secure access - Administrator",t:"Administrator Workspace",desc:"Full access to medical cabinet management",email:"admin@cabinet.ma",pass:"password"},
    {bg:"linear-gradient(160deg,#1D9E75,#3B6D11,#97C459)",b:"Secure access - Doctor",t:"Espace Doctor",desc:"Patient Consultations and medical records",email:"Doctor1@cabinet.ma",pass:"password"},
    {bg:"linear-gradient(160deg,#993556,#D4537E,#F4C0D1)",b:"Secure access - Secretary",t:"Espace Secretary",desc:"Administrative management and appointments",email:"Secretary@cabinet.ma",pass:"password"},
    {bg:"linear-gradient(160deg,#854F0B,#BA7517,#EF9F27)",b:"Secure access - Patient",t:"Patient Workspace",desc:"Your appointments and Consultations",email:"patient1@cabinet.ma",pass:"password"}
];
let c=0;
function setRole(i,btn){
    document.querySelectorAll(".role-btn").forEach(b=>b.classList.remove("active"));
    btn.classList.add("active");
    document.getElementById("i"+c).classList.remove("active");
    document.getElementById("i"+i).classList.add("active");
    document.getElementById("rp").style.background=d[i].bg;
    document.getElementById("bt").textContent=d[i].b;
    document.getElementById("rt").textContent=d[i].t;
    document.getElementById("rd").textContent=d[i].desc;
    document.getElementById("email-input").value=d[i].email;
    document.getElementById("pass-input").value=d[i].pass;
    c=i;
}
</script>
</body>
</html>
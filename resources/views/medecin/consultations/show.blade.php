<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0f7ff;min-height:100vh;padding:24px}
        .header{background:linear-gradient(135deg,#1D9E75,#3B6D11);border-radius:18px;padding:20px 28px;color:white;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:20px;font-weight:700}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px;margin-bottom:16px}
        .section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .row{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;font-size:13px}
        .label{color:#64748b}
        .value{font-weight:600;color:#0f172a}
        .content-box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;font-size:13px;line-height:1.7;white-space:pre-wrap}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;border:none;cursor:pointer}
        .btn-green{background:linear-gradient(135deg,#1D9E75,#3B6D11);color:white}
        .btn-gray{background:#f1f5f9;color:#374151}
        .back{display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.8);font-size:13px;text-decoration:none;margin-bottom:12px}
    </style>
</head>
<body>
<div style="max-width:700px;margin:0 auto">
    <div class="header">
        <div>
            <a href="{{ route('medecin.consultations.index') }}" class="back">&larr; Retour</a>
            <h1>Consultation - {{ $consultation->patient->user->name }}</h1>
        </div>
        @if($consultation->ordonnance)
            <a href="{{ route('medecin.ordonnances.pdf', $consultation->ordonnance) }}" class="btn btn-green">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download PDF
            </a>
        @endif
    </div>
    <div class="card">
        <div class="section">Informations</div>
        <div class="row"><span class="label">Patient</span><span class="value">{{ $consultation->patient->user->name }}</span></div>
        <div class="row"><span class="label">Date</span><span class="value">{{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</span></div>
        <div class="row"><span class="label">Doctor</span><span class="value">{{ $consultation->medecin->user->name }}</span></div>
    </div>
    <div class="card">
        <div class="section">Summary</div>
        <div class="content-box">{{ $consultation->compte_rendu }}</div>
    </div>
    @if($consultation->ordonnance)
    <div class="card">
        <div class="section">Prescription</div>
        <div class="content-box">{{ $consultation->ordonnance->contenu }}</div>
        <div style="margin-top:14px">
            <a href="{{ route('medecin.ordonnances.pdf', $consultation->ordonnance) }}" class="btn btn-green">
                Download Prescription PDF
            </a>
        </div>
    </div>
    @endif
</div>
</body>
</html>
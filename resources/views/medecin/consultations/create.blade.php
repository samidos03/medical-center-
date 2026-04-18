﻿<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Consultation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0f7ff;min-height:100vh;padding:24px}
        .header{background:linear-gradient(135deg,#1D9E75,#3B6D11);border-radius:18px;padding:20px 28px;color:white;margin-bottom:24px}
        .header h1{font-size:20px;font-weight:700}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:24px;margin-bottom:16px}
        .section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .field{margin-bottom:16px}
        .field label{display:block;font-size:11px;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
        .field select,.field textarea{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;background:#f8fafc;outline:none;transition:all .2s}
        .field select:focus,.field textarea:focus{border-color:#1D9E75;background:white;box-shadow:0 0 0 3px rgba(29,158,117,.1)}
        .field textarea{resize:vertical;min-height:120px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;border:none;cursor:pointer}
        .btn-green{background:linear-gradient(135deg,#1D9E75,#3B6D11);color:white}
        .btn-gray{background:#f1f5f9;color:#374151}
        .err{color:#dc2626;font-size:12px;margin-top:4px}
        .back{display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.8);font-size:13px;text-decoration:none;margin-bottom:12px}
    </style>
</head>
<body>
<div style="max-width:700px;margin:0 auto">
    <div class="header">
        <a href="{{ route('medecin.consultations.index') }}" class="back">← Retour</a>
        <h1>New Consultation</h1>
    </div>
    <form method="POST" action="{{ route('medecin.consultations.store') }}">
        @csrf
        <div class="card">
            <div class="section">Appointments</div>
            <div class="field">
                <label>Select le Appointments</label>
                <select name="rendez_vous_id" required>
                    <option value="">-- Choisir un RDV confirme --</option>
                    @foreach($rdvs as $rdv)
                        <option value="{{ $rdv->id }}" @selected(old('rendez_vous_id')==$rdv->id)>
                            {{ $rdv->patient->user->name }} - {{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }} a {{ substr($rdv->heure_rdv,0,5) }}
                        </option>
                    @endforeach
                </select>
                @error('rendez_vous_id')<p class="err">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="card">
            <div class="section">Summary medical</div>
            <div class="field">
                <label>Summary de la consultation</label>
                <textarea name="compte_rendu" required placeholder="Decrivez les observations, le diagnostic et les recommandations...">{{ old('compte_rendu') }}</textarea>
                @error('compte_rendu')<p class="err">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="card">
            <div class="section">Prescription (optionnel)</div>
            <div class="field">
                <label>Prescription medicale</label>
                <textarea name="contenu_ordonnance" placeholder="Ex:&#10;- Paracetamol 500mg : 1 comprime 3 fois par jour pendant 5 jours&#10;- Ibuprofene 400mg : 1 comprime matin et soir pendant 3 jours&#10;...">{{ old('contenu_Prescription') }}</textarea>
            </div>
        </div>
        <div style="display:flex;gap:10px">
            <button type="submit" class="btn btn-green">Save Consultation</button>
            <a href="{{ route('medecin.consultations.index') }}" class="btn btn-gray">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>









<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1e293b; background: white; }
        .header { background: #0369a1; color: white; padding: 24px 32px; display: flex; justify-content: space-between; align-items: center; }
        .logo-text { font-size: 20px; font-weight: 700; }
        .logo-sub { font-size: 11px; opacity: .8; margin-top: 2px; }
        .header-right { text-align: right; font-size: 12px; opacity: .9; }
        .body { padding: 28px 32px; }
        .title { font-size: 22px; font-weight: 700; color: #0369a1; text-align: center; margin-bottom: 24px; border-bottom: 2px solid #0369a1; padding-bottom: 10px; }
        .info-grid { display: table; width: 100%; margin-bottom: 24px; }
        .info-col { display: table-cell; width: 50%; padding: 16px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; vertical-align: top; }
        .info-col + .info-col { margin-left: 16px; }
        .info-label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .info-value { font-size: 14px; font-weight: 600; color: #0f172a; }
        .info-sub { font-size: 12px; color: #64748b; margin-top: 2px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; border-left: 3px solid #0369a1; padding-left: 10px; }
        .content-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; font-size: 13px; line-height: 1.7; white-space: pre-wrap; }
        .meta-row { display: table; width: 100%; margin-bottom: 6px; }
        .meta-key { display: table-cell; width: 140px; color: #64748b; font-size: 12px; }
        .meta-val { display: table-cell; font-weight: 600; font-size: 12px; }
        .footer { margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px; display: table; width: 100%; }
        .footer-left { display: table-cell; font-size: 11px; color: #94a3b8; }
        .footer-right { display: table-cell; text-align: right; }
        .signature-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 20px; display: inline-block; text-align: center; }
        .signature-name { font-size: 13px; font-weight: 700; color: #0f172a; }
        .signature-spec { font-size: 11px; color: #64748b; }
        .watermark { position: fixed; bottom: 40px; right: 30px; opacity: .06; font-size: 60px; font-weight: 900; color: #0369a1; transform: rotate(-30deg); }
    </style>
</head>
<body>
<div class="watermark">Prescription</div>

<div class="header">
    <div>
        <div class="logo-text">Bahjawa Medical Center</div>
        <div class="logo-sub">Plateforme de Gestion Medicale</div>
    </div>
    <div class="header-right">
        <div>Prescription N -  {{ str_pad($ordonnance->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div>Date : {{ \Carbon\Carbon::parse($ordonnance->date_creation)->format('d/m/Y') }}</div>
    </div>
</div>

<div class="body">
    <div class="title">Prescription MEDICALE</div>

    <table style="width:100%;margin-bottom:20px;border-collapse:separate;border-spacing:12px 0">
        <tr>
            <td style="width:50%;background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:14px;vertical-align:top">
                <div class="info-label">Patient</div>
                <div class="info-value">{{ $ordonnance->consultation->patient->user->name }}</div>
                <div class="info-sub">{{ $ordonnance->consultation->patient->user->email }}</div>
                @if($ordonnance->consultation->patient->birth_date)
                <div class="info-sub">Ne(e) le : {{ \Carbon\Carbon::parse($ordonnance->consultation->patient->birth_date)->format('d/m/Y') }}</div>
                @endif
                @if($ordonnance->consultation->patient->blood_type)
                <div class="info-sub">Blood Type : {{ $ordonnance->consultation->patient->blood_type }}</div>
                @endif
            </td>
            <td style="width:50%;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:14px;vertical-align:top">
                <div class="info-label">Medecin prescripteur</div>
                <div class="info-value">{{ $ordonnance->consultation->medecin->user->name }}</div>
                <div class="info-sub">{{ $ordonnance->consultation->medecin->specialite->nom ?? 'Medecin generaliste' }}</div>
                <div class="info-sub">{{ $ordonnance->consultation->medecin->telephone ?? '' }}</div>
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="section-title">Informations de la consultation</div>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px">
            <div class="meta-row"><span class="meta-key">Date consultation :</span><span class="meta-val">{{ \Carbon\Carbon::parse($ordonnance->consultation->date_consultation)->format('d/m/Y') }}</span></div>
            <div class="meta-row"><span class="meta-key">Summary :</span><span class="meta-val">{{ Str::limit($ordonnance->consultation->compte_rendu, 100) }}</span></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Prescription medicale</div>
        <div class="content-box">{{ $ordonnance->contenu }}</div>
    </div>

    <div class="footer">
        <div class="footer-left">
            <div>Bahjawa Medical Center</div>
            <div>Document genere le {{ now()->format('d/m/Y a H:i') }}</div>
            <div style="margin-top:4px;color:#bae6fd">Ce document est valable 3 mois a compter de la date de prescription.</div>
        </div>
        <div class="footer-right">
            <div class="signature-box">
                <div style="height:40px;border-bottom:1px solid #e2e8f0;margin-bottom:8px"></div>
                <div class="signature-name">{{ $ordonnance->consultation->medecin->user->name }}</div>
                <div class="signature-spec">{{ $ordonnance->consultation->medecin->specialite->nom ?? '' }}</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>



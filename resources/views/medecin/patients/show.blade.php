<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier patient</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0fdf4;min-height:100vh;padding:24px}
        .header{background:linear-gradient(135deg,#065f46,#059669);border-radius:18px;padding:20px 28px;color:white;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}
        .back{color:rgba(255,255,255,.8);font-size:13px;text-decoration:none;display:block;margin-bottom:8px}
        .header h1{font-size:20px;font-weight:700}
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;padding:22px}
        .section{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
        .row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:13px}
        .lbl{color:#64748b}
        .val{font-weight:600;color:#0f172a}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
        td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
        .pg{background:#f0fdf4;color:#16a34a}
        .pa{background:#fffbeb;color:#d97706}
        .pr{background:#fef2f2;color:#dc2626}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:10px;font-size:12px;font-weight:600;text-decoration:none}
        .btn-green{background:linear-gradient(135deg,#059669,#065f46);color:white}
        .btn-blue{background:#eff6ff;color:#0369a1}
    </style>
</head>
<body>
<div style="max-width:900px;margin:0 auto">
    <div class="header">
        <div>
            <a href="{{ route('medecin.patients.index') }}" class="back">u{2190} Retour</a>
            <h1>{{ $patient->user->name }}</h1>
        </div>
        <a href="{{ route('medecin.consultations.create') }}" class="btn btn-green" style="color:white">+ Consultation</a>
    </div>
    <div class="grid2">
        <div class="card">
            <div class="section">Informations personnelles</div>
            <div class="row"><span class="lbl">Nom</span><span class="val">{{ $patient->user->name }}</span></div>
            <div class="row"><span class="lbl">Email</span><span class="val" style="font-size:12px">{{ $patient->user->email }}</span></div>
            <div class="row"><span class="lbl">Phone</span><span class="val">{{ $patient->user->phone??'-' }}</span></div>
            <div class="row"><span class="lbl">Naissance</span><span class="val">{{ $patient->birth_date?->format('d/m/Y')??'-' }}</span></div>
            <div class="row"><span class="lbl">Gender</span><span class="val">{{ $patient->gender==='M'?'Male':($patient->gender==='F'?'Female':'-') }}</span></div>
            <div class="row"><span class="lbl">Blood Type</span><span class="val" style="color:#dc2626">{{ $patient->blood_type??'-' }}</span></div>
        </div>
        <div class="card">
            <div class="section">Informations medicales</div>
            <div class="row"><span class="lbl">Allergies</span><span class="val">{{ $patient->Allergies??'None' }}</span></div>
            <div class="row"><span class="lbl">Conditions</span><span class="val">{{ $patient->medical_Conditions??'None' }}</span></div>
            <div class="row"><span class="lbl">Emergency Contact</span><span class="val">{{ $patient->emergency_contact??'-' }}</span></div>
            <div class="row"><span class="lbl">Tel. urgence</span><span class="val">{{ $patient->emergency_phone??'-' }}</span></div>
        </div>
    </div>
    <div class="card">
        <div class="section">Historique des Appointments</div>
        <table>
            <thead><tr><th>Date</th><th>Time</th><th>Status</th><th>Consultation</th><th>Prescription</th></tr></thead>
            <tbody>
                @forelse($rdvs as $rdv)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                    <td>{{ substr($rdv->heure_rdv,0,5) }}</td>
                    <td>
                        @if($rdv->statut==='Confirmed')<span class="pill pg">Confirmed</span>
                        @elseif($rdv->statut==='en_attente')<span class="pill pa">Pending</span>
                        @else<span class="pill pr">Cancelled</span>@endif
                    </td>
                    <td>
                        @if($rdv->consultation)
                            <a href="{{ route('medecin.consultations.show', $rdv->consultation) }}" class="btn btn-blue" style="padding:5px 10px;font-size:11px">View</a>
                        @else <span style="color:#94a3b8"> - </span> @endif
                    </td>
                    <td>
                        @if($rdv->consultation?->Prescription)
                            <a href="{{ route('medecin.Prescriptions.pdf', $rdv->consultation->Prescription) }}" class="btn btn-green" style="padding:5px 10px;font-size:11px">PDF</a>
                        @else <span style="color:#94a3b8"> - </span> @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:24px">Aucun Appointments.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>









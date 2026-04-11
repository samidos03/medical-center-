<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultations - Bahjawa Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Segoe UI,system-ui,sans-serif;background:#f0f7ff;min-height:100vh;padding:24px}
        .header{background:linear-gradient(135deg,#1D9E75,#3B6D11);border-radius:18px;padding:24px 28px;color:white;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:22px;font-weight:700}
        .header p{font-size:13px;opacity:.8;margin-top:4px}
        .card{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
        .card-header{padding:18px 22px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
        .card-header h2{font-size:15px;font-weight:700;color:#0f172a}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc}
        td{padding:13px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
        tr:last-child td{border-bottom:none}
        .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .pg{background:#f0fdf4;color:#16a34a}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:10px;font-size:12px;font-weight:600;text-decoration:none;transition:all .2s;border:none;cursor:pointer}
        .btn-blue{background:#eff6ff;color:#0369a1}
        .btn-green{background:linear-gradient(135deg,#1D9E75,#3B6D11);color:white}
        .btn-red{background:#fef2f2;color:#dc2626}
        .alert{border-radius:12px;padding:12px 16px;margin-bottom:20px;font-size:13px}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a}
    </style>
</head>
<body>
<div class="header">
    <div>
        <h1>My Consultations</h1>
        <p>{{ auth()->user()->name }} � Bahjawa Medical Center</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('medecin.consultations.create') }}" class="btn btn-green">+ New Consultation</a>
        <a href="{{ route('medecin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.2);color:white">Dashboard</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>{{ $consultations->total() }} Consultations</h2>
    </div>
    <table>
        <thead><tr><th>Patient</th><th>Date</th><th>Summary</th><th>Prescription</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($consultations as $c)
            <tr>
                <td style="font-weight:600">{{ $c->patient->user->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($c->date_consultation)->format('d/m/Y') }}</td>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ Str::limit($c->compte_rendu, 60) }}</td>
                <td>
                    @if($c->Prescription)
                        <span class="pill pg">Yes</span>
                    @else
                        <span style="color:#94a3b8;font-size:12px">No</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('medecin.consultations.show', $c) }}" class="btn btn-blue">View</a>
                        @if($c->Prescription)
                            <a href="{{ route('medecin.Prescriptions.pdf', $c->Prescription) }}" class="btn btn-green">PDF</a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:32px">None consultation.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($consultations->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #f1f5f9">{{ $consultations->links() }}</div>
    @endif
</div>
</body>
</html>











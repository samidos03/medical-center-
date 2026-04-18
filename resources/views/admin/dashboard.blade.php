@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'General Overview -')

@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<style>
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
    .stat-card{background:white;border-radius:18px;padding:20px;border:1px solid #e2e8f0;transition:transform .2s;overflow:hidden;position:relative}
    .stat-card:hover{transform:translateY(-2px)}
    .stat-card::after{content:"";position:absolute;top:-20px;right:-20px;width:80px;height:80px;border-radius:50%;opacity:.06}
    .stat-blue::after{background:#0369a1}
    .stat-green::after{background:#059669}
    .stat-amber::after{background:#d97706}
    .stat-purple::after{background:#7c3aed}
    .stat-icon{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
    .si-blue{background:#eff6ff}
    .si-green{background:#f0fdf4}
    .si-amber{background:#fffbeb}
    .si-purple{background:#faf5ff}
    .stat-num{font-size:32px;font-weight:700;color:#0f172a;line-height:1}
    .stat-label{font-size:13px;color:#64748b;margin-top:4px}
    .stat-badge{display:inline-block;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;margin-top:10px}
    .sb-blue{background:#eff6ff;color:#0369a1}
    .sb-green{background:#f0fdf4;color:#059669}
    .sb-amber{background:#fffbeb;color:#d97706}
    .sb-purple{background:#faf5ff;color:#7c3aed}
    .charts-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
    .chart-full{grid-column:1/-1}
    .chart-card{background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0}
    .chart-card h3{font-size:15px;font-weight:700;color:#0f172a;margin-bottom:2px}
    .chart-card .chart-sub{font-size:12px;color:#94a3b8;margin-bottom:18px}
    .tables-row{display:grid;grid-template-columns:3fr 2fr;gap:20px}
    .tcard{background:white;border-radius:18px;border:1px solid #e2e8f0;overflow:hidden}
    .tcard-header{padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center}
    .tcard-header h3{font-size:15px;font-weight:700;color:#0f172a}
    .tcard-header a{font-size:12px;color:#0369a1;text-decoration:none;font-weight:600}
    table{width:100%;border-collapse:collapse}
    th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc}
    td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#f8fafc}
    .avatar{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0}
    .pill{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block}
    .pg{background:#f0fdf4;color:#16a34a}
    .pa{background:#fffbeb;color:#d97706}
    .pr{background:#fef2f2;color:#dc2626}
    .doctor-row{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid #f8fafc;transition:background .15s}
    .doctor-row:last-child{border-bottom:none}
    .doctor-row:hover{background:#f8fafc}
    .dr-info{flex:1}
    .dr-name{font-size:13px;font-weight:600;color:#0f172a}
    .dr-spec{font-size:11px;color:#94a3b8}
    .rdv-badge{font-size:12px;font-weight:700;color:#0369a1;background:#eff6ff;padding:4px 12px;border-radius:20px}
    .donut-legend{display:flex;flex-direction:column;gap:10px;margin-top:16px}
    .legend-row{display:flex;justify-content:space-between;align-items:center;font-size:13px}
    .legend-dot{width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:8px}
</style>
@endpush

@section('content')

{{-- STATS CARDS --}}
<div class="stats-grid">
    <div class="stat-card stat-blue">
        <div class="stat-icon si-blue">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="rgba(255,255,255,.15)" stroke="white" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
        </div>
        <div class="stat-num">{{ $stats['patients'] }}</div>
        <div class="stat-label">Total Patients</div>
        <span class="stat-badge sb-blue">Registered</span>
    </div>
    <div class="stat-card stat-green">
        <div class="stat-icon si-green">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="rgba(255,255,255,.15)" stroke="white" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
        </div>
        <div class="stat-num">{{ $stats['medecins'] }}</div>
        <div class="stat-label">Doctors</div>
        <span class="stat-badge sb-green">On duty</span>
    </div>
    <div class="stat-card stat-amber">
        <div class="stat-icon si-amber">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="rgba(255,255,255,.15)" stroke="white" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
        </div>
        <div class="stat-num">{{ $stats['rdv_today'] }}</div>
        <div class="stat-label">Today's Appts</div>
        <span class="stat-badge sb-amber">Today</span>
    </div>
    <div class="stat-card stat-purple">
        <div class="stat-icon si-purple">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="14" fill="rgba(255,255,255,.15)" stroke="white" stroke-width="1.5"/><path d="M20 10v20M10 20h20" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
        </div>
        <div class="stat-num">{{ $stats['rdv_total'] }}</div>
        <div class="stat-label">Total RDV</div>
        <span class="stat-badge sb-purple">Tous statuts</span>
    </div>
</div>

{{-- GRAPHIQUE Main - RDV + PATIENTS PAR MOIS --}}
<div class="chart-card chart-full" style="margin-bottom:20px">
    <h3>Evolution mensuelle</h3>
    <p class="chart-sub">Appointments et nouveaux patients � Year {{ date('Y') }}</p>
    <canvas id="evolutionChart" height="70"></canvas>
</div>

{{-- GRAPHIQUES SECONDAIRES --}}
<div class="charts-row" style="margin-bottom:24px">
    {{-- Camembert statuts --}}
    <div class="chart-card">
        <h3>Status Distribution</h3>
        <p class="chart-sub">Total : {{ $stats['rdv_total'] }} Appointments</p>
        <div style="display:flex;align-items:center;gap:24px">
            <div style="flex:1;max-width:200px;margin:0 auto">
                <canvas id="statutChart" height="200"></canvas>
            </div>
            <div class="donut-legend" style="flex:1">
                <div class="legend-row">
                    <div><span class="legend-dot" style="background:#22c55e"></span>Confirmed</div>
                    <span style="font-weight:700;color:#0f172a">{{ $stats['confirmes'] }}</span>
                </div>
                <div class="legend-row">
                    <div><span class="legend-dot" style="background:#f59e0b"></span>Pending</div>
                    <span style="font-weight:700;color:#0f172a">{{ $stats['en_attente'] }}</span>
                </div>
                <div class="legend-row">
                    <div><span class="legend-dot" style="background:#ef4444"></span>Cancelled</div>
                    <span style="font-weight:700;color:#0f172a">{{ $stats['annules'] }}</span>
                </div>
                <div style="margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9">
                    @php $taux = $stats['rdv_total'] > 0 ? round(($stats['confirmes'] / $stats['rdv_total']) * 100) : 0; @endphp
                    <div style="font-size:12px;color:#64748b">Confirm Password rate</div>
                    <div style="font-size:24px;font-weight:700;color:#22c55e">{{ $taux }}%</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Distribution --}}
    <div class="chart-card">
        <h3>Users Distribution</h3>
        <p class="chart-sub">Total : {{ $stats['users'] }} accounts</p>
        <canvas id="usersChart" height="200"></canvas>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:16px">
            <div style="text-align:center;padding:8px;background:#eff6ff;border-radius:10px">
                <div style="font-size:18px;font-weight:700;color:#0369a1">{{ $stats['patients'] }}</div>
                <div style="font-size:11px;color:#64748b">Patients</div>
            </div>
            <div style="text-align:center;padding:8px;background:#f0fdf4;border-radius:10px">
                <div style="font-size:18px;font-weight:700;color:#059669">{{ $stats['medecins'] }}</div>
                <div style="font-size:11px;color:#64748b">Doctors</div>
            </div>
            <div style="text-align:center;padding:8px;background:#fffbeb;border-radius:10px">
                <div style="font-size:18px;font-weight:700;color:#d97706">{{ $stats['secretaires'] }}</div>
                <div style="font-size:11px;color:#64748b">Secretaires</div>
            </div>
            <div style="text-align:center;padding:8px;background:#faf5ff;border-radius:10px">
                <div style="font-size:18px;font-weight:700;color:#7c3aed">1</div>
                <div style="font-size:11px;color:#64748b">Admin</div>
            </div>
        </div>
    </div>
</div>

{{-- TABLES --}}
<div class="tables-row">
    <div class="tcard">
        <div class="tcard-header">
            <h3>Recent Appointments</h3>
            <a href="{{ route('admin.rendezvous.index') }}">View all ?</a>
        </div>
        <table>
            <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($recentRdv as $rdv)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div class="avatar" style="background:#eff6ff;color:#0369a1">{{ strtoupper(substr($rdv->patient->user->name??'?',0,2)) }}</div>
                            <span style="font-weight:500">{{ $rdv->patient->user->name??'-' }}</span>
                        </div>
                    </td>
                    <td style="color:#64748b">{{ $rdv->medecin->user->name??'-' }}</td>
                    <td style="color:#64748b">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                    <td>
                        @if($rdv->statut==='Confirmed') <span class="pill pg">Confirmed</span>
                        @elseif($rdv->statut==='en_attente') <span class="pill pa">Pending</span>
                        @else <span class="pill pr">Cancelled</span> @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:24px">Aucun Appointments.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="tcard">
        <div class="tcard-header">
            <h3>Most Active Doctors</h3>
            <a href="{{ route('admin.users.index') }}?role=medecin">View all ?</a>
        </div>
        @forelse($medecinsActifs as $m)
        <div class="doctor-row">
            <div class="avatar" style="background:#f0fdf4;color:#059669">{{ strtoupper(substr($m->user->name??'?',0,2)) }}</div>
            <div class="dr-info">
                <div class="dr-name">{{ $m->user->name??'-' }}</div>
                <div class="dr-spec">{{ $m->specialite->nom??'-' }}</div>
            </div>
            <span class="rdv-badge">{{ $m->rendezvous_count }} RDV</span>
        </div>
        @empty
        <div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px">Aucun medecin.</div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
const mois = ['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'];
const rdvData = @json($rdvMoisData);
const patientsData = @json($patientsMoisData);

// Graphique evolution
new Chart(document.getElementById('evolutionChart'), {
    type: 'line',
    data: {
        labels: mois,
        datasets: [
            {
                label: 'Appointments',
                data: rdvData,
                borderColor: '#0369a1',
                backgroundColor: 'rgba(3,105,161,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#0369a1',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            },
            {
                label: 'Nouveaux patients',
                data: patientsData,
                borderColor: '#059669',
                backgroundColor: 'rgba(5,150,105,0.06)',
                borderWidth: 2.5,
                pointBackgroundColor: '#059669',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top', labels: { usePointStyle: true, padding: 20, font: { size: 12 } } }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { grid: { display: false } }
        }
    }
});

// Camembert statuts
new Chart(document.getElementById('statutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Confirmed', 'Pending', 'Cancelled'],
        datasets: [{
            data: [{{ $stats['confirmes'] }}, {{ $stats['en_attente'] }}, {{ $stats['annules'] }}],
            backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        cutout: '70%'
    }
});

// Graphique Users
new Chart(document.getElementById('usersChart'), {
    type: 'bar',
    data: {
        labels: ['Patients', 'Doctors', 'Secretaires', 'Admins'],
        datasets: [{
            data: [{{ $stats['patients'] }}, {{ $stats['medecins'] }}, {{ $stats['secretaires'] }}, 1],
            backgroundColor: ['rgba(3,105,161,0.15)', 'rgba(5,150,105,0.15)', 'rgba(217,119,6,0.15)', 'rgba(124,58,237,0.15)'],
            borderColor: ['#0369a1', '#059669', '#d97706', '#7c3aed'],
            borderWidth: 2,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush













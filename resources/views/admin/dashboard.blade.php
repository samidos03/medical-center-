<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — Bahjawa Medical</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    :root {
      --bg: #f0f4f8;
      --white: #ffffff;
      --accent: #6366f1;
      --text-primary: #0f172a;
      --text-secondary: #64748b;
      --text-muted: #94a3b8;
      --border: #e8edf2;
      --card: #ffffff;
      --radius: 16px;
      --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
      --shadow-md: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      color: var(--text-primary)
    }

    /* ── SIDEBAR BLEUE (même que l'original) ── */
    .sidebar {
      width: 240px;
      min-height: 100vh;
      background: linear-gradient(180deg, #1565c0, #1976d2, #42a5f5);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 50;
      transition: transform .3s ease
    }

    .sidebar-logo {
      padding: 22px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, .12)
    }

    .logo-inner {
      display: flex;
      align-items: center;
      gap: 10px
    }

    .logo-icon {
      width: 38px;
      height: 38px;
      background: white;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0
    }

    .logo-name {
      font-size: 14px;
      font-weight: 700;
      color: #fff;
      line-height: 1.3
    }

    .logo-sub {
      font-size: 10px;
      color: rgba(255, 255, 255, .6);
      display: block
    }

    .sidebar-nav {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto
    }

    .nav-section {
      font-size: 9px;
      font-weight: 700;
      color: rgba(255, 255, 255, .4);
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 0 10px;
      margin: 16px 0 6px
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 10px;
      color: rgba(255, 255, 255, .75);
      font-size: 13px;
      font-weight: 500;
      text-decoration: none;
      transition: all .18s;
      margin-bottom: 2px;
      cursor: pointer
    }

    .nav-item:hover {
      background: rgba(255, 255, 255, .12);
      color: white
    }

    .nav-item.active {
      background: rgba(255, 255, 255, .22);
      color: white;
      font-weight: 600
    }

    .nav-item svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0
    }

    .nav-badge {
      margin-left: auto;
      background: rgba(255, 255, 255, .2);
      color: white;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 20px
    }

    .sidebar-footer {
      padding: 14px 12px;
      border-top: 1px solid rgba(255, 255, 255, .12)
    }

    .user-card {
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .15);
      border-radius: 12px;
      padding: 11px 12px
    }

    .user-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
      color: #1565c0;
      flex-shrink: 0
    }

    .user-name {
      font-size: 13px;
      font-weight: 600;
      color: white
    }

    .user-role {
      font-size: 10px;
      color: rgba(255, 255, 255, .55)
    }

    .btn-logout {
      width: 100%;
      padding: 9px;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .25);
      border-radius: 10px;
      color: white;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      letter-spacing: .2px
    }

    .btn-logout:hover {
      background: rgba(255, 255, 255, .25)
    }

    /* ── MAIN ── */
    .main {
      flex: 1;
      margin-left: 240px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: margin-left .3s ease
    }

    .topbar {
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 40;
      gap: 12px
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 12px
    }

    .topbar-title h1 {
      font-size: 17px;
      font-weight: 700;
      color: var(--text-primary)
    }

    .topbar-title p {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 1px
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px
    }

    .topbar-date {
      font-size: 12px;
      color: var(--text-secondary);
      background: var(--bg);
      padding: 6px 12px;
      border-radius: 8px;
      border: 1px solid var(--border);
      white-space: nowrap
    }

    .notif-btn {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      border: 1px solid var(--border);
      background: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--text-secondary);
      position: relative;
      flex-shrink: 0
    }

    .notif-dot {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 7px;
      height: 7px;
      background: #ef4444;
      border-radius: 50%;
      border: 1.5px solid white
    }

    .hamburger {
      display: none;
      width: 34px;
      height: 34px;
      border-radius: 9px;
      border: 1px solid var(--border);
      background: var(--white);
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--text-secondary);
      flex-shrink: 0
    }

    /* ── CONTENT ── */
    .content {
      padding: 24px 28px;
      flex: 1
    }

    /* ── STATS ── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 22px
    }

    .stat-card {
      background: var(--card);
      border-radius: var(--radius);
      padding: 18px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md)
    }

    .stat-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 12px
    }

    .stat-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0
    }

    .stat-trend {
      font-size: 11px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 20px
    }

    .trend-up {
      background: #f0fdf4;
      color: #16a34a
    }

    .trend-same {
      background: #f8fafc;
      color: #64748b
    }

    .stat-num {
      font-size: 28px;
      font-weight: 700;
      color: var(--text-primary);
      line-height: 1;
      margin-bottom: 4px
    }

    .stat-label {
      font-size: 12px;
      color: var(--text-secondary);
      font-weight: 500
    }

    .stat-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 20px;
      margin-top: 8px
    }

    .stat-glow {
      position: absolute;
      top: -30px;
      right: -30px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      opacity: .06
    }

    /* ── CHARTS ── */
    .chart-card {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow)
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 16px
    }

    .chart-header h3 {
      font-size: 14px;
      font-weight: 700;
      color: var(--text-primary)
    }

    .chart-header p {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 2px
    }

    .chart-badge {
      font-size: 10px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
      background: #eff6ff;
      color: #0369a1;
      white-space: nowrap
    }

    .charts-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 18px
    }

    /* ── TABLES ── */
    .tables-row {
      display: grid;
      grid-template-columns: 3fr 2fr;
      gap: 16px
    }

    .tcard {
      background: var(--card);
      border-radius: var(--radius);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      overflow: hidden
    }

    .tcard-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center
    }

    .tcard-header h3 {
      font-size: 14px;
      font-weight: 700;
      color: var(--text-primary)
    }

    .tcard-header a {
      font-size: 12px;
      color: #1976d2;
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 4px
    }

    table {
      width: 100%;
      border-collapse: collapse
    }

    th {
      text-align: left;
      padding: 10px 16px;
      font-size: 10px;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: .6px;
      background: #f8fafc;
      border-bottom: 1px solid var(--border)
    }

    td {
      padding: 11px 16px;
      font-size: 13px;
      color: var(--text-primary);
      border-bottom: 1px solid #f8fafc
    }

    tr:last-child td {
      border-bottom: none
    }

    tr:hover td {
      background: #fafbfc
    }

    .avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 11px;
      flex-shrink: 0
    }

    .pill {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 5px
    }

    .pill::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      flex-shrink: 0
    }

    .pg {
      background: #f0fdf4;
      color: #16a34a
    }

    .pg::before {
      background: #16a34a
    }

    .pa {
      background: #fffbeb;
      color: #d97706
    }

    .pa::before {
      background: #d97706
    }

    .pr {
      background: #fef2f2;
      color: #dc2626
    }

    .pr::before {
      background: #dc2626
    }

    .doctor-row {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-bottom: 1px solid #f8fafc;
      transition: background .15s
    }

    .doctor-row:last-child {
      border-bottom: none
    }

    .doctor-row:hover {
      background: #fafbfc
    }

    .dr-info {
      flex: 1;
      min-width: 0
    }

    .dr-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .dr-spec {
      font-size: 11px;
      color: var(--text-muted)
    }

    .rdv-badge {
      font-size: 12px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      white-space: nowrap;
      flex-shrink: 0
    }

    .donut-wrap {
      display: flex;
      align-items: center;
      gap: 20px
    }

    .donut-legend {
      display: flex;
      flex-direction: column;
      gap: 10px;
      flex: 1
    }

    .legend-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      color: var(--text-secondary)
    }

    .legend-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 7px;
      flex-shrink: 0
    }

    .legend-val {
      font-weight: 700;
      color: var(--text-primary)
    }

    .rate-box {
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid var(--border)
    }

    .rate-label {
      font-size: 11px;
      color: var(--text-muted)
    }

    .rate-val {
      font-size: 22px;
      font-weight: 700;
      color: #22c55e;
      margin-top: 2px
    }

    /* OVERLAY */
    .overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .4);
      z-index: 49
    }

    .overlay.open {
      display: block
    }

    /* ── RESPONSIVE ── */
    @media(max-width:1200px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .charts-row {
        grid-template-columns: 1fr
      }

      .tables-row {
        grid-template-columns: 1fr
      }
    }

    @media(max-width:900px) {
      .sidebar {
        transform: translateX(-100%)
      }

      .sidebar.open {
        transform: translateX(0)
      }

      .main {
        margin-left: 0
      }

      .hamburger {
        display: flex
      }

      .topbar {
        padding: 12px 16px
      }

      .content {
        padding: 16px 14px
      }

      .topbar-date {
        display: none
      }
    }

    @media(max-width:600px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px
      }

      .stat-card {
        padding: 14px
      }

      .stat-num {
        font-size: 22px
      }

      .content {
        padding: 12px 10px
      }

      .topbar-title h1 {
        font-size: 15px
      }

      table thead {
        display: none
      }

      table tr {
        display: flex;
        flex-direction: column;
        padding: 10px 12px;
        border-bottom: 1px solid var(--border)
      }

      table td {
        padding: 3px 0;
        border: none;
        font-size: 12px
      }

      table td::before {
        content: attr(data-label);
        font-size: 10px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px
      }
    }

    @media(max-width:400px) {
      .stats-grid {
        grid-template-columns: 1fr
      }
    }
  </style>
</head>

<body>

  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

  <!-- SIDEBAR BLEUE -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
      <div class="logo-inner">
        <div class="logo-icon">
          <svg width="22" height="22" viewBox="0 0 40 40" fill="none">
            <circle cx="20" cy="20" r="14" fill="#e0f2fe" stroke="#0284c7" stroke-width="1.5" />
            <path d="M20 10v20M10 20h20" stroke="#0284c7" stroke-width="2.5" stroke-linecap="round" />
          </svg>
        </div>
        <div>
          <span class="logo-name">Bahjawa Medical</span>
          <span class="logo-sub">Administration Panel</span>
        </div>
      </div>
    </div>
<nav class="sidebar-nav">
    <div class="nav-section">Main</div>

    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    <a href="{{ route('admin.users.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Users
        <span class="nav-badge">{{ \App\Models\User::count() }}</span>
    </a>

    <a href="{{ route('admin.specialites.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
        </svg>
        Specialities
    </a>

    <a href="{{ route('admin.patients.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Patients
        <span class="nav-badge">{{ \App\Models\Patient::count() }}</span>
    </a>

    <a href="{{ route('admin.rendezvous.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Appointments
        <span class="nav-badge">{{ \App\Models\Rendezvous::count() }}</span>
    </a>

    <div class="nav-section">System</div>

    <a href="{{ route('admin.users.create') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add User
    </a>
</nav>
    <div class="sidebar-footer">
      <div class="user-card">
        <div class="user-row">
          <div class="user-avatar">AD</div>
          <div>
            <div class="user-name">Admin</div>
            <div class="user-role">Administrator</div>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout">Sign Out</button>
        </form>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main" id="main">
    <div class="topbar">
      <div class="topbar-left">
        <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="topbar-title">
          <h1>Dashboard</h1>
          <p>General Overview — Bahjawa Medical Center</p>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-date">Saturday, 02 May 2026</div>
        <div class="notif-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          <div class="notif-dot"></div>
        </div>
      </div>
    </div>

    <div class="content">
      <!-- STATS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-glow" style="background:#0369a1"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#eff6ff">
              <svg width="20" height="20" fill="none" stroke="#0369a1" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <span class="stat-trend trend-up">+2</span>
          </div>
          <div class="stat-num">7</div>
          <div class="stat-label">Total Patients</div>
          <span class="stat-badge" style="background:#eff6ff;color:#0369a1">Registered</span>
        </div>
        <div class="stat-card">
          <div class="stat-glow" style="background:#059669"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#f0fdf4">
              <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </div>
            <span class="stat-trend trend-same">Stable</span>
          </div>
          <div class="stat-num">4</div>
          <div class="stat-label">Doctors</div>
          <span class="stat-badge" style="background:#f0fdf4;color:#059669">On duty</span>
        </div>
        <div class="stat-card">
          <div class="stat-glow" style="background:#d97706"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#fffbeb">
              <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <span class="stat-trend trend-same">—</span>
          </div>
          <div class="stat-num">0</div>
          <div class="stat-label">Today's Appts</div>
          <span class="stat-badge" style="background:#fffbeb;color:#d97706">Today</span>
        </div>
        <div class="stat-card">
          <div class="stat-glow" style="background:#7c3aed"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#faf5ff">
              <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <span class="stat-trend trend-up">+1</span>
          </div>
          <div class="stat-num">6</div>
          <div class="stat-label">Total RDV</div>
          <span class="stat-badge" style="background:#faf5ff;color:#7c3aed">Tous statuts</span>
        </div>
      </div>

      <!-- CHART EVOLUTION -->
      <div class="chart-card" style="margin-bottom:16px">
        <div class="chart-header">
          <div>
            <h3>Monthly Evolution</h3>
            <p>Appointments & new patients — 2026</p>
          </div>
          <span class="chart-badge">Year 2026</span>
        </div>
        <canvas id="evolutionChart" height="65"></canvas>
      </div>

      <!-- CHARTS ROW -->
      <div class="charts-row">
        <div class="chart-card">
          <div class="chart-header">
            <div>
              <h3>Status Distribution</h3>
              <p>Total : 6 appointments</p>
            </div>
          </div>
          <div class="donut-wrap">
            <div style="width:140px;flex-shrink:0"><canvas id="statutChart"></canvas></div>
            <div class="donut-legend">
              <div class="legend-row">
                <div><span class="legend-dot" style="background:#22c55e"></span>Confirmed</div><span class="legend-val">1</span>
              </div>
              <div class="legend-row">
                <div><span class="legend-dot" style="background:#f59e0b"></span>Pending</div><span class="legend-val">1</span>
              </div>
              <div class="legend-row">
                <div><span class="legend-dot" style="background:#ef4444"></span>Cancelled</div><span class="legend-val">4</span>
              </div>
              <div class="rate-box">
                <div class="rate-label">Confirmation rate</div>
                <div class="rate-val">17%</div>
              </div>
            </div>
          </div>
        </div>
        <div class="chart-card">
          <div class="chart-header">
            <div>
              <h3>Users Distribution</h3>
              <p>Total : 11 accounts</p>
            </div>
          </div>
          <canvas id="usersChart" height="140"></canvas>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:14px">
            <div style="text-align:center;padding:8px;background:#eff6ff;border-radius:10px">
              <div style="font-size:17px;font-weight:700;color:#0369a1">7</div>
              <div style="font-size:10px;color:#64748b;font-weight:500">Patients</div>
            </div>
            <div style="text-align:center;padding:8px;background:#f0fdf4;border-radius:10px">
              <div style="font-size:17px;font-weight:700;color:#059669">4</div>
              <div style="font-size:10px;color:#64748b;font-weight:500">Doctors</div>
            </div>
            <div style="text-align:center;padding:8px;background:#fffbeb;border-radius:10px">
              <div style="font-size:17px;font-weight:700;color:#d97706">1</div>
              <div style="font-size:10px;color:#64748b;font-weight:500">Secretary</div>
            </div>
            <div style="text-align:center;padding:8px;background:#faf5ff;border-radius:10px">
              <div style="font-size:17px;font-weight:700;color:#7c3aed">1</div>
              <div style="font-size:10px;color:#64748b;font-weight:500">Admin</div>
            </div>
          </div>
        </div>
      </div>

      <!-- TABLES -->
      <div class="tables-row" style="margin-top:16px">
        <div class="tcard">
          <div class="tcard-header">
            <h3>Recent Appointments</h3>
            <a href="#">View all <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg></a>
          </div>
          <table>
            <thead>
              <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Patient">
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar" style="background:#eff6ff;color:#0369a1">EC</div><span style="font-weight:500">Echchafiai Aicha</span>
                  </div>
                </td>
                <td data-label="Doctor" style="color:#64748b">Dr. Youssef Alaoui</td>
                <td data-label="Date" style="color:#64748b">04/12/2026</td>
                <td data-label="Status"><span class="pill pr">Cancelled</span></td>
              </tr>
              <tr>
                <td data-label="Patient">
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar" style="background:#f0fdf4;color:#059669">MA</div><span style="font-weight:500">Mariam Farah</span>
                  </div>
                </td>
                <td data-label="Doctor" style="color:#64748b">Ali Doubabi</td>
                <td data-label="Date" style="color:#64748b">04/12/2026</td>
                <td data-label="Status"><span class="pill pr">Cancelled</span></td>
              </tr>
              <tr>
                <td data-label="Patient">
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar" style="background:#fffbeb;color:#d97706">MO</div><span style="font-weight:500">Mohamed Khalil</span>
                  </div>
                </td>
                <td data-label="Doctor" style="color:#64748b">Dr. Youssef Alaoui</td>
                <td data-label="Date" style="color:#64748b">12/04/2026</td>
                <td data-label="Status"><span class="pill pr">Cancelled</span></td>
              </tr>
              <tr>
                <td data-label="Patient">
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar" style="background:#faf5ff;color:#7c3aed">FA</div><span style="font-weight:500">Fatima Zahra</span>
                  </div>
                </td>
                <td data-label="Doctor" style="color:#64748b">Dr. Youssef Alaoui</td>
                <td data-label="Date" style="color:#64748b">13/04/2026</td>
                <td data-label="Status"><span class="pill pa">Pending</span></td>
              </tr>
              <tr>
                <td data-label="Patient">
                  <div style="display:flex;align-items:center;gap:8px">
                    <div class="avatar" style="background:#fef2f2;color:#dc2626">HA</div><span style="font-weight:500">Hassan Berrada</span>
                  </div>
                </td>
                <td data-label="Doctor" style="color:#64748b">Dr. Youssef Alaoui</td>
                <td data-label="Date" style="color:#64748b">14/04/2026</td>
                <td data-label="Status"><span class="pill pr">Cancelled</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="tcard">
          <div class="tcard-header">
            <h3>Most Active Doctors</h3>
            <a href="#">View all <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg></a>
          </div>
          <div class="doctor-row">
            <div class="avatar" style="background:#f0fdf4;color:#059669">YA</div>
            <div class="dr-info">
              <div class="dr-name">Dr. Youssef Alaoui</div>
              <div class="dr-spec">Medecine generale</div>
            </div>
            <span class="rdv-badge" style="background:#eff6ff;color:#0369a1">5 RDV</span>
          </div>
          <div class="doctor-row">
            <div class="avatar" style="background:#f0fdf4;color:#059669">AL</div>
            <div class="dr-info">
              <div class="dr-name">Ali Doubabi</div>
              <div class="dr-spec">Medecine generale</div>
            </div>
            <span class="rdv-badge" style="background:#eff6ff;color:#0369a1">1 RDV</span>
          </div>
          <div class="doctor-row">
            <div class="avatar" style="background:#f0fdf4;color:#059669">FB</div>
            <div class="dr-info">
              <div class="dr-name">Dr. Fatima Benali</div>
              <div class="dr-spec">Cardiologie</div>
            </div>
            <span class="rdv-badge" style="background:#f8fafc;color:#94a3b8">0 RDV</span>
          </div>
          <div class="doctor-row">
            <div class="avatar" style="background:#f0fdf4;color:#059669">KT</div>
            <div class="dr-info">
              <div class="dr-name">Dr. Karim Tazi</div>
              <div class="dr-spec">Pediatrie</div>
            </div>
            <span class="rdv-badge" style="background:#f8fafc;color:#94a3b8">0 RDV</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
      document.getElementById('overlay').classList.toggle('open');
    }
    window.addEventListener('resize', () => {
      if (window.innerWidth > 900) {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('open');
      }
    });
    const mois = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'];
    new Chart(document.getElementById('evolutionChart'), {
      type: 'line',
      data: {
        labels: mois,
        datasets: [{
            label: 'Appointments',
            data: [0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0],
            borderColor: '#1976d2',
            backgroundColor: 'rgba(25,118,210,0.06)',
            borderWidth: 2.5,
            pointBackgroundColor: '#1976d2',
            pointRadius: 4,
            fill: true,
            tension: .4
          },
          {
            label: 'New Patients',
            data: [0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0],
            borderColor: '#06b6d4',
            backgroundColor: 'rgba(6,182,212,0.05)',
            borderWidth: 2.5,
            pointBackgroundColor: '#06b6d4',
            pointRadius: 4,
            fill: true,
            tension: .4
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 12
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            },
            grid: {
              color: 'rgba(0,0,0,0.04)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
    new Chart(document.getElementById('statutChart'), {
      type: 'doughnut',
      data: {
        labels: ['Confirmed', 'Pending', 'Cancelled'],
        datasets: [{
          data: [1, 1, 4],
          backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        cutout: '72%'
      }
    });
    new Chart(document.getElementById('usersChart'), {
      type: 'bar',
      data: {
        labels: ['Patients', 'Doctors', 'Secretary', 'Admin'],
        datasets: [{
          data: [7, 4, 1, 1],
          backgroundColor: ['rgba(3,105,161,.12)', 'rgba(5,150,105,.12)', 'rgba(217,119,6,.12)', 'rgba(124,58,237,.12)'],
          borderColor: ['#0369a1', '#059669', '#d97706', '#7c3aed'],
          borderWidth: 2,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            },
            grid: {
              color: 'rgba(0,0,0,0.04)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  </script>
</body>
</html>
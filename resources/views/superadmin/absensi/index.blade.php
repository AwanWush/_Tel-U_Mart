{{-- resources/views/superadmin/absensi/index.blade.php --}}
<x-app-layout>

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    * { box-sizing: border-box; }

    body, .absensi-root {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #ffffff;
    }

    /* ── CSS Variables ── */
    :root {
        --maroon:       #5B000B;
        --maroon-deep:  #3D0008;
        --maroon-light: #F9ECED;
        --maroon-mid:   #8B001A;
        --gold:         #C9993A;
        --gold-light:   #FDF4E3;
        --surface:      #FFFFFF;
        --bg:           #F5F4F0;
        --border:       #E8E6E1;
        --text-1:       #1A1714;
        --text-2:       #6B6560;
        --text-3:       #A8A29C;
        --radius-xl:    1.5rem;
        --radius-2xl:   2rem;
        --shadow-sm:    0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md:    0 4px 16px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
        --shadow-lg:    0 12px 40px rgba(0,0,0,.10), 0 4px 12px rgba(0,0,0,.06);
    }

    .absensi-root {
        min-height: 100vh;
        padding: 80px 0 60px;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-3);
        margin-bottom: 28px;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .breadcrumb a {
        color: var(--maroon);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: opacity .2s;
    }
    .breadcrumb a:hover { opacity: .7; }
    .breadcrumb-sep { color: var(--border); font-size: 16px; line-height: 1; }

    /* ── Page Header ── */
    .page-header {
        background: var(--maroon-deep);
        border-radius: var(--radius-2xl);
        padding: 36px 40px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(201,153,58,.12);
        pointer-events: none;
    }
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 200px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }
    .page-header-text h2 {
        font-size: 28px;
        font-weight: 900;
        color: #fff;
        letter-spacing: -.02em;
        line-height: 1.1;
        margin: 0 0 6px;
    }
    .page-header-text p {
        font-size: 13px;
        color: rgba(255,255,255,.5);
        margin: 0;
        font-weight: 500;
    }
    .page-header-icon {
        width: 64px; height: 64px;
        background: rgba(201,153,58,.18);
        border: 1.5px solid rgba(201,153,58,.3);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .page-header-icon i { font-size: 26px; color: var(--gold); }

    /* ── Stat Pills (in header) ── */
    .header-stats {
        display: flex;
        gap: 12px;
        position: relative; z-index: 1;
        flex-shrink: 0;
    }
    .stat-pill {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 14px;
        padding: 14px 20px;
        text-align: center;
    }
    .stat-pill-val {
        font-size: 24px;
        font-weight: 900;
        color: #fff;
        line-height: 1;
        display: block;
    }
    .stat-pill-lbl {
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,.45);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-top: 4px;
        display: block;
    }

    /* ── Filter Bar ── */
    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-2xl);
        padding: 12px 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
        box-shadow: var(--shadow-sm);
    }
    .filter-tabs {
        display: flex;
        background: var(--bg);
        border-radius: 12px;
        padding: 4px;
        gap: 3px;
    }
    .filter-tab {
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        text-decoration: none;
        color: var(--text-3);
        transition: all .18s;
        white-space: nowrap;
    }
    .filter-tab:hover { color: var(--text-1); background: rgba(0,0,0,.04); }
    .filter-tab.active {
        background: var(--maroon);
        color: #fff;
        box-shadow: 0 2px 8px rgba(91,0,11,.25);
    }
    .divider-v {
        width: 1px; height: 32px;
        background: var(--border);
        flex-shrink: 0;
    }
    .date-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .date-field {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 8px 14px;
        transition: border-color .18s;
    }
    .date-field:focus-within { border-color: var(--maroon); }
    .date-field i { font-size: 11px; color: var(--maroon); }
    .date-field input[type="date"] {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-1);
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: transparent;
        border: none;
        outline: none;
        cursor: pointer;
    }
    .date-sep { color: var(--text-3); font-size: 12px; font-weight: 700; }
    .btn-search {
        background: var(--maroon);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 9px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        cursor: pointer;
        font-family: inherit;
        transition: background .18s, transform .12s;
        display: flex; align-items: center; gap: 6px;
    }
    .btn-search:hover { background: var(--maroon-mid); transform: translateY(-1px); }
    .btn-search:active { transform: translateY(0); }
    .spacer { flex: 1; min-width: 8px; }
    .btn-export {
        display: flex;
        align-items: center;
        gap: 7px;
        background: #16a34a;
        color: #fff;
        text-decoration: none;
        border-radius: 12px;
        padding: 9px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        transition: background .18s, transform .12s;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(22,163,74,.2);
    }
    .btn-export:hover { background: #15803d; transform: translateY(-1px); }

    /* ── Grid ── */
    .main-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .main-grid { grid-template-columns: 1fr; }
    }

    /* ── LEFT SIDEBAR ── */
    .sidebar { display: flex; flex-direction: column; gap: 20px; }

    /* Summary Card */
    .summary-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 6px;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .summary-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 12px;
        transition: background .18s;
    }
    .summary-item:hover { background: var(--bg); }
    .summary-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .summary-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .summary-icon.green { background: #dcfce7; color: #16a34a; }
    .summary-icon.maroon { background: var(--maroon-light); color: var(--maroon); }
    .summary-icon.amber { background: #fef9c3; color: #ca8a04; }
    .summary-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-2);
    }
    .summary-value {
        font-size: 22px;
        font-weight: 900;
        color: var(--text-1);
        font-variant-numeric: tabular-nums;
        font-family: 'DM Mono', monospace;
    }
    .summary-divider {
        height: 1px;
        background: var(--border);
        margin: 2px 14px;
    }

    /* QR Card */
    .qr-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 28px 24px;
        text-align: center;
        box-shadow: var(--shadow-sm);
    }
    .qr-label {
        font-size: 10px;
        font-weight: 800;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: .18em;
        margin-bottom: 20px;
        display: block;
    }
    .qr-frame {
        background: var(--bg);
        border: 2px dashed var(--border);
        border-radius: 18px;
        padding: 20px;
        display: inline-block;
        margin-bottom: 20px;
        position: relative;
    }
    .qr-frame::before,
    .qr-frame::after {
        content: '';
        position: absolute;
        width: 14px; height: 14px;
        border-color: var(--maroon);
        border-style: solid;
    }
    .qr-frame::before { top: 8px; left: 8px; border-width: 2px 0 0 2px; border-radius: 4px 0 0 0; }
    .qr-frame::after  { bottom: 8px; right: 8px; border-width: 0 2px 2px 0; border-radius: 0 0 4px 0; }
    .qr-frame img { width: 180px; height: 180px; display: block; }

    .qr-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 18px;
    }
    .qr-badge i { font-size: 7px; }

    .btn-print {
        width: 100%;
        background: var(--maroon-deep);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 14px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        cursor: pointer;
        font-family: inherit;
        transition: background .18s, transform .12s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-bottom: 12px;
        box-shadow: 0 4px 16px rgba(61,0,8,.25);
    }
    .btn-print:hover { background: var(--maroon); transform: translateY(-1px); }
    .qr-note {
        font-size: 10px;
        color: var(--text-3);
        font-weight: 600;
        line-height: 1.6;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    /* ── RIGHT COLUMN: TABLE ── */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-2xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .table-header {
        background: var(--maroon-deep);
        padding: 20px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .table-header-left { display: flex; align-items: center; gap: 12px; }
    .table-header-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--gold);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .5; transform: scale(.85); }
    }
    .table-title {
        font-size: 12px;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .14em;
    }
    .table-date-badge {
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.15);
        color: rgba(255,255,255,.75);
        font-size: 10px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        letter-spacing: .06em;
        font-family: 'DM Mono', monospace;
    }

    /* Table */
    .att-table { width: 100%; border-collapse: collapse; }
    .att-table thead th {
        padding: 14px 20px;
        font-size: 10px;
        font-weight: 800;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: .1em;
        background: #FAFAF8;
        border-bottom: 1.5px solid var(--border);
        white-space: nowrap;
    }
    .att-table thead th:first-child { padding-left: 28px; }
    .att-table thead th:last-child  { padding-right: 28px; }

    .att-table tbody tr {
        border-bottom: 1px solid #F2F0EC;
        transition: background .15s;
    }
    .att-table tbody tr:last-child { border-bottom: none; }
    .att-table tbody tr:hover { background: #FAFAF8; }

    .att-table td {
        padding: 16px 20px;
        vertical-align: middle;
    }
    .att-table td:first-child { padding-left: 28px; }
    .att-table td:last-child  { padding-right: 28px; }

    /* Courier cell */
    .courier-cell { display: flex; align-items: center; gap: 12px; }
    .courier-avatar {
        width: 40px; height: 40px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1.5px solid var(--border);
        background: var(--maroon-light);
        display: flex; align-items: center; justify-content: center;
        font-weight: 900;
        color: var(--maroon);
        font-size: 15px;
    }
    .courier-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .courier-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-1);
        line-height: 1.2;
        display: block;
    }
    .courier-email {
        font-size: 11px;
        color: var(--text-3);
        font-weight: 500;
        display: block;
        margin-top: 2px;
    }

    /* Status badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 5px 11px;
        border-radius: 20px;
    }
    .status-badge.aktif   { background: #dcfce7; color: #15803d; }
    .status-badge.nonaktif{ background: #f1f0ee; color: var(--text-3); }
    .status-badge i { font-size: 7px; }

    /* Date & time cells */
    .cell-date {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-2);
        text-align: center;
    }
    .cell-time {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-1);
        font-family: 'DM Mono', monospace;
        letter-spacing: .02em;
        text-align: center;
    }
    .cell-time .tz {
        font-size: 9px;
        font-weight: 700;
        color: var(--text-3);
        margin-left: 2px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        text-transform: uppercase;
    }

    /* Map button */
    .btn-map {
        width: 34px; height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        color: #3b82f6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        transition: all .18s;
    }
    .btn-map:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
        transform: scale(1.08);
    }
    .no-location { color: var(--border); font-size: 18px; }

    /* Empty state */
    .empty-state {
        padding: 80px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .empty-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        background: var(--bg);
        border: 2px dashed var(--border);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        color: var(--text-3);
        margin-bottom: 4px;
    }
    .empty-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-2);
    }
    .empty-sub {
        font-size: 12px;
        color: var(--text-3);
        font-weight: 500;
    }

    /* Pagination */
    .pagination-wrap {
        padding: 16px 28px;
        border-top: 1.5px solid var(--border);
        background: #FAFAF8;
    }

    /* Row number */
    .row-num {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-3);
        font-family: 'DM Mono', monospace;
        text-align: center;
    }
</style>

<div class="absensi-root">
    <div class="container">

        {{-- BREADCRUMB --}}
        <div class="breadcrumb">
            <a href="{{ route('dashboard.superadmin') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <span class="breadcrumb-sep">/</span>
            <span>Absensi Kurir</span>
        </div>

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-text">
                <h2>Sistem Absensi Kurir</h2>
                <p>Monitoring kehadiran harian dan konfigurasi QR Code</p>
            </div>

            <div class="page-header-icon">
                <i class="fas fa-fingerprint"></i>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="filter-bar">
            {{-- Quick Tabs --}}
            <div class="filter-tabs">
                <a href="{{ route('superadmin.absensi.index', ['filter' => 'hari_ini']) }}"
                    class="filter-tab {{ ($activeFilter ?? 'hari_ini') == 'hari_ini' ? 'active' : '' }}">
                    Hari Ini
                </a>
                <a href="{{ route('superadmin.absensi.index', ['filter' => 'seminggu']) }}"
                    class="filter-tab {{ ($activeFilter ?? '') == 'seminggu' ? 'active' : '' }}">
                    Seminggu
                </a>
                <a href="{{ route('superadmin.absensi.index', ['filter' => 'sebulan']) }}"
                    class="filter-tab {{ ($activeFilter ?? '') == 'sebulan' ? 'active' : '' }}">
                    Sebulan
                </a>
            </div>

            <div class="divider-v"></div>

            {{-- Date Range --}}
            <form method="GET" action="{{ route('superadmin.absensi.index') }}" class="date-group">
                <input type="hidden" name="filter" value="custom">
                <div class="date-field">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="dari" value="{{ $dari }}">
                    <span class="date-sep">—</span>
                    <input type="date" name="sampai" value="{{ $sampai }}">
                </div>
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>

            <div class="spacer"></div>

            {{-- Export --}}
            <a href="{{ route('superadmin.absensi.export', array_filter([
                'filter'  => $activeFilter ?? 'hari_ini',
                'dari'    => $dari ?? null,
                'sampai'  => $sampai ?? null,
            ])) }}" class="btn-export">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

        {{-- MAIN GRID --}}
        <div class="main-grid">

            {{-- ── LEFT SIDEBAR ── --}}
            <div class="sidebar">

                {{-- Summary --}}
                <div class="summary-card">
                    <div class="summary-item">
                        <div class="summary-item-left">
                            <div class="summary-icon green">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="summary-label">Total Hadir</span>
                        </div>
                        <span class="summary-value">{{ $absensis->count() }}</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item">
                        <div class="summary-item-left">
                            <div class="summary-icon maroon">
                                <i class="fas fa-clock"></i>

                            </div>
                            <span class="summary-label">Periode</span>
                        </div>
                        <span style="font-size:11px;font-weight:700;color:var(--text-2);">
                            {{ \Carbon\Carbon::parse($dari)->format('d M') }} –
                            {{ \Carbon\Carbon::parse($sampai)->format('d M') }}
                        </span>
                    </div>
                </div>

                {{-- QR Card --}}
                <div class="qr-card">
                    <span class="qr-label">QR Code Aktif</span>

                    <div class="qr-badge">
                        <i class="fas fa-circle"></i> Berlaku Sekarang
                    </div>

                    <div>
                        <div class="qr-frame">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TJT-TELKOM-77"
                                alt="QR Absensi">
                        </div>
                    </div>

                    <button onclick="window.print()" class="btn-print">
                        <i class="fas fa-print"></i> Cetak QR Code
                    </button>

                    <p class="qr-note">
                        QR berlaku untuk semua driver<br>di area Telkom University
                    </p>
                </div>
            </div>

            {{-- ── RIGHT: TABLE ── --}}
            <div class="table-card">
                <div class="table-header">
                    <div class="table-header-left">
                        <div class="table-header-dot"></div>
                        <span class="table-title">Log Kehadiran</span>
                    </div>
                    <span class="table-date-badge">{{ date('d M Y') }}</span>
                </div>

                <div style="overflow-x:auto;">
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;width:44px;">No</th>
                                <th>Kurir</th>
                                <th style="text-align:center;">Status Akun</th>
                                <th style="text-align:center;">Tanggal</th>
                                <th style="text-align:center;">Jam Masuk</th>
                                <th style="text-align:center;">Peta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensis as $i => $absen)
                                <tr>
                                    {{-- # --}}
                                    <td class="row-num">{{ $i + 1 }}</td>

                                    {{-- KURIR --}}
                                    <td>
                                        <div class="courier-cell">
                                            <div class="courier-avatar">
                                                @if($absen->user && $absen->user->gambar)
                                                    <img src="{{ asset('storage/' . $absen->user->gambar) }}"
                                                        alt="{{ $absen->user->name }}">
                                                @else
                                                    {{ substr($absen->user->name ?? '?', 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <span class="courier-name">{{ $absen->user->name ?? '-' }}</span>
                                                <span class="courier-email">{{ $absen->user->email ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- STATUS --}}
                                    <td style="text-align:center;">
                                        @php $statusAkun = $absen->user->status ?? 'nonaktif'; @endphp
                                        <span class="status-badge {{ $statusAkun === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                            <i class="fas fa-circle"></i>
                                            {{ ucfirst($statusAkun) }}
                                        </span>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="cell-date">
                                        {{ $absen->created_at
                                            ? \Carbon\Carbon::parse($absen->created_at)->format('d M Y')
                                            : '-' }}
                                    </td>

                                    {{-- JAM MASUK --}}
                                    <td class="cell-time">
                                        @if($absen->jam_masuk)
                                            {{ \Carbon\Carbon::parse($absen->jam_masuk)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                            <span class="tz">WIB</span>
                                        @else
                                            <span style="color:var(--text-3);">—</span>
                                        @endif
                                    </td>

                                    {{-- PETA --}}
                                    <td style="text-align:center;">
                                        @if($absen->koordinat_absen)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $absen->koordinat_absen }}"
                                               target="_blank" class="btn-map">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        @else
                                            <span class="no-location">·</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <p class="empty-title">Belum ada data absensi</p>
                                            <p class="empty-sub">Tidak ada kehadiran tercatat untuk periode ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($absensis, 'links'))
                    <div class="pagination-wrap">
                        {{ $absensis->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>{{-- /main-grid --}}
    </div>{{-- /container --}}
</div>

</x-app-layout>
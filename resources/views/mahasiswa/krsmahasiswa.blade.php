@extends('layouts.app')

@section('title', 'Rencana Studi')
@section('page-title', 'Rencana Studi')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Rencana Studi</li>
@endsection

@section('content')

<div class="krs-wrapper">

    {{-- ==================== PAGE TITLE ==================== --}}

    {{-- ==================== INFO BAR ==================== --}}
    <div class="krs-info-bar">
        <div class="krs-info-item krs-info-ips">
            <span class="krs-info-label">IPS | IPK</span>
            <span class="krs-info-value text-primary fw-bolder">2.25 | 2.25</span>
        </div>
        <span class="krs-info-icon-btn" title="Informasi IPS/IPK">
            <i class="bi bi-info-circle-fill text-warning fs-5"></i>
        </span>

        <div class="krs-info-divider"></div>

        <div class="krs-info-item">
            <span class="krs-info-label">Jenis Kelas</span>
            <span class="krs-info-value text-warning fw-bolder">Kampus II - Reguler Sore C</span>
        </div>

        <div class="krs-info-divider"></div>

        <div class="krs-info-item">
            <span class="krs-info-label">SKS Maksimum</span>
            <span class="krs-info-value text-success fw-bolder">24</span>
        </div>

        <div class="krs-info-divider"></div>

        <div class="krs-info-item">
            <span class="krs-info-label">Dosen PA/Wali</span>
            <span class="krs-info-value text-danger fw-bolder">Iska Asri Agustin S.E., M.Kom</span>
        </div>
    </div>

    {{-- ==================== TAB BAR + ACTIONS ==================== --}}
    <div class="krs-tab-bar">
        <div class="krs-tabs">
            <button class="krs-tab active" id="tabKRS" onclick="switchTab('krs')">
                <i class="bi bi-table me-1"></i> KRS
            </button>
            <button class="krs-tab" id="tabDataKelas" onclick="switchTab('kelas')">
                <i class="bi bi-mortarboard me-1"></i> Data Kelas Kuliah
            </button>
        </div>

        <div class="krs-tab-actions">
            <div class="krs-semester-select-wrapper">
                <select class="krs-semester-select" id="semesterSelect">
                    <option value="2025_genap" selected>2025/2026 Genap</option>
                    <option value="2025_ganjil">2025/2026 Ganjil</option>
                    <option value="2024_genap">2024/2025 Genap</option>
                    <option value="2024_ganjil">2024/2025 Ganjil</option>
                </select>
                <i class="bi bi-chevron-down krs-select-arrow"></i>
            </div>
            <button class="krs-action-btn krs-btn-lock" title="Kunci KRS">
                <i class="bi bi-lock-fill"></i>
                <span class="krs-notif-dot"></span>
            </button>
            <button class="krs-action-btn" title="Cetak KRS">
                <i class="bi bi-printer-fill"></i>
            </button>
        </div>
    </div>

    {{-- ==================== TAB CONTENT: KRS ==================== --}}
    <div id="contentKRS">

        {{-- Info Banner --}}
        <div class="krs-info-banner">
            <i class="bi bi-info-circle-fill krs-banner-icon"></i>
            <div>
                <div>- Jadwal pengisian : <strong>15 Februari 2026 s/d 30 April 2026</strong></div>
                <div>- Klik pada tab <strong>Data Kelas Kuliah</strong> untuk memilih mata kuliah dan jadwal</div>
            </div>
        </div>

        {{-- KRS Table --}}
        <div class="krs-table-wrapper">
            <table class="krs-table">
                <thead>
                    <tr>
                        <th class="krs-col-no">No</th>
                        <th class="krs-col-kode">Kode</th>
                        <th class="krs-col-nama">Nama MK</th>
                        <th class="krs-col-sks">SKS</th>
                        <th class="krs-col-kelas">Kelas</th>
                        <th class="krs-col-jadwal">Jadwal</th>
                        <th class="krs-col-status">Status</th>
                        <th class="krs-col-check">
                            <input type="checkbox" class="krs-checkbox" id="checkAll" onchange="toggleAll(this)">
                        </th>
                    </tr>
                </thead>
                <tbody id="krsTableBody">
                    {{-- Diisi oleh JS --}}
                </tbody>
                <tfoot>
                    <tr class="krs-tfoot-row">
                        <td colspan="3" class="krs-tfoot-label">Total SKS Terdaftar</td>
                        <td class="krs-tfoot-sks" id="totalSKS">0</td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    {{-- ==================== TAB CONTENT: DATA KELAS KULIAH ==================== --}}
    <div id="contentKelas" class="d-none">

        {{-- Search & Filter Bar --}}
        <div class="krs-filter-bar">
            <div class="krs-search-wrapper">
                <i class="bi bi-search krs-search-icon"></i>
                <input type="text" class="krs-search-input" placeholder="Cari mata kuliah..." id="searchInput" oninput="filterKelas()">
            </div>
            <select class="krs-filter-select" id="filterSMT" onchange="filterKelas()">
                <option value="">Semua Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
            </select>
        </div>

        {{-- Data Kelas Table --}}
        <div class="krs-table-wrapper">
            <table class="krs-table">
                <thead>
                    <tr>
                        <th class="krs-col-no">No</th>
                        <th class="krs-col-kode">Kode</th>
                        <th class="krs-col-nama">Nama Mata Kuliah</th>
                        <th class="krs-col-sks">SKS</th>
                        <th class="krs-col-smt">SMT</th>
                        <th class="krs-col-kelas">Kelas</th>
                        <th class="krs-col-jadwal">Jadwal</th>
                        <th class="krs-col-dosen">Dosen</th>
                        <th class="krs-col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="kelasTableBody">
                    {{-- Diisi oleh JS --}}
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
    /* ============================
       WRAPPER & PAGE TITLE
    ============================ */
    .krs-wrapper {
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .krs-page-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 18px;
        letter-spacing: -0.02em;
    }

    /* ============================
       INFO BAR
    ============================ */
    .krs-info-bar {
        display: flex;
        align-items: center;
        gap: 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 24px;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .krs-info-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 0 24px 0 0;
    }

    .krs-info-item:first-child {
        padding-left: 0;
    }

    .krs-info-label {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .krs-info-value {
        font-size: 0.95rem;
    }

    .krs-info-icon-btn {
        cursor: pointer;
        margin-right: 8px;
        line-height: 1;
    }

    .krs-info-divider {
        width: 1px;
        height: 36px;
        background: #e2e8f0;
        margin: 0 24px 0 0;
        flex-shrink: 0;
    }

    /* ============================
       TAB BAR
    ============================ */
    .krs-tab-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .krs-tabs {
        display: flex;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 4px;
    }

    .krs-tab {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .krs-tab.active {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .krs-tab:not(.active):hover {
        background: #e2e8f0;
        color: #334155;
    }

    .krs-tab-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .krs-semester-select-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .krs-semester-select {
        appearance: none;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 36px 8px 14px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.2s;
        outline: none;
    }

    .krs-semester-select:focus {
        border-color: #2563eb;
    }

    .krs-select-arrow {
        position: absolute;
        right: 12px;
        font-size: 11px;
        color: #94a3b8;
        pointer-events: none;
    }

    .krs-action-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .krs-action-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .krs-btn-lock {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .krs-btn-lock:hover {
        background: #059669;
        border-color: #059669;
    }

    .krs-notif-dot {
        width: 8px;
        height: 8px;
        background: #f59e0b;
        border-radius: 50%;
        position: absolute;
        top: -2px;
        right: -2px;
        border: 2px solid white;
    }

    /* ============================
       INFO BANNER
    ============================ */
    .krs-info-banner {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 20px;
        font-size: 0.875rem;
        color: #78350f;
        line-height: 1.7;
    }

    .krs-banner-icon {
        color: #f59e0b;
        font-size: 16px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* ============================
       TABLE
    ============================ */
    .krs-table-wrapper {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .krs-table {
        width: 100%;
        border-collapse: collapse;
    }

    .krs-table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .krs-table th {
        font-size: 0.78rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 13px 16px;
        white-space: nowrap;
    }

    .krs-table td {
        padding: 14px 16px;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .krs-table tbody tr:last-child td {
        border-bottom: none;
    }

    .krs-table tbody tr:hover {
        background: #f8fafc;
    }

    /* Column widths */
    .krs-col-no    { width: 48px; text-align: center; }
    .krs-col-kode  { width: 110px; }
    .krs-col-nama  { min-width: 200px; }
    .krs-col-sks   { width: 60px; text-align: center; }
    .krs-col-smt   { width: 70px; text-align: center; }
    .krs-col-kelas { width: 140px; }
    .krs-col-jadwal{ width: 210px; }
    .krs-col-dosen { min-width: 160px; }
    .krs-col-status{ width: 110px; text-align: center; }
    .krs-col-check { width: 48px; text-align: center; }
    .krs-col-aksi  { width: 80px; text-align: center; }

    .krs-table td.krs-col-no { text-align: center; color: #94a3b8; }
    .krs-table td.krs-col-sks { text-align: center; font-weight: 700; }
    .krs-table td.krs-col-smt { text-align: center; }
    .krs-table td.krs-col-check { text-align: center; }
    .krs-table td.krs-col-status { text-align: center; }
    .krs-table td.krs-col-aksi { text-align: center; }

    /* Kelas link style */
    .krs-kelas-link {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .krs-kelas-link:hover { text-decoration: underline; }

    /* Status badges */
    .krs-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .krs-badge-disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .krs-badge-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .krs-badge-ditolak {
        background: #ffe4e6;
        color: #9f1239;
    }

    /* Checkbox */
    .krs-checkbox {
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    /* Footer row */
    .krs-tfoot-row td {
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
        font-weight: 700;
        color: #475569;
        font-size: 0.85rem;
    }

    .krs-tfoot-label { text-align: right; }
    .krs-tfoot-sks { text-align: center; color: #2563eb; font-size: 1rem; }

    /* ============================
       FILTER BAR (Data Kelas tab)
    ============================ */
    .krs-filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .krs-search-wrapper {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .krs-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .krs-search-input {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 9px 12px 9px 36px;
        font-size: 0.875rem;
        color: #334155;
        outline: none;
        transition: border-color 0.2s;
    }

    .krs-search-input:focus { border-color: #2563eb; }

    .krs-filter-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 0.875rem;
        color: #334155;
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    .krs-filter-select:focus { border-color: #2563eb; }

    /* Add button for Data Kelas */
    .krs-btn-tambah {
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 5px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .krs-btn-tambah:hover {
        background: #1d4ed8;
    }

    .krs-btn-tambah:disabled {
        background: #93c5fd;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .krs-info-bar { gap: 12px; }
        .krs-info-divider { display: none; }
        .krs-info-item { padding: 0; }
        .krs-table-wrapper { overflow-x: auto; }
    }
</style>
@endpush

@push('scripts')
<script>


const dummyKRS = [
    { id: 1, kode: 'INF-22201', nama: 'Aljabar Linear dan Matriks', sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 20:00 - 21:30 PE01', status: 'Disetujui' },
    { id: 2, kode: 'INF-22202', nama: 'Struktur Data',               sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 18:30 - 20:00 Kn01', status: 'Disetujui' },
    { id: 3, kode: 'INF-22203', nama: 'Organisasi dan Arsitektur Komputer', sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Sabtu, 16:30 - 18:00 PE01', status: 'Disetujui' },
    { id: 4, kode: 'INF-22204', nama: 'Website Fundamental',         sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 16:30 - 18:00 LABKOM', status: 'Disetujui' },
    { id: 5, kode: 'INF-22205', nama: 'Basis Data',                  sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Kamis, 18:30 - 20:00 Kn02', status: 'Menunggu' },
    { id: 6, kode: 'MTK-20101', nama: 'Kalkulus II',                 sks: 3, kelas: 'Reguler Sore C B', jadwal: 'Senin, 16:30 - 18:00 PE02', status: 'Menunggu' },
    { id: 7, kode: 'INF-22207', nama: 'Sistem Operasi',              sks: 3, kelas: 'Reguler Sore C A', jadwal: 'Rabu, 20:00 - 21:30 PE01', status: 'Ditolak' },
];

const dummySemuaKelas = [
    { id: 1,  kode: 'INF-22201', nama: 'Aljabar Linear dan Matriks', sks: 3, smt: 2, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 20:00 - 21:30 PE01',      dosen: 'Dr. Andi Wijaya, M.Kom',     sudahDipilih: true },
    { id: 2,  kode: 'INF-22202', nama: 'Struktur Data',              sks: 3, smt: 2, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 18:30 - 20:00 Kn01',      dosen: 'Prof. Budi Santoso, Ph.D',   sudahDipilih: true },
    { id: 3,  kode: 'INF-22203', nama: 'Organisasi & Arsitektur Komputer', sks: 3, smt: 2, kelas: 'Reguler Sore C B', jadwal: 'Sabtu, 16:30 - 18:00 PE01', dosen: 'Dr. Citra Lestari, M.T',    sudahDipilih: true },
    { id: 4,  kode: 'INF-22204', nama: 'Website Fundamental',        sks: 3, smt: 2, kelas: 'Reguler Sore C B', jadwal: 'Jumat, 16:30 - 18:00 LABKOM',    dosen: 'Ir. Dedy Hariyadi, M.Sc',   sudahDipilih: true },
    { id: 5,  kode: 'INF-22205', nama: 'Basis Data',                 sks: 3, smt: 3, kelas: 'Reguler Sore C B', jadwal: 'Kamis, 18:30 - 20:00 Kn02',      dosen: 'Dr. Eka Putri, M.Kom',      sudahDipilih: true },
    { id: 6,  kode: 'MTK-20101', nama: 'Kalkulus II',                sks: 3, smt: 2, kelas: 'Reguler Sore C B', jadwal: 'Senin, 16:30 - 18:00 PE02',       dosen: 'Fajar Nugraha, M.T',        sudahDipilih: true },
    { id: 7,  kode: 'INF-22207', nama: 'Sistem Operasi',             sks: 3, smt: 3, kelas: 'Reguler Sore C A', jadwal: 'Rabu, 20:00 - 21:30 PE01',        dosen: 'Dr. Gita Rahmawati, M.Kom', sudahDipilih: true },
    { id: 8,  kode: 'INF-22208', nama: 'Jaringan Komputer',          sks: 3, smt: 4, kelas: 'Reguler Sore C A', jadwal: 'Selasa, 18:30 - 20:00 PE03',      dosen: 'Hendra Kurniawan, M.T',     sudahDipilih: false },
    { id: 9,  kode: 'INF-22209', nama: 'Pemrograman Berorientasi Objek', sks: 3, smt: 3, kelas: 'Reguler Pagi A', jadwal: 'Senin, 08:00 - 09:40 LABKOM',   dosen: 'Dr. Indah Permata, M.Kom',  sudahDipilih: false },
    { id: 10, kode: 'MTK-20102', nama: 'Statistika & Probabilitas',  sks: 2, smt: 3, kelas: 'Reguler Pagi B',   jadwal: 'Rabu, 10:00 - 11:40 PE01',        dosen: 'Joko Prasetyo, M.Si',       sudahDipilih: false },
    { id: 11, kode: 'INF-22211', nama: 'Rekayasa Perangkat Lunak',   sks: 3, smt: 4, kelas: 'Reguler Pagi A',   jadwal: 'Kamis, 08:00 - 09:40 PE02',        dosen: 'Prof. Kartika Sari, Ph.D',  sudahDipilih: false },
    { id: 12, kode: 'INF-22212', nama: 'Kecerdasan Buatan',          sks: 3, smt: 4, kelas: 'Reguler Sore C B', jadwal: 'Sabtu, 18:00 - 19:40 PE01',        dosen: 'Dr. Lina Setiani, M.Kom',   sudahDipilih: false },
];


function switchTab(tab) {
    const isKRS = tab === 'krs';
    document.getElementById('tabKRS').classList.toggle('active', isKRS);
    document.getElementById('tabDataKelas').classList.toggle('active', !isKRS);
    document.getElementById('contentKRS').classList.toggle('d-none', !isKRS);
    document.getElementById('contentKelas').classList.toggle('d-none', isKRS);
    if (!isKRS) renderKelasTable(dummySemuaKelas);
}


function renderKRSTable() {
    const tbody = document.getElementById('krsTableBody');
    tbody.innerHTML = dummyKRS.map((m, i) => `
        <tr>
            <td class="krs-col-no">${i + 1}</td>
            <td><span style="font-family:monospace;font-size:0.82rem;font-weight:600;color:#475569">${m.kode}</span></td>
            <td style="font-weight:600;color:#1e293b">${m.nama} <span style="color:#94a3b8;font-size:0.78rem;font-weight:400">*</span></td>
            <td class="krs-col-sks">${m.sks}</td>
            <td><a href="#" class="krs-kelas-link">${m.kelas}</a></td>
            <td style="font-size:0.83rem;color:#475569">${m.jadwal}</td>
            <td class="krs-col-status">${statusBadge(m.status)}</td>
            <td class="krs-col-check"><input type="checkbox" class="krs-checkbox row-check"></td>
        </tr>
    `).join('');

    const totalSKS = dummyKRS.reduce((acc, m) => acc + m.sks, 0);
    document.getElementById('totalSKS').textContent = totalSKS;
}

function statusBadge(status) {
    const map = {
        'Disetujui': 'krs-badge-disetujui',
        'Menunggu':  'krs-badge-menunggu',
        'Ditolak':   'krs-badge-ditolak',
    };
    return `<span class="krs-badge ${map[status] || ''}">${status}</span>`;
}


function renderKelasTable(data) {
    const tbody = document.getElementById('kelasTableBody');
    tbody.innerHTML = data.map((m, i) => `
        <tr>
            <td class="krs-col-no">${i + 1}</td>
            <td><span style="font-family:monospace;font-size:0.82rem;font-weight:600;color:#475569">${m.kode}</span></td>
            <td style="font-weight:600;color:#1e293b">${m.nama}</td>
            <td class="krs-col-sks">${m.sks}</td>
            <td class="krs-col-smt" style="text-align:center">${m.smt}</td>
            <td><a href="#" class="krs-kelas-link">${m.kelas}</a></td>
            <td style="font-size:0.83rem;color:#475569">${m.jadwal}</td>
            <td style="font-size:0.83rem;color:#475569">${m.dosen}</td>
            <td class="krs-col-aksi">
                <button class="krs-btn-tambah" ${m.sudahDipilih ? 'disabled' : ''}>
                    ${m.sudahDipilih ? 'Dipilih' : '+ Pilih'}
                </button>
            </td>
        </tr>
    `).join('');
}

function filterKelas() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const smt = document.getElementById('filterSMT').value;
    const filtered = dummySemuaKelas.filter(m => {
        const matchQ = m.nama.toLowerCase().includes(q) || m.kode.toLowerCase().includes(q);
        const matchSMT = !smt || m.smt == smt;
        return matchQ && matchSMT;
    });
    renderKelasTable(filtered);
}


function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
}

renderKRSTable();
</script>
@endpush
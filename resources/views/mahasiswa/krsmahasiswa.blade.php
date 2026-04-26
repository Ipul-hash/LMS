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

    <div class="krs-stats-grid">
        <div class="krs-stat-card krs-stat-blue">
            <div class="krs-stat-bg-pattern"></div>
            <div class="krs-stat-label">Total Kelas Dibuka</div>
            <div class="krs-stat-value" id="statTotalKelas">–</div>
            <div class="krs-stat-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
        </div>
        <div class="krs-stat-card krs-stat-purple">
            <div class="krs-stat-bg-pattern"></div>
            <div class="krs-stat-label">Kelas Diambil</div>
            <div class="krs-stat-value" id="statKelasAmbil">0</div>
            <div class="krs-stat-icon">
                <i class="bi bi-journal-check"></i>
            </div>
        </div>
        <div class="krs-stat-card krs-stat-green">
            <div class="krs-stat-bg-pattern"></div>
            <div class="krs-stat-label">SKS Diambil / Maks</div>
            <div class="krs-stat-value"><span id="statSKS">0</span><span class="krs-stat-sub"> / 24</span></div>
            <div class="krs-stat-icon">
                <i class="bi bi-bar-chart-fill"></i>
            </div>
        </div>
        <div class="krs-stat-card krs-stat-red">
            <div class="krs-stat-bg-pattern"></div>
            <div class="krs-stat-label">IPS | IPK</div>
            <div class="krs-stat-value">2.25<span class="krs-stat-sub"> | 2.25</span></div>
            <div class="krs-stat-icon">
                <i class="bi bi-award-fill"></i>
            </div>
        </div>
    </div>

    {{-- ==================== META BAR ==================== --}}
    <div class="krs-meta-bar">
        <div class="krs-meta-left">
            <div class="krs-meta-item">
                <span class="krs-meta-dot dot-blue"></span>
                <span class="krs-meta-text">
                    <span class="krs-meta-label">Dosen PA</span>
                    <span class="krs-meta-val">Iska Asri Agustin S.E., M.Kom</span>
                </span>
            </div>
            <div class="krs-meta-sep"></div>
            <div class="krs-meta-item">
                <span class="krs-meta-dot dot-green"></span>
                <span class="krs-meta-text">
                    <span class="krs-meta-label">Jenis Kelas</span>
                    <span class="krs-meta-val">Kampus II – Reguler Sore C</span>
                </span>
            </div>
            <div class="krs-meta-sep"></div>
            <div class="krs-meta-item">
                <span class="krs-meta-dot dot-orange"></span>
                <span class="krs-meta-text">
                    <span class="krs-meta-label">Status KRS</span>
                    <span id="metaStatusKRS"><span class="krs-badge krs-badge-secondary">–</span></span>
                </span>
            </div>
        </div>
        <div class="krs-meta-right">
            <div class="krs-semester-select-wrapper">
                <i class="bi bi-calendar3 krs-select-icon"></i>
                <select class="krs-semester-select" id="semesterSelect" onchange="onSemesterChange()">
                    <option value="2026/Genap" selected>2025/2026 Genap</option>
                    <option value="2025/Ganjil">2025/2026 Ganjil</option>
                    <option value="2025/Genap">2024/2025 Genap</option>
                    <option value="2024/Ganjil">2024/2025 Ganjil</option>
                </select>
                <i class="bi bi-chevron-down krs-select-arrow"></i>
            </div>
            <button class="krs-icon-btn krs-btn-print" title="Cetak KRS">
                <i class="bi bi-printer-fill"></i>
            </button>
        </div>
    </div>

    {{-- ==================== TAB BAR ==================== --}}
    <div class="krs-tabs-container">
        <div class="krs-tabs">
            <button class="krs-tab active" id="tabKRS" onclick="switchTab('krs')">
                <i class="bi bi-table me-2"></i>KRS Saya
            </button>
            <button class="krs-tab" id="tabDataKelas" onclick="switchTab('kelas')">
                <i class="bi bi-grid-3x3-gap me-2"></i>Pilih Mata Kuliah
            </button>
        </div>
        <div class="krs-tabs-info">
            <i class="bi bi-clock-history me-1 text-warning"></i>
            <span class="text-muted" style="font-size:.8rem">Pengisian: <strong>15 Feb – 30 Apr 2026</strong></span>
        </div>
    </div>

    {{-- ==================== TAB CONTENT: KRS SAYA ==================== --}}
    <div id="contentKRS">

        {{-- KRS Init State --}}
        <div id="krsInitState" class="krs-empty-card d-none">
            <div class="krs-empty-icon">
                <i class="bi bi-clipboard-plus"></i>
            </div>
            <div class="krs-empty-title">KRS Semester Ini Belum Diinisialisasi</div>
            <div class="krs-empty-sub">Mulai pengisian KRS untuk semester aktif Anda</div>
            <button class="krs-btn-primary mt-4" id="btnInitKRS" onclick="initKRS()">
                <i class="bi bi-plus-lg me-2"></i> Mulai KRS Sekarang
            </button>
        </div>

        {{-- KRS Loading --}}
        <div id="krsLoadingState" class="krs-loading-card">
            <div class="krs-spinner"></div>
            <span>Memuat data KRS...</span>
        </div>

        {{-- KRS Table --}}
        <div id="krsTableWrapper" class="krs-card d-none">
            <div class="krs-card-header">
                <h6 class="krs-card-title">
                    <i class="bi bi-journal-text me-2 text-primary"></i>
                    Daftar Mata Kuliah KRS
                </h6>
                <span class="krs-badge krs-badge-primary" id="krsItemCount">0 MK</span>
            </div>
            <div class="krs-table-wrap">
                <table class="krs-table">
                    <thead>
                        <tr>
                            <th class="th-no">#</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th class="th-center">SKS</th>
                            <th>Kelas</th>
                            <th>Jadwal</th>
                            <th>Dosen</th>
                            <th class="th-center">Status</th>
                            <th class="th-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="krsTableBody"></tbody>
                    <tfoot>
                        <tr class="krs-tfoot">
                            <td colspan="3" class="krs-tfoot-label">Total SKS</td>
                            <td class="th-center krs-tfoot-sks" id="totalSKS">0</td>
                            <td colspan="5"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- KRS Empty --}}
        <div id="krsEmptyState" class="krs-empty-card d-none">
            <div class="krs-empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <div class="krs-empty-title">Belum Ada Mata Kuliah Dipilih</div>
            <div class="krs-empty-sub">Buka tab <strong>Pilih Mata Kuliah</strong> untuk menambahkan kelas</div>
            <button class="krs-btn-outline mt-3" onclick="switchTab('kelas')">
                <i class="bi bi-grid-3x3-gap me-2"></i>Pilih Mata Kuliah
            </button>
        </div>

    </div>

    {{-- ==================== TAB CONTENT: PILIH MATA KULIAH ==================== --}}
    <div id="contentKelas" class="d-none">

        <div class="krs-card">
            <div class="krs-card-header">
                <div class="krs-filter-bar">
                    <div class="krs-search-box">
                        <i class="bi bi-search krs-search-icon"></i>
                        <input type="text" class="krs-search-input" placeholder="Cari mata kuliah atau kode..." id="searchInput" oninput="filterKelas()">
                    </div>
                    <select class="krs-filter-sel" id="filterHari" onchange="filterKelas()">
                        <option value="">Semua Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <span class="krs-badge krs-badge-secondary" id="kelasCount">0 kelas</span>
            </div>

            {{-- Kelas Loading --}}
            <div id="kelasLoadingState" class="krs-loading-inline d-none">
                <div class="krs-spinner"></div>
                <span>Memuat daftar kelas...</span>
            </div>

            {{-- Kelas Table --}}
            <div id="kelasTableWrapper" class="krs-table-wrap d-none">
                <table class="krs-table">
                    <thead>
                        <tr>
                            <th class="th-no">#</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th class="th-center">SKS</th>
                            <th>Kelas</th>
                            <th>Jadwal</th>
                            <th>Dosen</th>
                            <th>Ruangan</th>
                            <th class="th-center">Ambil</th>
                        </tr>
                    </thead>
                    <tbody id="kelasTableBody"></tbody>
                </table>
            </div>

            {{-- Kelas Empty --}}
            <div id="kelasEmptyState" class="krs-empty-inline d-none">
                <i class="bi bi-search" style="font-size:2rem;color:#ccc"></i>
                <div class="krs-empty-title mt-2">Tidak Ada Kelas Ditemukan</div>
                <div class="krs-empty-sub" id="kelasEmptySubtitle">Belum ada data kelas tersedia</div>
            </div>
        </div>

    </div>

</div>

{{-- ==================== TOAST ==================== --}}
<div id="toastContainer" class="krs-toast-container"></div>

{{-- ==================== MODAL HAPUS ==================== --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content krs-modal">
            <div class="krs-modal-header">
                <div class="krs-modal-icon-wrap danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="position:absolute;top:16px;right:16px"></button>
            </div>
            <div class="krs-modal-body">
                <h6 class="krs-modal-title">Hapus dari KRS?</h6>
                <p class="krs-modal-sub">Mata kuliah <strong id="deleteItemName"></strong> akan dihapus dari KRS Anda.</p>
                <p class="krs-modal-note">Anda dapat menambahkannya kembali kapan saja.</p>
            </div>
            <div class="krs-modal-footer">
                <button type="button" class="krs-btn-ghost" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="krs-btn-danger" id="confirmDeleteBtn">
                    <span id="deleteText">Ya, Hapus</span>
                    <span id="deleteSpinner" class="krs-btn-spinner d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ==================== MODAL KRS TERKUNCI ==================== --}}
<div class="modal fade" id="lockedModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content krs-modal">
            <div class="krs-modal-header" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                <div class="krs-modal-icon-wrap" style="background:#d1fae5;color:#059669;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="position:absolute;top:16px;right:16px"></button>
            </div>
            <div class="krs-modal-body">
                <h6 class="krs-modal-title">KRS Sudah Disetujui</h6>
                <p class="krs-modal-sub">KRS Anda telah disetujui oleh Dosen PA dan <strong>tidak dapat diubah</strong>.</p>
                <p class="krs-modal-note">Hubungi Dosen PA atau Akademik jika ada perubahan yang diperlukan.</p>
            </div>
            <div class="krs-modal-footer">
                <button type="button" class="krs-btn-primary" data-bs-dismiss="modal">
                    <i class="bi bi-check-lg me-2"></i>Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ===== RESET & BASE ===== */
.krs-wrapper { font-family: 'Segoe UI', system-ui, sans-serif; }

/* Lock button (approved state) */
.krs-btn-lock {
    width: 32px; height: 32px; padding: 0;
    border: none; border-radius: 7px;
    background: #d1fae5; color: #059669;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer; transition: all .2s;
}
.krs-btn-lock:hover { background: #059669; color: #fff; }

/* ===== STAT CARDS (Dashboard Style) ===== */
.krs-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

@media (max-width: 1100px) { .krs-stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .krs-stats-grid { grid-template-columns: 1fr; } }

.krs-stat-card {
    position: relative;
    border-radius: 14px;
    padding: 22px 24px;
    color: #fff;
    overflow: hidden;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
    transition: transform .2s, box-shadow .2s;
}
.krs-stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.2); }

.krs-stat-blue   { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); }
.krs-stat-purple { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); }
.krs-stat-green  { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
.krs-stat-red    { background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); }

.krs-stat-bg-pattern {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,.12) 0%, transparent 50%),
                      radial-gradient(circle at 20% 80%, rgba(255,255,255,.08) 0%, transparent 40%);
}

.krs-stat-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    opacity: .75;
    position: relative; z-index: 1;
}

.krs-stat-value {
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -.5px;
    line-height: 1;
    position: relative; z-index: 1;
}

.krs-stat-sub {
    font-size: 1rem;
    font-weight: 500;
    opacity: .7;
}

.krs-stat-icon {
    position: absolute;
    right: 20px;
    bottom: 16px;
    font-size: 2.8rem;
    opacity: .15;
    z-index: 0;
}

/* ===== META BAR ===== */
.krs-meta-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 14px 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

.krs-meta-left  { display: flex; align-items: center; gap: 0; flex-wrap: wrap; }
.krs-meta-right { display: flex; align-items: center; gap: 8px; }

.krs-meta-item  { display: flex; align-items: center; gap: 10px; padding: 0 20px 0 0; }
.krs-meta-sep   { width: 1px; height: 32px; background: #eee; margin-right: 20px; }

.krs-meta-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.dot-blue   { background: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
.dot-green  { background: #059669; box-shadow: 0 0 0 3px rgba(5,150,105,.15); }
.dot-orange { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }

.krs-meta-text  { display: flex; flex-direction: column; gap: 1px; }
.krs-meta-label { font-size: .67rem; text-transform: uppercase; letter-spacing: .06em; color: #aaa; font-weight: 700; }
.krs-meta-val   { font-size: .84rem; font-weight: 600; color: #1a1a2e; }

/* Semester select */
.krs-semester-select-wrapper {
    position: relative; display: flex; align-items: center;
}
.krs-select-icon {
    position: absolute; left: 11px; color: #aaa; font-size: 13px;
    pointer-events: none;
}
.krs-semester-select {
    appearance: none;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px 34px 8px 32px;
    font-size: .835rem; font-weight: 600; color: #374151;
    background: #fafafa; cursor: pointer; outline: none;
    transition: border-color .2s;
}
.krs-semester-select:focus { border-color: #2563eb; background: #fff; }
.krs-select-arrow {
    position: absolute; right: 11px; font-size: 10px; color: #aaa; pointer-events: none;
}

/* Icon buttons */
.krs-icon-btn {
    width: 36px; height: 36px;
    border-radius: 8px; border: 1px solid #e5e7eb;
    background: #fafafa; color: #555;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer; transition: all .2s;
}
.krs-icon-btn:hover { background: #f3f4f6; border-color: #d1d5db; }

/* ===== TABS ===== */
.krs-tabs-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 10px;
}

.krs-tabs {
    display: flex;
    gap: 2px;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 4px;
}

.krs-tab {
    border: none; background: transparent;
    color: #64748b; font-size: .845rem; font-weight: 600;
    padding: 9px 20px; border-radius: 7px;
    cursor: pointer; transition: all .2s;
    display: inline-flex; align-items: center; white-space: nowrap;
}
.krs-tab.active {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    box-shadow: 0 3px 12px rgba(37,99,235,.3);
}
.krs-tab:not(.active):hover { background: #e2e8f0; color: #334155; }

/* ===== CARD ===== */
.krs-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
}

.krs-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f5f5f5;
    flex-wrap: wrap;
    gap: 10px;
}

.krs-card-title {
    margin: 0; font-size: .9rem; font-weight: 700; color: #1a1a2e;
    display: flex; align-items: center;
}

/* ===== BADGES ===== */
.krs-badge {
    display: inline-flex; align-items: center;
    padding: .28rem .7rem; border-radius: 20px;
    font-size: .72rem; font-weight: 700; letter-spacing: .02em;
    white-space: nowrap;
}
.krs-badge-primary   { background: #dbeafe; color: #1d4ed8; }
.krs-badge-success   { background: #d1fae5; color: #065f46; }
.krs-badge-warning   { background: #fef3c7; color: #92400e; }
.krs-badge-danger    { background: #fee2e2; color: #991b1b; }
.krs-badge-secondary { background: #f3f4f6; color: #6b7280; }
.krs-badge-info      { background: #e0f2fe; color: #0369a1; }

/* ===== TABLE ===== */
.krs-table-wrap { overflow-x: auto; }

.krs-table {
    width: 100%; border-collapse: collapse;
    min-width: 700px;
}
.krs-table thead { background: #f8f9fa; }
.krs-table thead tr { border-bottom: 2px solid #f0f0f0; }
.krs-table th {
    padding: 11px 16px;
    font-size: .69rem; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
}
.krs-table td {
    padding: 13px 16px;
    font-size: .865rem; color: #374151;
    border-bottom: 1px solid #f9fafb;
    vertical-align: middle;
}
.krs-table tbody tr:last-child td { border-bottom: none; }
.krs-table tbody tr:hover { background: #fafbfd; }

.th-no     { width: 44px; text-align: center; }
.th-center { text-align: center; }

/* Kode chip */
.krs-kode {
    font-family: 'Courier New', monospace;
    font-size: .76rem; font-weight: 700;
    background: #eff6ff; color: #2563eb;
    padding: .25rem .55rem; border-radius: 5px;
    border: 1px solid #dbeafe;
    display: inline-block; white-space: nowrap;
}

/* Jadwal */
.jadwal-hari { font-weight: 700; font-size: .82rem; color: #1a1a2e; }
.jadwal-jam  { font-size: .76rem; color: #9ca3af; margin-top: 1px; }

/* Tfoot */
.krs-tfoot td {
    background: #f8f9fa;
    border-top: 2px solid #f0f0f0 !important;
    border-bottom: none !important;
    padding: 10px 16px;
}
.krs-tfoot-label {
    text-align: right; padding-right: 20px;
    font-size: .74rem; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .06em;
}
.krs-tfoot-sks {
    font-size: 1.1rem; font-weight: 800; color: #2563eb;
}

/* ===== ACTION BUTTONS ===== */
.krs-btn-del {
    width: 32px; height: 32px; padding: 0;
    border: none; border-radius: 7px;
    background: #fee2e2; color: #dc2626;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer; transition: all .2s;
}
.krs-btn-del:hover { background: #dc2626; color: #fff; }

/* Ambil button */
.btn-ambil {
    width: 36px; height: 36px;
    border: none; border-radius: 8px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 16px; cursor: pointer;
    transition: all .2s;
    box-shadow: 0 2px 8px rgba(37,99,235,.35);
}
.btn-ambil:hover { transform: scale(1.1); box-shadow: 0 4px 14px rgba(37,99,235,.45); }
.btn-ambil:disabled { transform: none; cursor: default; }

.btn-sudah-ambil {
    width: 36px; height: 36px;
    border: none; border-radius: 8px;
    background: #d1fae5; color: #059669;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 16px; cursor: default;
}

/* ===== PRIMARY / OUTLINE BUTTONS ===== */
.krs-btn-primary {
    display: inline-flex; align-items: center;
    border: none; border-radius: 9px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: all .2s;
    box-shadow: 0 3px 12px rgba(37,99,235,.3);
}
.krs-btn-primary:hover { box-shadow: 0 5px 16px rgba(37,99,235,.4); transform: translateY(-1px); }

.krs-btn-outline {
    display: inline-flex; align-items: center;
    border: 2px solid #2563eb; border-radius: 9px;
    padding: 9px 22px;
    background: transparent;
    color: #2563eb; font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: all .2s;
}
.krs-btn-outline:hover { background: #eff6ff; }

.krs-btn-ghost {
    border: 1px solid #e5e7eb; border-radius: 8px;
    padding: 9px 20px; background: #f9fafb;
    color: #374151; font-size: .875rem; font-weight: 600;
    cursor: pointer; transition: all .2s;
}
.krs-btn-ghost:hover { background: #f3f4f6; }

.krs-btn-danger {
    border: none; border-radius: 8px;
    padding: 9px 20px;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #fff; font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: all .2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.krs-btn-danger:hover { box-shadow: 0 4px 14px rgba(220,38,38,.35); }
.krs-btn-danger:disabled { opacity: .65; cursor: default; }

.krs-btn-spinner {
    width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,.4);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .6s linear infinite;
}

/* ===== FILTER BAR ===== */
.krs-filter-bar {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.krs-search-box { position: relative; min-width: 200px; }
.krs-search-icon {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%); color: #9ca3af; font-size: 13px;
    pointer-events: none;
}
.krs-search-input {
    width: 100%; border: 1px solid #e5e7eb; border-radius: 8px;
    padding: 8px 12px 8px 32px; font-size: .845rem; color: #374151;
    outline: none; background: #fafafa; transition: border-color .2s;
}
.krs-search-input:focus { border-color: #2563eb; background: #fff; }
.krs-filter-sel {
    border: 1px solid #e5e7eb; border-radius: 8px;
    padding: 8px 14px; font-size: .845rem; color: #374151;
    background: #fafafa; outline: none; cursor: pointer;
}
.krs-filter-sel:focus { border-color: #2563eb; }

/* ===== EMPTY / LOADING STATES ===== */
.krs-empty-card {
    background: #fff; border: 1px solid #f0f0f0;
    border-radius: 14px; padding: 60px 20px;
    text-align: center; box-shadow: 0 1px 6px rgba(0,0,0,.06);
}
.krs-empty-icon {
    font-size: 3rem; color: #d1d5db; margin-bottom: 14px;
}
.krs-empty-title { font-size: .95rem; font-weight: 700; color: #4b5563; }
.krs-empty-sub   { font-size: .825rem; color: #9ca3af; margin-top: 6px; }

.krs-empty-inline {
    text-align: center; padding: 48px 20px;
    color: #9ca3af;
}

.krs-loading-card {
    background: #fff; border: 1px solid #f0f0f0;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    gap: 10px; padding: 52px 20px;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
    color: #9ca3af; font-size: .875rem;
}
.krs-loading-inline {
    display: flex; align-items: center; justify-content: center;
    gap: 10px; padding: 40px 20px;
    color: #9ca3af; font-size: .875rem;
}

.krs-spinner {
    width: 20px; height: 20px;
    border: 2px solid #e5e7eb; border-top-color: #2563eb;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* ===== MODAL ===== */
.krs-modal {
    border: none; border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    overflow: hidden;
}
.krs-modal-header {
    background: linear-gradient(135deg, #fff1f2, #fee2e2);
    padding: 24px; position: relative;
    display: flex; justify-content: center;
}
.krs-modal-icon-wrap {
    width: 56px; height: 56px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.krs-modal-icon-wrap.danger { background: #fee2e2; color: #dc2626; }

.krs-modal-body   { padding: 20px 24px 10px; text-align: center; }
.krs-modal-title  { font-size: 1rem; font-weight: 800; color: #111827; margin-bottom: 8px; }
.krs-modal-sub    { font-size: .875rem; color: #4b5563; }
.krs-modal-note   { font-size: .78rem; color: #9ca3af; margin-top: 8px; }
.krs-modal-footer {
    display: flex; justify-content: center; gap: 10px;
    padding: 16px 24px 24px;
}

/* ===== TOAST ===== */
.krs-toast-container {
    position: fixed; bottom: 24px; right: 24px;
    z-index: 9999; display: flex; flex-direction: column; gap: 10px;
}
.krs-toast {
    background: #fff; border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,.14);
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    min-width: 280px; max-width: 380px;
    animation: slideIn .3s ease;
    overflow: hidden;
    position: relative;
}
.krs-toast::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
    border-radius: 2px 0 0 2px;
}
.krs-toast.t-success::before { background: #10b981; }
.krs-toast.t-error::before   { background: #ef4444; }
.krs-toast.t-warning::before { background: #f59e0b; }
.krs-toast.t-info::before    { background: #3b82f6; }

.krs-toast-icon {
    width: 36px; height: 36px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.krs-toast.t-success .krs-toast-icon { background: #d1fae5; color: #059669; }
.krs-toast.t-error   .krs-toast-icon { background: #fee2e2; color: #dc2626; }
.krs-toast.t-warning .krs-toast-icon { background: #fef3c7; color: #d97706; }
.krs-toast.t-info    .krs-toast-icon { background: #dbeafe; color: #2563eb; }

.krs-toast-msg {
    font-size: .855rem; font-weight: 600; color: #1f2937;
    line-height: 1.4;
}

@keyframes slideIn  { from { opacity:0; transform: translateX(20px); } to { opacity:1; transform:none; } }
@keyframes slideOut { from { opacity:1; } to { opacity:0; transform: translateX(20px); } }

@media (max-width: 768px) {
    .krs-meta-sep { display: none; }
    .krs-meta-item { padding: 4px 0; }
    .krs-meta-left { gap: 8px; }
}
</style>
@endpush

@push('scripts')
<script>
    let krsId         = null;
    let krsItems      = [];
    let allKelas      = [];
    let filteredKelas = [];
    let deleteItemId  = null;
    let krsStatus     = null;

    const API_KRS_ADD    = '/api/v1/krs/add';    
    const API_KRS   = '/api/v1/krs';
    const API_KELAS = '/api/v1/classes';

    /* ── Helpers ─────────────────────────────────── */
    function esc(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    function fmtJam(t) { return t ? t.slice(0, 5) : '-'; }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    function getPeriodeSemester() {
        return document.getElementById('semesterSelect').value;
    }

    function extractDetailKrs(krs) {
        return krs.items || [];
    }

    function showToast(message, type = 'info') {
        const iconMap = {
            success: '<i class="bi bi-check-lg"></i>',
            error:   '<i class="bi bi-x-lg"></i>',
            warning: '<i class="bi bi-exclamation"></i>',
            info:    '<i class="bi bi-info-lg"></i>',
        };
        const id = 'toast-' + Date.now();
        const container = document.getElementById('toastContainer');
        container.insertAdjacentHTML('beforeend', `
            <div id="${id}" class="krs-toast t-${type}">
                <div class="krs-toast-icon">${iconMap[type] || iconMap.info}</div>
                <div class="krs-toast-msg">${esc(message)}</div>
            </div>
        `);
        const el = document.getElementById(id);
        setTimeout(() => {
            el.style.animation = 'slideOut .3s ease forwards';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    }

    /* ── Tab Switch ─────────────────────────────── */
    function switchTab(tab) {
        const isKRS = tab === 'krs';
        document.getElementById('tabKRS').classList.toggle('active', isKRS);
        document.getElementById('tabDataKelas').classList.toggle('active', !isKRS);
        document.getElementById('contentKRS').classList.toggle('d-none', !isKRS);
        document.getElementById('contentKelas').classList.toggle('d-none', isKRS);
        if (!isKRS && allKelas.length === 0) fetchKelas();
        else if (!isKRS) renderKelasTable(filteredKelas.length ? filteredKelas : allKelas);
    }

    function onSemesterChange() {
        krsId = null; krsItems = [];
        fetchKRSAktif();
    }

    /* ── Info Update ─────────────────────────────── */
    function updateStats() {
        const totalSKS = krsItems.reduce((acc, item) => {
            const mk = item.kelas?.mata_kuliah || item.kelas?.mataKuliah || {};
            return acc + (parseInt(mk.sks) || 0);
        }, 0);

        document.getElementById('statKelasAmbil').textContent = krsItems.length;
        document.getElementById('statSKS').textContent        = totalSKS;
        document.getElementById('totalSKS').textContent       = totalSKS;
        document.getElementById('krsItemCount').textContent   = krsItems.length + ' MK';
    }

    function updateStatusBadge(status) {
        const map = {
            'Draft':      ['krs-badge-warning',   'Draft'],
            'Menunggu':   ['krs-badge-info',      'Menunggu Disetujui'],
            'Disetujui':  ['krs-badge-success',   'Disetujui ✓'],
            'Ditolak':    ['krs-badge-danger',    'Ditolak ✕'],
            'Dikunci':    ['krs-badge-secondary', 'Dikunci'],
        };
        const [cls, label] = map[status] || ['krs-badge-secondary', status || '–'];
        document.getElementById('metaStatusKRS').innerHTML =
            `<span class="krs-badge ${cls}">${label}</span>`;
    }

    function fetchKRSAktif() {
    const loading = document.getElementById('krsLoadingState');
    const wrapper = document.getElementById('krsTableWrapper');
    const empty   = document.getElementById('krsEmptyState');
    const init    = document.getElementById('krsInitState');
    
    const token = localStorage.getItem('auth_token'); 

    loading.classList.remove('d-none');
    wrapper.classList.add('d-none');
    empty.classList.add('d-none');
    init.classList.add('d-none');

    fetch(`${API_KRS}/active`, { 
        method: 'GET',
        headers: { 
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`, 
            'X-Requested-With': 'XMLHttpRequest' 
        }
    })
    .then(r => { 
        if (r.status === 404) return null; 
        if (!r.ok) throw new Error(`HTTP ${r.status}`); 
        return r.json(); 
    })
    .then(result => {
        loading.classList.add('d-none');
        
        if (!result || !result.data) {
            init.classList.remove('d-none');
            updateStatusBadge(null);
            updateStats();
            return;
        }

        const krs = result.data;
        krsId    = krs.id;
        krsStatus = krs.status || 'Draft';
        krsItems = extractDetailKrs(krs);
        
        wrapper.classList.remove('d-none');
        updateStatusBadge(krs.status || 'Draft');
        updateStats();
        renderKRSTable();
    })
    .catch(err => {
        loading.classList.add('d-none');
        init.classList.remove('d-none');
        console.error("NOC Debug Error:", err);
    });
}

    /* ── Init KRS ───────────────────────────────── */
    function initKRS() {
        const btn = document.getElementById('btnInitKRS');
        btn.disabled = true;
        btn.innerHTML = '<span class="krs-spinner" style="display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;vertical-align:middle;margin-right:8px"></span> Memulai...';

        fetch(API_KRS_ADD, {
            method: 'POST',
            headers: {
                'Accept': 'application/json', 'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken(),
            },
            body: JSON.stringify({ periode_semester: getPeriodeSemester() })
        })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(result => {
            if (!result.success || !result.data) throw result;
            krsId    = result.data.id;
            krsItems = extractDetailKrs(result.data);
            updateStatusBadge(result.data.status || 'Draft');
            updateStats();
            showToast('KRS berhasil diinisialisasi!', 'success');
            document.getElementById('krsInitState').classList.add('d-none');
            renderKRSTable();
        })
        .catch(err => {
            const msg = err?.message || (err?.errors ? Object.values(err.errors).flat().join(', ') : 'Terjadi kesalahan');
            showToast('Gagal memulai KRS: ' + msg, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-plus-lg me-2"></i> Mulai KRS Sekarang';
        });
    }

    /* ── Render KRS Table ───────────────────────── */
    function renderKRSTable() {
        const wrapper = document.getElementById('krsTableWrapper');
        const empty   = document.getElementById('krsEmptyState');
        const tbody   = document.getElementById('krsTableBody');

        if (krsItems.length === 0) {
            wrapper.classList.add('d-none');
            empty.classList.remove('d-none');
            updateStats();
            return;
        }

        empty.classList.add('d-none');
        wrapper.classList.remove('d-none');

        tbody.innerHTML = krsItems.map((item, i) => {
    // PASTIIN PAKAI mata_kuliah (sesuai JSON lu)
    const mk = item.kelas?.mata_kuliah || {}; 
    const dosen = item.kelas?.dosen || {};
    const kelas = item.kelas || {};

    return `
        <tr>
            <td>${i + 1}</td>
            <td><span class="krs-kode">${mk.kode_matkul || '–'}</span></td>
            <td>
                <div class="fw-bold">${mk.nama_matkul || '–'}</div>
                <div class="small text-muted">${kelas.nama_kelas || ''}</div>
            </td>
            <td class="text-center fw-bold text-primary">${mk.sks || '0'}</td>
            <td><span class="badge bg-light-primary text-primary">${kelas.nama_kelas || '–'}</span></td>
            <td>
                <div>${kelas.hari || '–'}</div>
                <div class="small">${kelas.jam_mulai} – ${kelas.jam_selesai}</div>
            </td>
            <td>${dosen.name || '–'}</td>
            <td class="text-center">
                ${getStatusBadge(krsStatus)}
            </td>
            <td class="th-center">
                ${krsStatus === 'approved'
                    ? `<button class="krs-btn-lock" onclick="showLockedModal()" title="KRS sudah disetujui">
                        <i class="bi bi-lock-fill"></i>
                    </button>`
                    : `<button class="krs-btn-del" onclick="showDeleteConfirm(${item.id}, '${esc(mk.nama_matkul)}')">
                        <i class="bi bi-trash-fill"></i>
                    </button>`
                }
            </td>
        </tr>`;
}).join('');

        updateStats();
        if (allKelas.length > 0) renderKelasTable(filteredKelas.length ? filteredKelas : allKelas);
    }

    function getStatusBadge(status) {
    const map = {
        'Draft':     ['krs-badge-warning',   'Draft'],
        'Menunggu':  ['krs-badge-info',      'Menunggu'],
        'approved':  ['krs-badge-success',   'Approved ✓'],
        'Disetujui': ['krs-badge-success',   'Disetujui ✓'],
        'Ditolak':   ['krs-badge-danger',    'Ditolak ✕'],
        'Dikunci':   ['krs-badge-secondary', 'Dikunci'],
    };
    const [cls, label] = map[status] || ['krs-badge-secondary', status || '–'];
    return `<span class="krs-badge ${cls}">${label}</span>`;
}

    function showLockedModal() {
        new bootstrap.Modal(document.getElementById('lockedModal')).show();
    }

    /* ── Fetch Kelas ────────────────────────────── */
    function fetchKelas() {
        const loading = document.getElementById('kelasLoadingState');
        const wrapper = document.getElementById('kelasTableWrapper');
        const empty   = document.getElementById('kelasEmptyState');
        const countEl = document.getElementById('kelasCount');

        loading.classList.remove('d-none');
        wrapper.classList.add('d-none');
        empty.classList.add('d-none');

        fetch(API_KELAS, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
        .then(result => {
            loading.classList.add('d-none');
            if (result.success && Array.isArray(result.data)) {
                allKelas      = result.data;
                filteredKelas = [...allKelas];
                document.getElementById('statTotalKelas').textContent = allKelas.length;
                renderKelasTable(allKelas);
            } else {
                throw new Error(result.message || 'Gagal memuat kelas');
            }
        })
        .catch(err => {
            loading.classList.add('d-none');
            empty.classList.remove('d-none');
            document.getElementById('kelasEmptySubtitle').textContent = 'Gagal memuat data: ' + err.message;
        });
    }

    function isAlreadySelected(kelasId) {
        return krsItems.some(item => item.kelas_id === kelasId || item.kelas?.id === kelasId);
    }

    /* ── Render Kelas Table ─────────────────────── */
    function renderKelasTable(data) {
        const wrapper = document.getElementById('kelasTableWrapper');
        const empty   = document.getElementById('kelasEmptyState');
        const tbody   = document.getElementById('kelasTableBody');
        const countEl = document.getElementById('kelasCount');

        countEl.textContent = data.length + ' kelas';

        if (data.length === 0) {
            wrapper.classList.add('d-none');
            empty.classList.remove('d-none');
            const q = document.getElementById('searchInput').value;
            document.getElementById('kelasEmptySubtitle').textContent =
                q ? `Tidak ditemukan kelas untuk "${q}"` : 'Belum ada data kelas';
            return;
        }

        empty.classList.add('d-none');
        wrapper.classList.remove('d-none');

        tbody.innerHTML = data.map((item, i) => {
            const mk      = item.mata_kuliah || item.mataKuliah || {};
            const dosen   = item.dosen       || {};
            const ruangan = item.ruangan     || {};
            const dipilih = isAlreadySelected(item.id);

            const actionBtn = dipilih
                ? `<button class="btn-sudah-ambil" disabled title="Sudah diambil">
                        <i class="bi bi-check-lg"></i>
                   </button>`
                : `<button class="btn-ambil" data-kelas-id="${item.id}"
                        onclick="tambahKelas(${item.id}, this)"
                        title="Ambil mata kuliah ini">
                        <i class="bi bi-plus-lg"></i>
                   </button>`;

            return `
            <tr>
                <td class="th-no" style="color:#d1d5db;font-size:.8rem">${i + 1}</td>
                <td><span class="krs-kode">${esc(mk.kode_matkul || '–')}</span></td>
                <td>
                    <div style="font-weight:700;color:#111827;font-size:.875rem">${esc(mk.nama_matkul || '–')}</div>
                </td>
                <td class="th-center" style="font-weight:800;color:#2563eb">${mk.sks || '–'}</td>
                <td><span class="krs-badge krs-badge-primary">${esc(item.nama_kelas || '–')}</span></td>
                <td>
                    <div class="jadwal-hari">${esc(item.hari || '–')}</div>
                    <div class="jadwal-jam">${fmtJam(item.jam_mulai)} – ${fmtJam(item.jam_selesai)}</div>
                </td>
                <td style="font-size:.835rem;color:#6b7280">${esc(dosen.name || '–')}</td>
                <td>
                    <div style="font-size:.835rem;font-weight:600;color:#374151">${esc(ruangan.kode_ruangan || '–')}</div>
                    <div style="font-size:.75rem;color:#9ca3af">${esc(ruangan.lokasi || '')}</div>
                </td>
                <td class="th-center">${actionBtn}</td>
            </tr>`;
        }).join('');
    }

    /* ── Tambah Kelas ───────────────────────────── */
    function tambahKelas(kelasId, btnEl, id) {
        if (!krsId) {
            showToast('Inisialisasi KRS terlebih dahulu.', 'warning');
            switchTab('krs');
            return;
        }
        btnEl.disabled = true;
        btnEl.innerHTML = '<span style="width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;display:inline-block"></span>';

        fetch(`${API_KRS_ADD}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json', 'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken(),
            },
            body: JSON.stringify({ kelas_id: id})
        })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(result => {
            if (!result.success) throw result;
            if (result.data) {
                krsItems.push(result.data);
                renderKRSTable();
            } else {
                return fetch(`${API_KRS}/active?periode_semester=${encodeURIComponent(getPeriodeSemester())}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data) {
                        krsItems = extractDetailKrs(res.data);
                        renderKRSTable();
                    }
                });
            }

            // Update tombol → sudah diambil
            btnEl.outerHTML = `<button class="btn-sudah-ambil" disabled title="Sudah diambil"><i class="bi bi-check-lg"></i></button>`;
            const mk = allKelas.find(k => k.id === kelasId);
            const nama = mk?.mata_kuliah?.nama_matkul || mk?.mataKuliah?.nama_matkul || 'Mata kuliah';
            showToast(`${nama} berhasil ditambahkan ke KRS`, 'success');
        })
        .catch(err => {
            btnEl.disabled = false;
            btnEl.innerHTML = '<i class="bi bi-plus-lg"></i>';
            const msg = err?.message || (err?.errors ? Object.values(err.errors).flat().join(', ') : 'Terjadi kesalahan');
            showToast('Gagal menambahkan: ' + msg, 'error');
        });
    }

    /* ── Delete ─────────────────────────────────── */
    function showDeleteConfirm(itemId, nama) {
        deleteItemId = itemId;
        document.getElementById('deleteItemName').textContent = nama;
        new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!krsId || !deleteItemId) return;
        this.disabled = true;
        document.getElementById('deleteText').textContent = 'Menghapus...';
        document.getElementById('deleteSpinner').classList.remove('d-none');

        fetch(`${API_KRS}/${krsId}/item/${deleteItemId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken(),
            }
        })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(result => {
            if (!result.success) throw result;
            krsItems = krsItems.filter(i => i.id !== deleteItemId);
            renderKRSTable();
            if (!document.getElementById('contentKelas').classList.contains('d-none')) {
                renderKelasTable(filteredKelas.length ? filteredKelas : allKelas);
            }
            showToast('Mata kuliah berhasil dihapus dari KRS', 'success');
            bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
        })
        .catch(err => {
            showToast('Gagal menghapus: ' + (err?.message || 'Terjadi kesalahan'), 'error');
        })
        .finally(() => {
            this.disabled = false;
            document.getElementById('deleteText').textContent = 'Ya, Hapus';
            document.getElementById('deleteSpinner').classList.add('d-none');
            deleteItemId = null;
        });
    });

    /* ── Filter Kelas ───────────────────────────── */
    function filterKelas() {
        const q    = document.getElementById('searchInput').value.toLowerCase().trim();
        const hari = document.getElementById('filterHari').value;
        filteredKelas = allKelas.filter(item => {
            const mk = item.mata_kuliah || item.mataKuliah || {};
            const matchQ = !q
                || (mk.nama_matkul || '').toLowerCase().includes(q)
                || (mk.kode_matkul || '').toLowerCase().includes(q)
                || (item.nama_kelas || '').toLowerCase().includes(q);
            return matchQ && (!hari || item.hari === hari);
        });
        renderKelasTable(filteredKelas);
    }

    /* ── Init ───────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', fetchKRSAktif);
</script>
@endpush
@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Settings</li>
@endsection

@section('content')
<div class="settings-root">

    {{-- ── SIDEBAR NAV ──────────────────────────── --}}
    <aside class="settings-sidebar">
        <nav class="settings-nav">
            <button class="snav-item active" data-panel="panel-krs">
                <span class="snav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </span>
                <span>Jadwal KRS</span>
            </button>
            <button class="snav-item" data-panel="panel-academic-settings">
                <span class="snav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3L2 8l10 5 10-5-10-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span>Akademik</span>
            </button>
            <button class="snav-item" data-panel="panel-periods">
                <span class="snav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </span>
                <span>Periode Akademik</span>
            </button>
            <button class="snav-item" data-panel="panel-system">
                <span class="snav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </span>
                <span>Sistem</span>
            </button>
        </nav>
    </aside>

    {{-- ── MAIN PANELS ──────────────────────────── --}}
    <main class="settings-main">

        {{-- Global loading overlay --}}
        <div id="globalLoading" class="global-loading d-none">
            <div class="spinner-border spinner-border-sm text-primary me-2"></div>
            <span class="text-muted fs-7">Memuat data...</span>
        </div>

        {{-- ══ PANEL: KRS ══════════════════════════════ --}}
        <div id="panel-krs" class="settings-panel active">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Jadwal Pengisian KRS</h2>
                    <p class="panel-subtitle">Atur tanggal buka & tutup pengisian Kartu Rencana Studi.</p>
                </div>
                <button class="btn-save" id="btnSaveKRS" onclick="saveGroup('krs')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" stroke="currentColor" stroke-width="2"/><path d="M17 21v-8H7v8M7 3v5h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Simpan
                </button>
            </div>

            <div class="settings-card">
                <div class="settings-field">
                    <label class="field-label">Tanggal Mulai KRS</label>
                    <p class="field-desc">Mahasiswa dapat mulai mengisi KRS dari tanggal ini.</p>
                    <input type="date" class="field-input" id="krs_start_date" data-key="krs_start_date">
                </div>
                <div class="field-divider"></div>
                <div class="settings-field">
                    <label class="field-label">Tanggal Selesai KRS</label>
                    <p class="field-desc">KRS tidak dapat diubah setelah tanggal ini.</p>
                    <input type="date" class="field-input" id="krs_end_date" data-key="krs_end_date">
                </div>
            </div>

            {{-- Preview banner --}}
            <div class="preview-banner" id="krsPreviewBanner">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <span id="krsPreviewText">–</span>
            </div>
        </div>

        {{-- ══ PANEL: AKADEMIK ═════════════════════════ --}}
        <div id="panel-academic-settings" class="settings-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Pengaturan Akademik</h2>
                    <p class="panel-subtitle">Konfigurasi batas SKS dan aturan pengambilan mata kuliah.</p>
                </div>
                <button class="btn-save" id="btnSaveAcademic" onclick="saveGroup('academic')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" stroke="currentColor" stroke-width="2"/><path d="M17 21v-8H7v8M7 3v5h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Simpan
                </button>
            </div>

            <div class="settings-card">
                <div class="settings-field">
                    <label class="field-label">Maksimum SKS Default</label>
                    <p class="field-desc">Jumlah SKS maksimum yang dapat diambil per semester (default). Dapat di-override per mahasiswa berdasarkan IPK.</p>
                    <div class="input-with-unit">
                        <input type="number" class="field-input" id="max_sks_default" data-key="max_sks_default" min="1" max="48" placeholder="24">
                        <span class="input-unit">SKS</span>
                    </div>
                </div>
                <div class="field-divider"></div>
                <div class="settings-field">
                    <label class="field-label">Minimum SKS KRS</label>
                    <p class="field-desc">Jumlah SKS minimum yang harus diambil agar KRS dapat dikunci/disetujui.</p>
                    <div class="input-with-unit">
                        <input type="number" class="field-input" id="min_sks_krs" data-key="min_sks_krs" min="1" max="48" placeholder="12">
                        <span class="input-unit">SKS</span>
                    </div>
                </div>
            </div>

            <div class="info-chips">
                <div class="info-chip">
                    <span class="chip-dot chip-blue"></span>
                    Mahasiswa dengan IPK ≥ 3.0 dapat mengambil hingga maks + 6 SKS
                </div>
                <div class="info-chip">
                    <span class="chip-dot chip-amber"></span>
                    Mahasiswa dengan IPK &lt; 2.0 dibatasi 18 SKS
                </div>
            </div>
        </div>

        {{-- ══ PANEL: PERIODE AKADEMIK ════════════════ --}}
        <div id="panel-periods" class="settings-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Periode Akademik</h2>
                    <p class="panel-subtitle">Kelola tahun akademik dan semester yang aktif.</p>
                </div>
                <button class="btn-save btn-save-green" onclick="showAddPeriodModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                    Tambah Periode
                </button>
            </div>

            <div id="periodsLoading" class="loading-row">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                <span class="text-muted">Memuat periode akademik...</span>
            </div>

            <div id="periodsTableWrapper" class="settings-card p-0 d-none">
                <table class="periods-table">
                    <thead>
                        <tr>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="periodsTableBody"></tbody>
                </table>
            </div>

            <div id="periodsEmpty" class="empty-hint d-none">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#ddd" stroke-width="1.5"/><path d="M12 8v4M12 16h.01" stroke="#ddd" stroke-width="2" stroke-linecap="round"/></svg>
                <p>Belum ada periode akademik. Tambahkan periode pertama.</p>
            </div>
        </div>

        {{-- ══ PANEL: SISTEM ══════════════════════════ --}}
        <div id="panel-system" class="settings-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Pengaturan Sistem</h2>
                    <p class="panel-subtitle">Mode maintenance, pesan sistem, dan informasi versi.</p>
                </div>
                <button class="btn-save" id="btnSaveSystem" onclick="saveGroup('system')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" stroke="currentColor" stroke-width="2"/><path d="M17 21v-8H7v8M7 3v5h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Simpan
                </button>
            </div>

            <div class="settings-card">
                {{-- Maintenance toggle --}}
                <div class="settings-field settings-field-row">
                    <div>
                        <label class="field-label">Mode Maintenance</label>
                        <p class="field-desc">Aktifkan untuk menonaktifkan akses mahasiswa sementara.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="maintenance_mode" data-key="maintenance_mode" onchange="onMaintenanceToggle()">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                {{-- Maintenance alert --}}
                <div id="maintenanceAlert" class="maintenance-alert d-none">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" stroke="currentColor" stroke-width="1.8"/><path d="M12 9v4M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Mode maintenance aktif — mahasiswa tidak dapat mengakses sistem.
                </div>

                <div class="field-divider"></div>

                {{-- Maintenance message --}}
                <div class="settings-field">
                    <label class="field-label">Pesan Maintenance</label>
                    <p class="field-desc">Pesan yang ditampilkan kepada mahasiswa saat sistem dalam mode maintenance.</p>
                    <textarea class="field-textarea" id="maintenance_message" data-key="maintenance_message" rows="3" placeholder="Tuliskan pesan untuk mahasiswa..."></textarea>
                </div>

                <div class="field-divider"></div>

                {{-- Version (readonly) --}}
                <div class="settings-field settings-field-row">
                    <div>
                        <label class="field-label">Versi Sistem</label>
                        <p class="field-desc">Versi aplikasi yang sedang berjalan. Hanya dapat diubah melalui deployment.</p>
                    </div>
                    <span class="version-badge" id="system_version_display">–</span>
                </div>
            </div>
        </div>

    </main>
</div>

{{-- ── MODAL: Tambah Periode ──────────────────── --}}
<div class="modal fade" id="addPeriodModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content settings-modal">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Periode Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="modal-field">
                    <label class="field-label">Tahun Akademik</label>
                    <input type="text" class="field-input" id="newTahunAkademik" placeholder="contoh: 2025/2026">
                </div>
                <div class="modal-field mt-4">
                    <label class="field-label">Semester</label>
                    <div class="semester-radio-group">
                        <label class="semester-radio">
                            <input type="radio" name="newSemester" value="Ganjil" checked>
                            <span>Ganjil</span>
                        </label>
                        <label class="semester-radio">
                            <input type="radio" name="newSemester" value="Genap">
                            <span>Genap</span>
                        </label>
                    </div>
                </div>
                <div class="modal-field mt-4">
                    <label class="semester-radio" style="gap:10px">
                        <input type="checkbox" id="newIsActive" style="width:16px;height:16px;cursor:pointer;">
                        <span class="field-label mb-0">Jadikan periode aktif</span>
                    </label>
                    <p class="field-desc mt-1">Periode aktif sebelumnya akan dinonaktifkan secara otomatis.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save" id="btnConfirmAddPeriod" onclick="confirmAddPeriod()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" stroke="currentColor" stroke-width="2"/><path d="M17 21v-8H7v8M7 3v5h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span id="addPeriodBtnText">Simpan</span>
                    <span id="addPeriodSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL: Delete Confirm ──────────────────── --}}
<div class="modal fade" id="deletePeriodModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content settings-modal">
            <div class="modal-body text-center py-4">
                <div class="delete-icon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h5 class="fw-bold mt-3 mb-1">Hapus Periode?</h5>
                <p class="text-muted fs-7 mb-0">Periode <strong id="deletePeriodName" class="text-dark"></strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-center gap-2">
                <button class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                <button class="btn-danger-sm" id="btnConfirmDelete" onclick="confirmDeletePeriod()">
                    <span id="deleteText">Hapus</span>
                    <span id="deleteSpinner" class="spinner-border spinner-border-sm d-none ms-1"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index:9999"></div>

@endsection

@push('styles')
<style>
/* ─── Layout ─────────────────────────────────────── */
.settings-root {
    display: flex;
    gap: 24px;
    align-items: flex-start;


}

/* ─── Sidebar ────────────────────────────────────── */
.settings-sidebar {
    width: 210px;
    flex-shrink: 0;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
    position: sticky;
    top: 20px;
}

.settings-nav { display: flex; flex-direction: column; gap: 2px; }

.snav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: .845rem;
    font-weight: 600;
    cursor: pointer;
    text-align: left;
    transition: all .18s;
    width: 100%;
}

.snav-item:hover  { background: #f1f5f9; color: #334155; }
.snav-item.active { background: #e8f0fe; color: #1976d2; }

.snav-icon {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 6px;
    background: transparent;
    flex-shrink: 0;
}

.snav-item.active .snav-icon { background: #1976d214; }

/* ─── Main ───────────────────────────────────────── */
.settings-main { flex: 1; min-width: 0; }

.settings-panel { display: none; }
.settings-panel.active { display: block; }

/* ─── Panel Header ───────────────────────────────── */
.panel-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
}

.panel-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 4px;
}

.panel-subtitle {
    font-size: .82rem;
    color: #94a3b8;
    margin: 0;
}

/* ─── Buttons ────────────────────────────────────── */
.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: #1976d2;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .18s;
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-save:hover { background: #1565c0; }
.btn-save:disabled { opacity: .6; cursor: not-allowed; }
.btn-save-green { background: #10b981; }
.btn-save-green:hover { background: #059669; }

.btn-cancel {
    padding: 8px 20px;
    background: #f5f5f5;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: .83rem;
    font-weight: 600;
    color: #555;
    cursor: pointer;
    transition: background .15s;
}

.btn-cancel:hover { background: #eee; }

.btn-danger-sm {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 22px;
    background: #d32f2f; color: #fff;
    border: none; border-radius: 8px;
    font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: background .15s;
}

.btn-danger-sm:hover { background: #c62828; }

/* ─── Card ───────────────────────────────────────── */
.settings-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 0;
    box-shadow: 0 1px 6px rgba(0,0,0,.05);
    overflow: hidden;
}

/* ─── Field ──────────────────────────────────────── */
.settings-field {
    padding: 22px 24px;
}

.settings-field-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.field-divider { height: 1px; background: #f5f5f5; margin: 0; }

.field-label {
    display: block;
    font-size: .82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.field-desc {
    font-size: .79rem;
    color: #94a3b8;
    margin: 0 0 12px;
    line-height: 1.6;
}

.field-input {
    width: 100%;
    max-width: 320px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    padding: 9px 13px;
    font-size: .875rem;
    color: #1f2937;
    background: #fafafa;
    outline: none;
    transition: border-color .18s, background .18s;
}

.field-input:focus { border-color: #1976d2; background: #fff; }

.field-textarea {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 13px;
    font-size: .875rem;
    color: #1f2937;
    background: #fafafa;
    outline: none;
    resize: vertical;
    transition: border-color .18s;
    line-height: 1.6;
}

.field-textarea:focus { border-color: #1976d2; background: #fff; }

.input-with-unit {
    display: flex;
    align-items: center;
    gap: 0;
    max-width: 160px;
}

.input-with-unit .field-input {
    max-width: unset;
    border-radius: 8px 0 0 8px;
    flex: 1;
}

.input-unit {
    padding: 9px 14px;
    background: #f1f5f9;
    border: 1.5px solid #e5e7eb;
    border-left: none;
    border-radius: 0 8px 8px 0;
    font-size: .8rem;
    font-weight: 700;
    color: #64748b;
    white-space: nowrap;
}

/* ─── Toggle ─────────────────────────────────────── */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 46px; height: 26px;
    flex-shrink: 0;
    cursor: pointer;
}

.toggle-switch input { opacity: 0; width: 0; height: 0; }

.toggle-slider {
    position: absolute;
    inset: 0;
    background: #e2e8f0;
    border-radius: 26px;
    transition: background .25s;
}

.toggle-slider::before {
    content: '';
    position: absolute;
    left: 3px; top: 3px;
    width: 20px; height: 20px;
    background: #fff;
    border-radius: 50%;
    transition: transform .25s;
    box-shadow: 0 1px 4px rgba(0,0,0,.18);
}

.toggle-switch input:checked + .toggle-slider { background: #1976d2; }
.toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

/* ─── Preview Banner ─────────────────────────────── */
.preview-banner {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 14px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    padding: 11px 16px;
    font-size: .82rem;
    color: #1e40af;
    font-weight: 500;
}

/* ─── Maintenance Alert ──────────────────────────── */
.maintenance-alert {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0 24px 0;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 8px;
    padding: 11px 14px;
    font-size: .82rem;
    color: #c2410c;
    font-weight: 500;
}

/* ─── Version Badge ──────────────────────────────── */
.version-badge {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 5px 14px;
    font-size: .78rem;
    font-weight: 700;
    color: #475569;

    font-family: monospace;
    letter-spacing: .5px;
    white-space: nowrap;
}

/* ─── Info Chips ─────────────────────────────────── */
.info-chips {
    margin-top: 14px;
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.info-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .79rem;
    color: #64748b;
}

.chip-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}

.chip-blue  { background: #3b82f6; }
.chip-amber { background: #f59e0b; }

/* ─── Periods Table ──────────────────────────────── */
.periods-table {
    width: 100%;
    border-collapse: collapse;
}

.periods-table thead { background: #f8f9fa; }

.periods-table th {
    padding: 12px 20px;
    font-size: .72rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .05em;
    text-align: left;
    border-bottom: 1px solid #f0f0f0;
    white-space: nowrap;
}

.periods-table td {
    padding: 14px 20px;
    font-size: .875rem;
    color: #374151;
    border-bottom: 1px solid #f8f8f8;
    vertical-align: middle;
}

.periods-table tbody tr:last-child td { border-bottom: none; }
.periods-table tbody tr:hover { background: #fafbfc; }

.col-action { width: 130px; text-align: right; }

.badge-active   { background: #dcfce7; color: #166534; font-size: .72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-block; }
.badge-inactive { background: #f5f5f5; color: #6b7280; font-size: .72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; display: inline-block; }

.period-actions { display: flex; align-items: center; gap: 6px; justify-content: flex-end; }

.btn-period-set {
    padding: 5px 12px;
    background: #eff6ff;
    color: #1976d2;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    font-size: .75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}

.btn-period-set:hover  { background: #1976d2; color: #fff; border-color: #1976d2; }
.btn-period-set:disabled { opacity: .4; cursor: default; }

.btn-period-del {
    width: 30px; height: 30px;
    display: inline-flex; align-items: center; justify-content: center;
    background: #ffebee;
    color: #d32f2f;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all .15s;
    font-size: 13px;
}

.btn-period-del:hover { background: #d32f2f; color: #fff; }

/* ─── Modal ──────────────────────────────────────── */
.settings-modal { border: none; border-radius: 12px; box-shadow: 0 8px 40px rgba(0,0,0,.14); }
.settings-modal .modal-header { border-bottom: 1px solid #f5f5f5; padding: 18px 22px 14px; }
.settings-modal .modal-footer { border-top: 1px solid #f5f5f5; padding: 14px 22px 18px; }
.settings-modal .modal-title  { font-size: .975rem; font-weight: 700; color: #1a1a2e; }
.settings-modal .modal-body   { padding: 20px 22px; }

.modal-field .field-input { max-width: unset; }

.semester-radio-group { display: flex; gap: 10px; }

.semester-radio {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    font-size: .855rem;
    font-weight: 600;
    color: #374151;
    padding: 9px 18px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    transition: all .15s;
    user-select: none;
}

.semester-radio input { display: none; }

.semester-radio:has(input:checked) {
    border-color: #1976d2;
    background: #eff6ff;
    color: #1976d2;
}

/* ─── Delete icon ────────────────────────────────── */
.delete-icon-wrap {
    width: 56px; height: 56px;
    background: #ffebee;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto;
    color: #d32f2f;
}

/* ─── Empty / Loading ────────────────────────────── */
.empty-hint {
    text-align: center;
    padding: 48px 20px;
    color: #bbb;
    font-size: .85rem;
}

.empty-hint svg { margin: 0 auto 12px; display: block; }

.loading-row {
    display: flex; align-items: center; justify-content: center;
    padding: 40px;
}

.global-loading {
    display: flex; align-items: center;
    padding: 16px;
}

/* ─── Toast ──────────────────────────────────────── */
.s-toast {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 24px rgba(0,0,0,.12);
    min-width: 290px;
    display: flex;
    align-items: stretch;
    overflow: hidden;
    margin-top: 8px;
    animation: toastIn .28s cubic-bezier(.34,1.56,.64,1);
}

.s-toast-bar { width: 4px; flex-shrink: 0; }
.s-toast-body {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px;
    flex: 1;
}

.s-toast-icon {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.s-toast-text { font-size: .855rem; font-weight: 600; color: #333; line-height: 1.4; }
.s-toast-close {
    margin-left: auto; padding: 0 14px;
    background: none; border: none;
    color: #bbb; font-size: 16px;
    cursor: pointer; align-self: stretch;
    display: flex; align-items: center;
}

.s-toast-close:hover { color: #666; }

.toast-success .s-toast-bar  { background: #4caf50; }
.toast-success .s-toast-icon { background: #e8f5e9; color: #388e3c; }
.toast-error   .s-toast-bar  { background: #f44336; }
.toast-error   .s-toast-icon { background: #ffebee; color: #d32f2f; }
.toast-warning .s-toast-bar  { background: #ff9800; }
.toast-warning .s-toast-icon { background: #fff3e0; color: #f57c00; }
.toast-info    .s-toast-bar  { background: #2196f3; }
.toast-info    .s-toast-icon { background: #e3f2fd; color: #1976d2; }

@keyframes toastIn {
    from { opacity: 0; transform: translateX(16px) scale(.95); }
    to   { opacity: 1; transform: translateX(0) scale(1); }
}

@keyframes toastOut {
    from { opacity: 1; transform: translateX(0); max-height: 80px; margin-top: 8px; }
    to   { opacity: 0; transform: translateX(16px); max-height: 0; margin-top: 0; padding: 0; }
}

/* ─── Responsive ─────────────────────────────────── */
@media (max-width: 720px) {
    .settings-root { flex-direction: column; }
    .settings-sidebar { width: 100%; position: static; }
    .settings-nav { flex-direction: row; flex-wrap: wrap; }
    .snav-item { flex: 1; min-width: 110px; justify-content: center; }
    .panel-header { flex-direction: column; }
}
</style>
@endpush

@push('scripts')
<script>
/* ════════════════════════════════════════════════════
   CONSTANTS
════════════════════════════════════════════════════ */
const API_SETTINGS = '/api/v1/settings';
const API_PERIODS  = '/api/v1/academic-periods';

let allSettings = {};   // { krs: [...], academic: [...], system: [...] }
let allPeriods  = [];
let deletingPeriodId = null;

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

/* ════════════════════════════════════════════════════
   TOAST
════════════════════════════════════════════════════ */
const TOAST_ICONS = {
    success: '✓',
    error:   '✕',
    warning: '⚠',
    info:    'ℹ',
};

function showToast(message, type = 'info', duration = 4200) {
    const container = document.getElementById('toastContainer');
    const id = 'toast-' + Date.now();

    container.insertAdjacentHTML('beforeend', `
        <div id="${id}" class="s-toast toast-${type}">
            <div class="s-toast-bar"></div>
            <div class="s-toast-body">
                <div class="s-toast-icon">${TOAST_ICONS[type] || 'ℹ'}</div>
                <div class="s-toast-text">${escHtml(message)}</div>
            </div>
            <button class="s-toast-close" onclick="dismissToast('${id}')">×</button>
        </div>
    `);

    setTimeout(() => dismissToast(id), duration);
}

function dismissToast(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.animation = 'toastOut .3s ease forwards';
    setTimeout(() => el?.remove(), 300);
}

function escHtml(str) {
    return String(str || '')
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ════════════════════════════════════════════════════
   SIDEBAR NAV
════════════════════════════════════════════════════ */
document.querySelectorAll('.snav-item').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.snav-item').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        const panelId = btn.dataset.panel;
        document.getElementById(panelId).classList.add('active');

        // Lazy-load periods when tab opened
        if (panelId === 'panel-periods' && allPeriods.length === 0) {
            fetchPeriods();
        }
    });
});

/* ════════════════════════════════════════════════════
   FETCH: SETTINGS
════════════════════════════════════════════════════ */
function fetchSettings() {
    fetch(API_SETTINGS, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(result => {
        if (!result.success) throw new Error(result.message || 'Gagal memuat settings');
        allSettings = result.data;
        populateSettings();
        showToast('Settings berhasil dimuat', 'info');
    })
    .catch(err => {
        console.error(err);
        showToast('Gagal memuat settings: ' + err.message, 'error');
    });
}

/* ════════════════════════════════════════════════════
   POPULATE FORM FIELDS FROM API DATA
════════════════════════════════════════════════════ */
function getVal(group, key) {
    const items = allSettings[group] || [];
    return items.find(i => i.key === key)?.value ?? '';
}

function populateSettings() {
    // ── KRS
    const startDate = getVal('krs', 'krs_start_date');
    const endDate   = getVal('krs', 'krs_end_date');
    setField('krs_start_date', startDate);
    setField('krs_end_date',   endDate);
    updateKrsPreview(startDate, endDate);

    // Listen changes for preview
    document.getElementById('krs_start_date').addEventListener('change', () => {
        updateKrsPreview(
            document.getElementById('krs_start_date').value,
            document.getElementById('krs_end_date').value
        );
    });
    document.getElementById('krs_end_date').addEventListener('change', () => {
        updateKrsPreview(
            document.getElementById('krs_start_date').value,
            document.getElementById('krs_end_date').value
        );
    });

    // ── Academic
    setField('max_sks_default', getVal('academic', 'max_sks_default'));
    setField('min_sks_krs',     getVal('academic', 'min_sks_krs'));

    // ── System
    const maintenance = getVal('system', 'maintenance_mode');
    const checkbox = document.getElementById('maintenance_mode');
    checkbox.checked = (maintenance === '1' || maintenance === 'true' || maintenance === true);
    onMaintenanceToggle(); // sync alert visibility

    setField('maintenance_message', getVal('system', 'maintenance_message'));

    const version = getVal('system', 'system_version');
    document.getElementById('system_version_display').textContent = version || '–';
}

function setField(id, value) {
    const el = document.getElementById(id);
    if (!el) return;
    if (el.type === 'checkbox') el.checked = !!value;
    else el.value = value || '';
}

function updateKrsPreview(start, end) {
    const banner = document.getElementById('krsPreviewText');
    if (start && end) {
        const s = new Date(start).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
        const e = new Date(end).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
        banner.textContent = `Pengisian KRS dibuka ${s} – ${e}`;
    } else {
        banner.textContent = 'Isi tanggal mulai dan selesai untuk melihat preview.';
    }
}

/* ════════════════════════════════════════════════════
   SAVE SETTINGS (POST /settings/update)
════════════════════════════════════════════════════ */
function collectGroup(group) {
    const items = allSettings[group] || [];
    return items.map(item => {
        const el = document.getElementById(item.key);
        let value = item.value;
        if (el) {
            value = el.type === 'checkbox' ? (el.checked ? '1' : '0') : el.value;
        }
        return { key: item.key, value };
    });
}

function saveGroup(group) {
    const btnId = { krs: 'btnSaveKRS', academic: 'btnSaveAcademic', system: 'btnSaveSystem' }[group];
    const btn   = document.getElementById(btnId);

    const settings = collectGroup(group);
    if (!settings.length) {
        showToast('Tidak ada data yang dapat disimpan.', 'warning');
        return;
    }

    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

    fetch('/api/v1/settings/update', {
        method:  'POST',
        headers: {
            'Accept':           'application/json',
            'Content-Type':     'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN':     csrfToken(),
        },
        body: JSON.stringify({ settings })
    })
    .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
    .then(result => {
        if (!result.success) throw result;
        // Sync local state with saved values
        if (result.data) {
            // If API returns updated array, refresh
            fetchSettings();
        }
        showToast('Pengaturan berhasil disimpan.', 'success');
    })
    .catch(err => {
        const msg = err?.message
            || (err?.errors ? Object.values(err.errors).flat().join(' ') : 'Terjadi kesalahan');
        showToast('Gagal menyimpan: ' + msg, 'error');
    })
    .finally(() => {
        btn.disabled  = false;
        btn.innerHTML = orig;
    });
}

/* ════════════════════════════════════════════════════
   MAINTENANCE TOGGLE
════════════════════════════════════════════════════ */
function onMaintenanceToggle() {
    const on    = document.getElementById('maintenance_mode').checked;
    const alert = document.getElementById('maintenanceAlert');
    alert.classList.toggle('d-none', !on);
}

/* ════════════════════════════════════════════════════
   FETCH: ACADEMIC PERIODS
════════════════════════════════════════════════════ */
function fetchPeriods() {
    document.getElementById('periodsLoading').classList.remove('d-none');
    document.getElementById('periodsTableWrapper').classList.add('d-none');
    document.getElementById('periodsEmpty').classList.add('d-none');

    fetch(API_PERIODS, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(result => {
        document.getElementById('periodsLoading').classList.add('d-none');
        if (result.success && Array.isArray(result.data)) {
            allPeriods = result.data;
            renderPeriods();
        } else {
            throw new Error(result.message || 'Gagal memuat periode');
        }
    })
    .catch(err => {
        document.getElementById('periodsLoading').classList.add('d-none');
        document.getElementById('periodsEmpty').classList.remove('d-none');
        showToast('Gagal memuat periode akademik: ' + err.message, 'error');
    });
}

/* ════════════════════════════════════════════════════
   RENDER PERIODS TABLE
════════════════════════════════════════════════════ */
function renderPeriods() {
    const wrapper = document.getElementById('periodsTableWrapper');
    const empty   = document.getElementById('periodsEmpty');
    const tbody   = document.getElementById('periodsTableBody');

    if (!allPeriods.length) {
        wrapper.classList.add('d-none');
        empty.classList.remove('d-none');
        return;
    }

    empty.classList.add('d-none');
    wrapper.classList.remove('d-none');

    tbody.innerHTML = allPeriods.map(p => `
        <tr>
            <td><span style="font-weight:600;color:#1a1a2e">${escHtml(p.tahun_akademik)}</span></td>
            <td>${escHtml(p.semester)}</td>
            <td>
                ${p.is_active
                    ? `<span class="badge-active">● Aktif</span>`
                    : `<span class="badge-inactive">Nonaktif</span>`
                }
            </td>
            <td>
                <div class="period-actions">
                    <button class="btn-period-set"
                        ${p.is_active ? 'disabled title="Sudah aktif"' : `onclick="setActivePeriod(${p.id})"`}>
                        ${p.is_active ? '✓ Aktif' : 'Jadikan Aktif'}
                    </button>
                    <button class="btn-period-del"
                        onclick="showDeletePeriod(${p.id}, '${escHtml(p.tahun_akademik)} ${escHtml(p.semester)}')"
                        title="Hapus periode">
                        ✕
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

/* ════════════════════════════════════════════════════
   ADD PERIOD MODAL
════════════════════════════════════════════════════ */
function showAddPeriodModal() {
    document.getElementById('newTahunAkademik').value = '';
    document.querySelector('input[name="newSemester"][value="Ganjil"]').checked = true;
    document.getElementById('newIsActive').checked = false;
    new bootstrap.Modal(document.getElementById('addPeriodModal')).show();
}

function confirmAddPeriod() {
    const tahun   = document.getElementById('newTahunAkademik').value.trim();
    const semester= document.querySelector('input[name="newSemester"]:checked')?.value || 'Ganjil';
    const isActive= document.getElementById('newIsActive').checked;

    if (!tahun) {
        showToast('Tahun akademik tidak boleh kosong.', 'warning');
        document.getElementById('newTahunAkademik').focus();
        return;
    }

    if (!/^\d{4}\/\d{4}$/.test(tahun)) {
        showToast('Format tahun akademik harus seperti: 2025/2026', 'warning');
        return;
    }

    const btn = document.getElementById('btnConfirmAddPeriod');
    btn.disabled = true;
    document.getElementById('addPeriodBtnText').textContent = 'Menyimpan...';
    document.getElementById('addPeriodSpinner').classList.remove('d-none');

    fetch(API_PERIODS, {
        method:  'POST',
        headers: {
            'Accept':           'application/json',
            'Content-Type':     'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN':     csrfToken(),
        },
        body: JSON.stringify({ tahun_akademik: tahun, semester, is_active: isActive })
    })
    .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
    .then(result => {
        if (!result.success) throw result;
        bootstrap.Modal.getInstance(document.getElementById('addPeriodModal')).hide();
        fetchPeriods(); // refresh
        showToast(`Periode ${tahun} ${semester} berhasil ditambahkan.`, 'success');
    })
    .catch(err => {
        const msg = err?.message || (err?.errors ? Object.values(err.errors).flat().join(' ') : 'Terjadi kesalahan');
        showToast('Gagal menambah periode: ' + msg, 'error');
    })
    .finally(() => {
        btn.disabled = false;
        document.getElementById('addPeriodBtnText').textContent = 'Simpan';
        document.getElementById('addPeriodSpinner').classList.add('d-none');
    });
}

/* ════════════════════════════════════════════════════
   SET ACTIVE PERIOD
════════════════════════════════════════════════════ */
function setActivePeriod(id) {
    const period = allPeriods.find(p => p.id === id);
    if (!period) return;

    fetch(`${API_PERIODS}/${id}/set-active`, {
        method:  'POST',
        headers: {
            'Accept':           'application/json',
            'Content-Type':     'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN':     csrfToken(),
        }
    })
    .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
    .then(result => {
        if (!result.success) throw result;
        fetchPeriods();
        showToast(`${period.tahun_akademik} ${period.semester} dijadikan periode aktif.`, 'success');
    })
    .catch(err => {
        const msg = err?.message || 'Terjadi kesalahan';
        showToast('Gagal mengubah periode aktif: ' + msg, 'error');
    });
}

/* ════════════════════════════════════════════════════
   DELETE PERIOD
════════════════════════════════════════════════════ */
function showDeletePeriod(id, label) {
    deletingPeriodId = id;
    document.getElementById('deletePeriodName').textContent = label;
    new bootstrap.Modal(document.getElementById('deletePeriodModal')).show();
}

function confirmDeletePeriod() {
    if (!deletingPeriodId) return;

    const btn = document.getElementById('btnConfirmDelete');
    btn.disabled = true;
    document.getElementById('deleteText').textContent = 'Menghapus...';
    document.getElementById('deleteSpinner').classList.remove('d-none');

    fetch(`${API_PERIODS}/${deletingPeriodId}`, {
        method:  'DELETE',
        headers: {
            'Accept':           'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN':     csrfToken(),
        }
    })
    .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
    .then(result => {
        if (!result.success) throw result;
        bootstrap.Modal.getInstance(document.getElementById('deletePeriodModal')).hide();
        fetchPeriods();
        showToast('Periode akademik berhasil dihapus.', 'success');
    })
    .catch(err => {
        const msg = err?.message || 'Terjadi kesalahan';
        showToast('Gagal menghapus periode: ' + msg, 'error');
    })
    .finally(() => {
        btn.disabled = false;
        document.getElementById('deleteText').textContent = 'Hapus';
        document.getElementById('deleteSpinner').classList.add('d-none');
        deletingPeriodId = null;
    });
}

/* ════════════════════════════════════════════════════
   INIT
════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    fetchSettings();
});
</script>
@endpush
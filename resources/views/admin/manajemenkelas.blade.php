@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('page-title', 'Manajemen Kelas')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manajemen Kelas</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#kelasModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Kelas
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0 gap-2 flex-wrap">
                    <div class="search-wrapper">
                        <span class="search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <circle cx="11" cy="11" r="8" stroke="#999" stroke-width="2"/>
                                <path d="M21 21L16.65 16.65" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input type="text" class="form-control form-control-solid search-input"
                            placeholder="Cari nama kelas atau mata kuliah..." id="searchInput">
                    </div>
                    <select class="form-select form-select-solid filter-select" id="filterHari">
                        <option value="">Semua Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                    <select class="form-select form-select-solid filter-select" id="filterPeriode">
                        <option value="">Semua Periode</option>
                    </select>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Kelas</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Mata Kuliah</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Dosen</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Jadwal</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Ruangan</th>
                                    <th style="width:100px" class="text-muted fw-bold fs-7 text-uppercase">Kapasitas</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Periode</th>
                                    <th style="width:90px" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kelasTableBody" class="fs-6"></tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="empty-state d-none">
                        <div class="empty-state__icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M17 20H7C5.9 20 5 19.1 5 18V8L9 4H17C18.1 4 19 4.9 19 6V18C19 19.1 18.1 20 17 20Z" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 4V8H5" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 12H15M9 16H13" stroke="#ccc" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="empty-state__title">Tidak ada data kelas</div>
                        <div class="empty-state__subtitle" id="emptySubtitle">Mulai dengan menambahkan kelas baru</div>
                    </div>
                    <div id="loadingState" class="loading-state">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span class="text-muted">Memuat data kelas...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add / Edit Modal --}}
    <div class="modal fade" id="kelasModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="kelasForm" novalidate>
                    <div class="modal-body">

                        {{-- Row 1: Nama Kelas + Kapasitas --}}
                        <div class="row g-3 mb-4">
                            <div class="col-8">
                                <label class="form-label fw-semibold mb-2">Nama Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="namaKelas"
                                    placeholder="Contoh: Kelas A" required maxlength="100">
                                <div class="invalid-feedback">Nama kelas wajib diisi</div>
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold mb-2">Kapasitas <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <input type="number" class="form-control" id="kapasitas"
                                        min="1" max="500" placeholder="40" required>
                                    <span class="input-group-text text-muted fs-7">org</span>
                                </div>
                                <div class="invalid-feedback">Kapasitas wajib diisi</div>
                            </div>
                        </div>

                        {{-- Row 2: Mata Kuliah + Dosen --}}
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Mata Kuliah <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="matkulId" required>
                                    <option value="">Pilih Mata Kuliah</option>
                                </select>
                                <div class="invalid-feedback">Mata kuliah wajib dipilih</div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Dosen Pengampu <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="dosenId" required>
                                    <option value="">Pilih Dosen</option>
                                </select>
                                <div class="invalid-feedback">Dosen wajib dipilih</div>
                            </div>
                        </div>

                        {{-- Row 3: Ruangan + Periode --}}
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Ruangan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="ruanganId" required>
                                    <option value="">Pilih Ruangan</option>
                                </select>
                                <div class="invalid-feedback">Ruangan wajib dipilih</div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Periode Semester <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="periode"
                                    placeholder="Contoh: 2026/Ganjil" required maxlength="20">
                                <div class="invalid-feedback">Periode semester wajib diisi</div>
                            </div>
                        </div>

                        {{-- Row 4: Hari + Jam Mulai + Jam Selesai --}}
                        <div class="schedule-box">
                            <div class="schedule-box__label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Jadwal Perkuliahan
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-4">
                                    <label class="form-label fw-semibold mb-2">Hari <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="hari" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                    </select>
                                    <div class="invalid-feedback">Hari wajib dipilih</div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-semibold mb-2">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control form-control-lg" id="jamMulai" required>
                                    <div class="invalid-feedback">Jam mulai wajib diisi</div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-semibold mb-2">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control form-control-lg" id="jamSelesai" required>
                                    <div class="invalid-feedback">Jam selesai wajib diisi</div>
                                </div>
                            </div>
                            <div id="jadwalConflictWarning" class="jadwal-warning d-none">
                                ⚠ Jam selesai harus lebih dari jam mulai
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span id="submitText">Simpan</span>
                            <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Hapus Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-2">
                    <div class="icon-circle icon-warning mx-auto mb-3">⚠</div>
                    <p class="text-gray-700 mb-1">
                        Apakah Anda yakin ingin menghapus<br>
                        <strong id="deleteItemName" class="text-dark"></strong>?
                    </p>
                    <p class="text-muted fs-8 mt-2">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <div class="modal-footer border-top-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-5" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-5" id="confirmDeleteBtn">
                        <span id="deleteText">Hapus</span>
                        <span id="deleteSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
@endsection

@push('styles')
<style>
    /* ── Search & Filter ──────────────────────────── */
    .search-wrapper { position: relative; }
    .search-icon {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); pointer-events: none; display: flex;
    }
    .search-input { padding-left: 38px !important; min-width: 280px; }
    .filter-select { min-width: 150px; border-radius: 6px !important; font-size: .875rem; }

    /* ── Table ────────────────────────────────────── */
    .table thead { background-color: #f8f9fa; }
    .table thead th { padding: 12px 14px; font-weight: 700; border-bottom: 0; }
    .table tbody tr { border-bottom: 1px solid #f2f2f2; transition: background-color .15s; }
    .table tbody tr:hover { background-color: #fafbfc; }
    .table tbody tr:last-child { border-bottom: 0; }
    .table tbody td { padding: 12px 14px; vertical-align: middle; }

    /* ── Badges ───────────────────────────────────── */
    .badge { font-size: .73rem; padding: .35rem .7rem; font-weight: 600; border-radius: 4px; }
    .badge-light-primary   { background: #e7f1ff; color: #0052cc; }
    .badge-light-success   { background: #d4edda; color: #155724; }
    .badge-light-warning   { background: #fff3cd; color: #856404; }
    .badge-light-info      { background: #d1ecf1; color: #0c5460; }
    .badge-light-secondary { background: #e7e7e7; color: #666; }

    /* Hari badges */
    .badge-hari-1 { background: #e3f2fd; color: #1565c0; } /* Senin */
    .badge-hari-2 { background: #e8f5e9; color: #2e7d32; } /* Selasa */
    .badge-hari-3 { background: #fff3e0; color: #e65100; } /* Rabu */
    .badge-hari-4 { background: #fce4ec; color: #880e4f; } /* Kamis */
    .badge-hari-5 { background: #ede7f6; color: #4527a0; } /* Jumat */
    .badge-hari-6 { background: #e0f2f1; color: #004d40; } /* Sabtu */

    /* ── Jadwal cell ──────────────────────────────── */
    .jadwal-cell { display: flex; flex-direction: column; gap: 3px; }
    .jadwal-time { font-size: .8rem; color: #555; display: flex; align-items: center; gap: 4px; }
    .jadwal-time svg { opacity: .45; }

    /* ── Action Buttons ───────────────────────────── */
    .btn-actions { display: flex; gap: 5px; }
    .btn-icon-sm {
        width: 33px; height: 33px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px; border: none; cursor: pointer;
        font-size: 15px; transition: all .2s;
    }
    .btn-icon-edit   { background: #e3f2fd; color: #1976d2; }
    .btn-icon-edit:hover   { background: #1976d2; color: #fff; }
    .btn-icon-delete { background: #ffebee; color: #d32f2f; }
    .btn-icon-delete:hover { background: #d32f2f; color: #fff; }

    /* ── Schedule Box (in modal) ──────────────────── */
    .schedule-box {
        background: #f8fbff; border: 1px solid #dbeafe;
        border-radius: 8px; padding: 16px 18px;
    }
    .schedule-box__label {
        font-size: .78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .6px; color: #1976d2;
        display: flex; align-items: center; gap: 6px;
    }
    .jadwal-warning {
        margin-top: 10px; padding: 8px 12px;
        background: #fff3e0; color: #e65100;
        border-radius: 6px; font-size: .8rem; font-weight: 500;
    }

    /* ── Modal ────────────────────────────────────── */
    .modal-content { border: none; border-radius: 10px; box-shadow: 0 8px 40px rgba(0,0,0,.13); }
    .form-control-lg, .form-select-lg {
        border-radius: 6px; border: 1px solid #e0e0e0;
        padding: .65rem 1rem; font-size: .95rem;
    }
    .form-control-lg:focus, .form-select-lg:focus, .form-control:focus {
        border-color: #1976d2; box-shadow: 0 0 0 3px rgba(25,118,210,.1);
    }
    input[type="time"].form-control-lg { font-variant-numeric: tabular-nums; }
    .input-group-lg .input-group-text {
        border-color: #e0e0e0; background: #f9f9f9;
        font-size: .8rem; border-radius: 0 6px 6px 0 !important;
    }
    .input-group-lg input { border-radius: 6px 0 0 6px !important; }

    /* ── Empty / Loading ──────────────────────────── */
    .empty-state { text-align: center; padding: 52px 20px; }
    .empty-state__icon { margin: 0 auto 16px; }
    .empty-state__title { font-size: 1rem; font-weight: 600; color: #555; }
    .empty-state__subtitle { font-size: .85rem; color: #aaa; margin-top: 4px; }
    .loading-state {
        display: flex; align-items: center; justify-content: center; padding: 48px 20px;
    }

    /* ── Toast ────────────────────────────────────── */
    .toast {
        background: #fff; border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,.13);
        border: none; min-width: 320px;
        animation: slideInRight .3s ease;
    }
    .toast-body { padding: 14px 16px; }
    .toast-success { border-left: 4px solid #4caf50; }
    .toast-error   { border-left: 4px solid #f44336; }
    .toast-info    { border-left: 4px solid #2196f3; }
    .toast-warning { border-left: 4px solid #ff9800; }

    /* ── Misc ─────────────────────────────────────── */
    .icon-circle {
        width: 48px; height: 48px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 22px;
    }
    .icon-warning  { background: #fff3e0; color: #f57c00; }
    .text-gray-700 { color: #555; }
    .fs-8 { font-size: .75rem !important; }
    .bg-light-gray { background-color: #f8f9fa !important; }
    .btn-primary { background: #1976d2; border-color: #1976d2; }
    .btn-primary:hover { background: #1565c0; border-color: #1565c0; }
    .btn-danger  { background: #d32f2f; border-color: #d32f2f; }
    .btn-danger:hover { background: #c62828; border-color: #c62828; }
    .btn-light   { background: #f5f5f5; border-color: #e0e0e0; color: #333; }
    .btn-light:hover { background: #eee; }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(20px); }
    }
</style>
@endpush

@push('scripts')
<script>
    /* ── State ──────────────────────────────────────── */
    let editingId   = null;
    let deleteId    = null;
    let allData     = [];
    let currentData = [];
    let matkulList  = [];
    let dosenList   = [];
    let ruanganList = [];

    const API_URL     = '/api/v1/classes';
    const MATKUL_API  = '/api/v1/courses';
    const DOSEN_API   = '/api/v1/lecturers';
    const RUANGAN_API = '/api/v1/ruangan';

    const HARI_ORDER = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const HARI_CLASS = {
        Senin:'badge-hari-1', Selasa:'badge-hari-2', Rabu:'badge-hari-3',
        Kamis:'badge-hari-4', Jumat:'badge-hari-5', Sabtu:'badge-hari-6'
    };

    /* ── Helpers ────────────────────────────────────── */
    function escHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    function fmtTime(t) {
        if (!t) return '–';
        return t.slice(0, 5); // "08:00:00" → "08:00"
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const id = 'toast-' + Date.now();
        const icons = { success:'✓', error:'✕', warning:'⚠', info:'ℹ' };
        const colors = {
            success:'background:#e8f5e9;color:#388e3c',
            error:  'background:#ffebee;color:#d32f2f',
            warning:'background:#fff3e0;color:#f57c00',
            info:   'background:#e3f2fd;color:#1976d2',
        };
        container.insertAdjacentHTML('beforeend', `
            <div id="${id}" class="toast toast-${type}" role="alert">
                <div class="toast-body d-flex align-items-start gap-3">
                    <div style="width:34px;height:34px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:16px;${colors[type]}">${icons[type]||'ℹ'}</div>
                    <div class="pt-1 fw-semibold" style="font-size:.88rem;color:#333">${message}</div>
                </div>
            </div>
        `);
        const el = document.getElementById(id);
        setTimeout(() => {
            el.style.animation = 'fadeOut .3s ease forwards';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    }

    function setLoading(show) {
        document.getElementById('loadingState').style.display = show ? 'flex' : 'none';
    }

    function setSubmitLoading(on) {
        document.getElementById('submitText').textContent = on ? 'Menyimpan...' : (editingId ? 'Perbarui' : 'Simpan');
        document.getElementById('submitSpinner').classList.toggle('d-none', !on);
        document.getElementById('submitBtn').disabled = on;
    }

    function setDeleteLoading(on) {
        document.getElementById('deleteText').textContent = on ? 'Menghapus...' : 'Hapus';
        document.getElementById('deleteSpinner').classList.toggle('d-none', !on);
        document.getElementById('confirmDeleteBtn').disabled = on;
    }

    /* ── Populate Selects ───────────────────────────── */
    function populateSelect(elId, list, valueFn, labelFn, placeholder) {
        const sel = document.getElementById(elId);
        const current = sel.value;
        sel.innerHTML = `<option value="">${placeholder}</option>`;
        list.forEach(item => {
            const opt = document.createElement('option');
            opt.value = valueFn(item);
            opt.textContent = labelFn(item);
            if (String(opt.value) === String(current)) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    function populateAllSelects() {
        populateSelect('matkulId',  matkulList,  m => m.id, m => `${m.kode_matkul} — ${m.nama_matkul}`, 'Pilih Mata Kuliah');
        populateSelect('dosenId',   dosenList,   d => d.id, d => d.nama_dosen || d.name || `Dosen #${d.id}`, 'Pilih Dosen');
        populateSelect('ruanganId', ruanganList, r => r.id, r => `${r.kode_ruangan} — ${r.nama_ruangan}`, 'Pilih Ruangan');
    }

    function buildPeriodeFilter() {
        const sel = document.getElementById('filterPeriode');
        const current = sel.value;
        const periodes = [...new Set(allData.map(k => k.periode_semester).filter(Boolean))].sort();
        sel.innerHTML = '<option value="">Semua Periode</option>';
        periodes.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p; opt.textContent = p;
            if (p === current) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    /* ── Fetch Reference Data ───────────────────────── */
    function fetchReferenceData() {
        const headers = { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' };

        Promise.allSettled([
            fetch(MATKUL_API,  { headers }).then(r => r.json()),
            fetch(DOSEN_API,   { headers }).then(r => r.json()),
            fetch(RUANGAN_API, { headers }).then(r => r.json()),
        ]).then(([mkRes, dsRes, ruRes]) => {
            if (mkRes.status === 'fulfilled' && mkRes.value.success) {
                matkulList = Array.isArray(mkRes.value.data) ? mkRes.value.data : [mkRes.value.data];
            }
            if (dsRes.status === 'fulfilled' && dsRes.value.success) {
                dosenList = Array.isArray(dsRes.value.data) ? dsRes.value.data : [dsRes.value.data];
            }
            if (ruRes.status === 'fulfilled' && ruRes.value.success) {
                ruanganList = Array.isArray(ruRes.value.data) ? ruRes.value.data : [ruRes.value.data];
            }
            populateAllSelects();
        });
    }

    /* ── Render Table ───────────────────────────────── */
    function renderTable(data) {
        const tbody  = document.getElementById('kelasTableBody');
        const empty  = document.getElementById('emptyState');
        const q      = document.getElementById('searchInput').value;

        if (data.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('d-none');
            document.getElementById('emptySubtitle').textContent = q
                ? `Tidak ditemukan kelas dengan kata kunci "${q}"`
                : 'Mulai dengan menambahkan kelas baru';
            return;
        }
        empty.classList.add('d-none');

        tbody.innerHTML = data.map(item => {
            // Resolve display names from ref lists or embedded relations
            const matkulNama = item.mata_kuliah?.nama_matkul
                || matkulList.find(m => m.id === item.matkul_id)?.nama_matkul
                || `Matkul #${item.matkul_id}`;

            const dosenNama = item.dosen?.nama_dosen
                || item.dosen?.name
                || dosenList.find(d => d.id === item.dosen_id)?.nama_dosen
                || dosenList.find(d => d.id === item.dosen_id)?.name
                || `Dosen #${item.dosen_id}`;

            const ruanganNama = item.ruangan?.kode_ruangan
                || ruanganList.find(r => r.id === item.ruangan_id)?.kode_ruangan
                || `Ruangan #${item.ruangan_id}`;

            const hariClass = HARI_CLASS[item.hari] || 'badge-light-secondary';

            return `
            <tr>
                <td><span class="fw-bold text-primary">${escHtml(item.nama_kelas)}</span></td>
                <td>
                    <div class="fw-semibold" style="font-size:.875rem">${escHtml(matkulNama)}</div>
                    ${item.mata_kuliah?.sks ? `<div class="text-muted" style="font-size:.75rem">${item.mata_kuliah.sks} SKS</div>` : ''}
                </td>
                <td>
                    <div style="font-size:.875rem;color:#444">${escHtml(dosenNama)}</div>
                </td>
                <td>
                    <div class="jadwal-cell">
                        <span class="badge ${hariClass}" style="width:fit-content">${escHtml(item.hari || '–')}</span>
                        <div class="jadwal-time">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 6V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            ${fmtTime(item.jam_mulai)} – ${fmtTime(item.jam_selesai)}
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-light-secondary">${escHtml(ruanganNama)}</span>
                </td>
                <td>
                    <span class="badge badge-light-primary">${item.kapasitas ?? '–'} org</span>
                </td>
                <td>
                    <span class="text-muted" style="font-size:.8rem">${escHtml(item.periode_semester || '–')}</span>
                </td>
                <td>
                    <div class="btn-actions">
                        <button type="button" class="btn-icon-sm btn-icon-edit"
                            onclick="editKelas(${item.id})" title="Edit">✎</button>
                        <button type="button" class="btn-icon-sm btn-icon-delete"
                            onclick="showDeleteConfirm(${item.id}, '${escHtml(item.nama_kelas)}')" title="Hapus">✕</button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    /* ── Fetch Main Data ────────────────────────────── */
    function fetchData() {
        setLoading(true);
        document.getElementById('kelasTableBody').innerHTML = '';
        document.getElementById('emptyState').classList.add('d-none');

        fetch(API_URL, {
            headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
        })
        .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
        .then(result => {
            if (result.success && result.data) {
                allData     = Array.isArray(result.data) ? result.data : [result.data];
                currentData = [...allData];
                buildPeriodeFilter();
                applyFilters();
            } else {
                throw new Error(result.message || 'Gagal mengambil data');
            }
        })
        .catch(err => {
            console.error(err);
            renderTable([]);
            showToast('Gagal memuat data: ' + err.message, 'error');
        })
        .finally(() => setLoading(false));
    }

    /* ── Filter ─────────────────────────────────────── */
    function applyFilters() {
        const q       = document.getElementById('searchInput').value.toLowerCase().trim();
        const hari    = document.getElementById('filterHari').value;
        const periode = document.getElementById('filterPeriode').value;

        currentData = allData.filter(item => {
            const matkulNama = item.mata_kuliah?.nama_matkul
                || matkulList.find(m => m.id === item.matkul_id)?.nama_matkul || '';

            const matchQ = !q
                || item.nama_kelas?.toLowerCase().includes(q)
                || matkulNama.toLowerCase().includes(q)
                || item.hari?.toLowerCase().includes(q);

            const matchHari    = !hari    || item.hari === hari;
            const matchPeriode = !periode || item.periode_semester === periode;

            return matchQ && matchHari && matchPeriode;
        });

        renderTable(currentData);
    }

    /* ── Edit ───────────────────────────────────────── */
    function editKelas(id) {
        const item = allData.find(x => x.id === id);
        if (!item) return;

        editingId = id;
        document.getElementById('modalTitle').textContent   = 'Edit Kelas';
        document.getElementById('submitText').textContent   = 'Perbarui';
        document.getElementById('namaKelas').value          = item.nama_kelas   || '';
        document.getElementById('kapasitas').value          = item.kapasitas    || '';
        document.getElementById('matkulId').value           = item.matkul_id    || '';
        document.getElementById('dosenId').value            = item.dosen_id     || '';
        document.getElementById('ruanganId').value          = item.ruangan_id   || '';
        document.getElementById('periode').value            = item.periode_semester || '';
        document.getElementById('hari').value               = item.hari         || '';
        document.getElementById('jamMulai').value           = item.jam_mulai?.slice(0,5)   || '';
        document.getElementById('jamSelesai').value         = item.jam_selesai?.slice(0,5) || '';

        new bootstrap.Modal(document.getElementById('kelasModal')).show();
    }

    /* ── Delete ─────────────────────────────────────── */
    function showDeleteConfirm(id, name) {
        deleteId = id;
        document.getElementById('deleteItemName').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
    }

    /* ── Jam validation ─────────────────────────────── */
    function validateJam() {
        const mulai   = document.getElementById('jamMulai').value;
        const selesai = document.getElementById('jamSelesai').value;
        const warning = document.getElementById('jadwalConflictWarning');
        if (mulai && selesai && selesai <= mulai) {
            warning.classList.remove('d-none');
            return false;
        }
        warning.classList.add('d-none');
        return true;
    }
    document.getElementById('jamMulai').addEventListener('change', validateJam);
    document.getElementById('jamSelesai').addEventListener('change', validateJam);

    /* ── Form Submit ────────────────────────────────── */
    document.getElementById('kelasForm').addEventListener('submit', function (e) {
        e.preventDefault();
        this.classList.add('was-validated');
        if (!this.checkValidity()) return;
        if (!validateJam()) return;

        const payload = {
            nama_kelas:       document.getElementById('namaKelas').value.trim(),
            matkul_id:        parseInt(document.getElementById('matkulId').value),
            dosen_id:         parseInt(document.getElementById('dosenId').value),
            ruangan_id:       parseInt(document.getElementById('ruanganId').value),
            kapasitas:        parseInt(document.getElementById('kapasitas').value),
            periode_semester: document.getElementById('periode').value.trim(),
            hari:             document.getElementById('hari').value,
            jam_mulai:        document.getElementById('jamMulai').value + ':00',
            jam_selesai:      document.getElementById('jamSelesai').value + ':00',
        };

        const isEdit = !!editingId;
        setSubmitLoading(true);

        fetch(isEdit ? `${API_URL}/${editingId}` : API_URL, {
            method:  isEdit ? 'PUT' : 'POST',
            headers: {
                'Accept':        'application/json',
                'Content-Type':  'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(payload)
        })
        .then(r => { if (!r.ok) return r.json().then(err => Promise.reject(err)); return r.json(); })
        .then(result => {
            if (result.success) {
                showToast(
                    isEdit
                        ? `Kelas "${payload.nama_kelas}" berhasil diperbarui`
                        : `Kelas "${payload.nama_kelas}" berhasil ditambahkan`,
                    'success'
                );
                bootstrap.Modal.getInstance(document.getElementById('kelasModal')).hide();
                fetchData();
            } else {
                throw result;
            }
        })
        .catch(err => {
            const msg = err?.message
                || (err?.errors ? Object.values(err.errors).flat().join(', ') : 'Terjadi kesalahan');
            showToast('Gagal menyimpan: ' + msg, 'error');
        })
        .finally(() => setSubmitLoading(false));
    });

    /* ── Delete Submit ──────────────────────────────── */
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteId) return;
        setDeleteLoading(true);

        fetch(`${API_URL}/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'Accept':        'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]')?.content || '',
            }
        })
        .then(r => { if (!r.ok) return r.json().then(err => Promise.reject(err)); return r.json(); })
        .then(result => {
            if (result.success) {
                const item = allData.find(x => x.id === deleteId);
                showToast(`Kelas "${item?.nama_kelas || ''}" berhasil dihapus`, 'success');
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                fetchData();
            } else {
                throw result;
            }
        })
        .catch(err => showToast('Gagal menghapus: ' + (err?.message || 'Terjadi kesalahan'), 'error'))
        .finally(() => { setDeleteLoading(false); deleteId = null; });
    });

    /* ── Reset modal on close ───────────────────────── */
    document.getElementById('kelasModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('kelasForm').reset();
        document.getElementById('kelasForm').classList.remove('was-validated');
        document.getElementById('jadwalConflictWarning').classList.add('d-none');
        document.getElementById('modalTitle').textContent = 'Tambah Kelas';
        document.getElementById('submitText').textContent = 'Simpan';
        editingId = null;
    });

    /* ── Listeners ──────────────────────────────────── */
    document.getElementById('searchInput').addEventListener('input',  applyFilters);
    document.getElementById('filterHari').addEventListener('change',  applyFilters);
    document.getElementById('filterPeriode').addEventListener('change', applyFilters);

    /* ── Init ───────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        fetchReferenceData();
        fetchData();
    });
</script>
@endpush
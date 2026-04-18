@extends('layouts.app')

@section('title', 'Manajemen Ruangan')

@section('page-title', 'Manajemen Ruangan')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Master Data</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manajemen Ruangan</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#ruanganModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Ruangan
    </button>
@endsection

@section('content')
    {{-- Summary Cards --}}
    <div class="row g-4 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card stat-card--blue">
                <div class="stat-card__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-card__content">
                    <div class="stat-card__value" id="statTotal">—</div>
                    <div class="stat-card__label">Total Ruangan</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card stat-card--green">
                <div class="stat-card__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-card__content">
                    <div class="stat-card__value" id="statKapasitasTotal">—</div>
                    <div class="stat-card__label">Total Kapasitas</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card stat-card--orange">
                <div class="stat-card__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-card__content">
                    <div class="stat-card__value" id="statDipakai">—</div>
                    <div class="stat-card__label">Sedang Dipakai</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card stat-card--purple">
                <div class="stat-card__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-card__content">
                    <div class="stat-card__value" id="statLokasi">—</div>
                    <div class="stat-card__label">Lokasi / Gedung</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center justify-content-between border-0 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <div class="search-wrapper">
                            <span class="search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="8" stroke="#999" stroke-width="2"/>
                                    <path d="M21 21L16.65 16.65" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <input type="text" class="form-control form-control-solid search-input" placeholder="Cari kode atau nama ruangan..." id="searchInput">
                        </div>
                        <select class="form-select form-select-solid filter-select" id="filterLokasi">
                            <option value="">Semua Lokasi</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted fs-7" id="dataCount">Menampilkan 0 ruangan</span>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr>
                                    <th class="col-kode text-muted fw-bold fs-7 text-uppercase">Kode</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Ruangan</th>
                                    <th class="col-kapasitas text-muted fw-bold fs-7 text-uppercase">Kapasitas</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Lokasi</th>
                                    <th class="col-kelas text-muted fw-bold fs-7 text-uppercase">Kelas Aktif</th>
                                    <th class="col-aksi text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ruanganTableBody" class="fs-6"></tbody>
                        </table>
                    </div>

                    {{-- Empty State --}}
                    <div id="emptyState" class="empty-state d-none">
                        <div class="empty-state__icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 22V12H15V22" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="empty-state__title">Tidak ada data ruangan</div>
                        <div class="empty-state__subtitle" id="emptySubtitle">Mulai dengan menambahkan ruangan baru</div>
                    </div>

                    {{-- Loading State --}}
                    <div id="loadingState" class="loading-state">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span class="text-muted">Memuat data ruangan...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Sidebar / Modal --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="ruanganDetailOffcanvas" style="width: 420px;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Detail Ruangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0" id="ruanganDetailBody">
        </div>
    </div>

    {{-- Add / Edit Modal --}}
    <div class="modal fade" id="ruanganModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="ruanganForm" novalidate>
                    <div class="modal-body">

                        {{-- Kode Ruangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Kode Ruangan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="kodeRuangan"
                                placeholder="Contoh: LAB-01" required maxlength="20">
                            <small class="text-muted">Kode unik untuk identifikasi ruangan</small>
                            <div class="invalid-feedback">Kode ruangan wajib diisi</div>
                        </div>

                        {{-- Nama Ruangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="namaRuangan"
                                placeholder="Contoh: Lab Networking & Cisco" required maxlength="100">
                            <div class="invalid-feedback">Nama ruangan wajib diisi</div>
                        </div>

                        <div class="row g-3">
                            {{-- Kapasitas --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Kapasitas <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <input type="number" class="form-control" id="kapasitas"
                                        min="1" max="500" placeholder="30" required>
                                    <span class="input-group-text text-muted fs-7">orang</span>
                                </div>
                                <div class="invalid-feedback">Kapasitas wajib diisi (1–500)</div>
                            </div>

                            {{-- Placeholder kolom --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-2">Tipe Ruangan</label>
                                <select class="form-select form-select-lg" id="tipeRuangan">
                                    <option value="">Pilih Tipe</option>
                                    <option value="Laboratorium">Laboratorium</option>
                                    <option value="Kelas">Kelas</option>
                                    <option value="Aula">Aula</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mt-4">
                            <label class="form-label fw-semibold mb-2">Lokasi / Gedung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="lokasi"
                                placeholder="Contoh: Gedung IT Lantai 1" required maxlength="150">
                            <div class="invalid-feedback">Lokasi wajib diisi</div>
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
                    <h5 class="modal-title fw-bold">Hapus Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-2">
                    <div class="icon-circle icon-warning mx-auto mb-3">⚠</div>
                    <p class="text-gray-700 mb-1">
                        Apakah Anda yakin ingin menghapus<br>
                        <strong id="deleteItemName" class="text-dark"></strong>?
                    </p>
                    <p class="text-muted fs-8 mt-2">Tindakan ini tidak dapat dibatalkan.<br>Kelas yang terkait akan terpengaruh.</p>
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

    {{-- Toast Container --}}
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
@endsection

@push('styles')
<style>
    /* ── Stat Cards ─────────────────────────────────── */
    .stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 1px 6px rgba(0,0,0,.06);
        border: 1px solid #f0f0f0;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.09); }

    .stat-card__icon {
        width: 48px; height: 48px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-card--blue  .stat-card__icon { background: #e3f2fd; color: #1976d2; }
    .stat-card--green .stat-card__icon { background: #e8f5e9; color: #388e3c; }
    .stat-card--orange.stat-card__icon,
    .stat-card--orange .stat-card__icon { background: #fff3e0; color: #f57c00; }
    .stat-card--purple .stat-card__icon { background: #ede7f6; color: #7b1fa2; }

    .stat-card__value {
        font-size: 1.75rem; font-weight: 700; color: #1a1a2e; line-height: 1;
    }
    .stat-card__label { font-size: 0.8rem; color: #888; margin-top: 4px; font-weight: 500; }

    /* ── Search & Filter ─────────────────────────────── */
    .search-wrapper { position: relative; }
    .search-icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        pointer-events: none; display: flex;
    }
    .search-input { padding-left: 38px !important; min-width: 260px; }
    .filter-select { min-width: 160px; border-radius: 6px !important; font-size: 0.875rem; }

    /* ── Table ───────────────────────────────────────── */
    .table thead { background-color: #f8f9fa; }
    .table thead th { padding: 12px 16px; font-weight: 700; border-bottom: 0; }
    .table tbody tr {
        border-bottom: 1px solid #f2f2f2;
        transition: background-color .15s;
    }
    .table tbody tr:hover { background-color: #fafbfc; }
    .table tbody td { padding: 13px 16px; vertical-align: middle; }
    .table tbody tr:last-child { border-bottom: 0; }

    .col-kode     { width: 110px; }
    .col-kapasitas{ width: 120px; }
    .col-kelas    { width: 110px; }
    .col-aksi     { width: 90px; }

    /* ── Badges ──────────────────────────────────────── */
    .badge { font-size: .73rem; padding: .38rem .7rem; font-weight: 600; border-radius: 4px; }
    .badge-light-primary  { background: #e7f1ff; color: #0052cc; }
    .badge-light-success  { background: #d4edda; color: #155724; }
    .badge-light-warning  { background: #fff3cd; color: #856404; }
    .badge-light-secondary{ background: #e7e7e7; color: #666; }
    .badge-light-info     { background: #d1ecf1; color: #0c5460; }

    /* ── Kode Chip ───────────────────────────────────── */
    .kode-chip {
        font-family: 'Courier New', monospace;
        font-size: .8rem; font-weight: 700;
        background: #f0f4ff; color: #1976d2;
        padding: .3rem .65rem; border-radius: 5px;
        letter-spacing: .3px;
        border: 1px solid #dbe8ff;
        display: inline-block;
    }

    /* ── Lokasi ──────────────────────────────────────── */
    .lokasi-text {
        display: flex; align-items: center; gap: 6px;
        color: #555; font-size: .875rem;
    }
    .lokasi-text svg { flex-shrink: 0; opacity: .5; }

    /* ── Kapasitas Bar ───────────────────────────────── */
    .kapasitas-wrap { display: flex; align-items: center; gap: 8px; }
    .kapasitas-num { font-weight: 600; font-size: .875rem; min-width: 32px; }
    .kapasitas-bar-bg {
        flex: 1; height: 5px; background: #eee; border-radius: 99px; overflow: hidden;
    }
    .kapasitas-bar-fill { height: 100%; border-radius: 99px; background: #1976d2; }

    /* ── Action Buttons ──────────────────────────────── */
    .btn-actions { display: flex; gap: 5px; }
    .btn-icon-sm {
        width: 34px; height: 34px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px; border: none; cursor: pointer;
        font-size: 15px; transition: all .2s;
    }
    .btn-icon-detail  { background: #f3f0ff; color: #7c3aed; }
    .btn-icon-detail:hover { background: #7c3aed; color: #fff; }
    .btn-icon-edit    { background: #e3f2fd; color: #1976d2; }
    .btn-icon-edit:hover { background: #1976d2; color: #fff; }
    .btn-icon-delete  { background: #ffebee; color: #d32f2f; }
    .btn-icon-delete:hover { background: #d32f2f; color: #fff; }

    /* ── Empty / Loading States ──────────────────────── */
    .empty-state {
        text-align: center; padding: 52px 20px;
    }
    .empty-state__icon { margin: 0 auto 16px; opacity: .5; }
    .empty-state__title { font-size: 1rem; font-weight: 600; color: #555; }
    .empty-state__subtitle { font-size: .85rem; color: #aaa; margin-top: 4px; }

    .loading-state {
        display: flex; align-items: center; justify-content: center;
        padding: 48px 20px;
    }

    /* ── Modal ───────────────────────────────────────── */
    .modal-content { border: none; border-radius: 10px; box-shadow: 0 8px 40px rgba(0,0,0,.13); }
    .form-control-lg, .form-select-lg {
        border-radius: 6px; border: 1px solid #e0e0e0;
        padding: .65rem 1rem; font-size: .95rem;
    }
    .form-control-lg:focus, .form-select-lg:focus, .form-control:focus {
        border-color: #1976d2; box-shadow: 0 0 0 3px rgba(25,118,210,.1);
    }
    .input-group-lg .input-group-text {
        border-color: #e0e0e0; background: #f9f9f9;
        border-radius: 0 6px 6px 0 !important;
    }
    .input-group-lg input { border-radius: 6px 0 0 6px !important; }

    /* ── Toast ───────────────────────────────────────── */
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

    /* ── Offcanvas Detail ────────────────────────────── */
    .detail-section { padding: 20px 24px; border-bottom: 1px solid #f2f2f2; }
    .detail-section:last-child { border-bottom: 0; }
    .detail-label { font-size: .73rem; text-transform: uppercase; letter-spacing: .6px; color: #aaa; font-weight: 700; margin-bottom: 6px; }
    .detail-value { font-size: .95rem; color: #333; font-weight: 500; }

    .kelas-item {
        background: #f8f9fc; border-radius: 8px;
        padding: 12px 14px; margin-bottom: 8px;
        border: 1px solid #eef0f6;
    }
    .kelas-item:last-child { margin-bottom: 0; }
    .kelas-item__name { font-weight: 600; font-size: .9rem; color: #1a1a2e; }
    .kelas-item__meta { font-size: .78rem; color: #888; margin-top: 3px; }

    /* ── Misc ────────────────────────────────────────── */
    .icon-circle {
        width: 48px; height: 48px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }
    .icon-warning { background: #fff3e0; color: #f57c00; }
    .text-gray-700 { color: #555; }
    .fs-8 { font-size: .75rem !important; }
    .btn-primary  { background: #1976d2; border-color: #1976d2; }
    .btn-primary:hover { background: #1565c0; border-color: #1565c0; }
    .btn-danger   { background: #d32f2f; border-color: #d32f2f; }
    .btn-danger:hover { background: #c62828; border-color: #c62828; }
    .btn-light    { background: #f5f5f5; border-color: #e0e0e0; color: #333; }
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
    /* ── State ─────────────────────────────────────────── */
    let editingId    = null;
    let deleteId     = null;
    let allData      = [];
    let currentData  = [];

    const API_URL = '/api/v1/ruangan';

    /* ── Helpers ───────────────────────────────────────── */
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const id = 'toast-' + Date.now();

        const icons = { success: '✓', error: '✕', warning: '⚠', info: 'ℹ' };
        const icon  = icons[type] || 'ℹ';

        const iconColors = {
            success: 'background:#e8f5e9;color:#388e3c',
            error:   'background:#ffebee;color:#d32f2f',
            warning: 'background:#fff3e0;color:#f57c00',
            info:    'background:#e3f2fd;color:#1976d2',
        };

        container.insertAdjacentHTML('beforeend', `
            <div id="${id}" class="toast toast-${type}" role="alert">
                <div class="toast-body d-flex align-items-start gap-3">
                    <div style="width:36px;height:36px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:18px;${iconColors[type]}">${icon}</div>
                    <div class="pt-1 fw-semibold" style="font-size:.9rem;color:#333">${message}</div>
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

    function setSubmitLoading(loading) {
        document.getElementById('submitText').textContent    = loading ? 'Menyimpan...' : (editingId ? 'Perbarui' : 'Simpan');
        document.getElementById('submitSpinner').classList.toggle('d-none', !loading);
        document.getElementById('submitBtn').disabled        = loading;
    }

    function setDeleteLoading(loading) {
        document.getElementById('deleteText').textContent = loading ? 'Menghapus...' : 'Hapus';
        document.getElementById('deleteSpinner').classList.toggle('d-none', !loading);
        document.getElementById('confirmDeleteBtn').disabled = loading;
    }

    /* ── Stats ─────────────────────────────────────────── */
    function updateStats(data) {
        document.getElementById('statTotal').textContent        = data.length;
        document.getElementById('statKapasitasTotal').textContent =
            data.reduce((s, r) => s + (r.kapasitas || 0), 0).toLocaleString('id-ID');

        const dipakai = data.filter(r => r.kelas && r.kelas.length > 0).length;
        document.getElementById('statDipakai').textContent = dipakai;

        const lokasi = [...new Set(data.map(r => r.lokasi).filter(Boolean))];
        document.getElementById('statLokasi').textContent = lokasi.length;

        // Populate lokasi filter
        const sel = document.getElementById('filterLokasi');
        const current = sel.value;
        sel.innerHTML = '<option value="">Semua Lokasi</option>';
        lokasi.sort().forEach(l => {
            const opt = document.createElement('option');
            opt.value = l; opt.textContent = l;
            if (l === current) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    /* ── Render Table ──────────────────────────────────── */
    function renderTable(data) {
        const tbody      = document.getElementById('ruanganTableBody');
        const emptyState = document.getElementById('emptyState');
        const countEl    = document.getElementById('dataCount');

        countEl.textContent = `Menampilkan ${data.length} ruangan`;

        if (data.length === 0) {
            tbody.innerHTML = '';
            emptyState.classList.remove('d-none');
            const q = document.getElementById('searchInput').value;
            document.getElementById('emptySubtitle').textContent = q
                ? `Tidak ditemukan ruangan dengan kata kunci "${q}"`
                : 'Mulai dengan menambahkan ruangan baru';
            return;
        }

        emptyState.classList.add('d-none');

        const maxKapasitas = Math.max(...data.map(r => r.kapasitas || 0), 1);

        tbody.innerHTML = data.map(item => {
            const kelasCount = item.kelas ? item.kelas.length : 0;
            const barWidth   = Math.round(((item.kapasitas || 0) / maxKapasitas) * 100);

            let kelasBadge;
            if (kelasCount === 0) {
                kelasBadge = `<span class="badge badge-light-secondary">Kosong</span>`;
            } else {
                kelasBadge = `<span class="badge badge-light-success">${kelasCount} kelas</span>`;
            }

            return `
            <tr>
                <td><span class="kode-chip">${escHtml(item.kode_ruangan)}</span></td>
                <td>
                    <span class="fw-semibold text-dark">${escHtml(item.nama_ruangan)}</span>
                </td>
                <td>
                    <div class="kapasitas-wrap">
                        <span class="kapasitas-num">${item.kapasitas || '–'}</span>
                        <div class="kapasitas-bar-bg">
                            <div class="kapasitas-bar-fill" style="width:${barWidth}%"></div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="lokasi-text">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        ${escHtml(item.lokasi || '–')}
                    </div>
                </td>
                <td>${kelasBadge}</td>
                <td>
                    <div class="btn-actions">
                        <button type="button" class="btn-icon-sm btn-icon-detail" onclick="showDetail(${item.id})" title="Lihat Detail">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editRuangan(${item.id})" title="Edit">✎</button>
                        <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${escHtml(item.nama_ruangan)}')" title="Hapus">✕</button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    function escHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /* ── Fetch All ─────────────────────────────────────── */
    function fetchData() {
        setLoading(true);
        document.getElementById('ruanganTableBody').innerHTML = '';
        document.getElementById('emptyState').classList.add('d-none');

        fetch(API_URL, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
        .then(result => {
            if (result.success && result.data) {
                allData     = Array.isArray(result.data) ? result.data : [result.data];
                currentData = [...allData];
                updateStats(allData);
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

    /* ── Fetch Detail ──────────────────────────────────── */
    function showDetail(id) {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('ruanganDetailOffcanvas'));
        document.getElementById('ruanganDetailBody').innerHTML = `
            <div class="d-flex align-items-center justify-content-center py-5">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                <span class="text-muted">Memuat detail...</span>
            </div>`;
        offcanvas.show();

        fetch(`${API_URL}/${id}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
        .then(result => {
            if (result.success && result.data) {
                renderDetail(result.data);
            } else {
                throw new Error(result.message || 'Gagal memuat detail');
            }
        })
        .catch(err => {
            document.getElementById('ruanganDetailBody').innerHTML =
                `<div class="p-5 text-center text-danger">Gagal memuat: ${escHtml(err.message)}</div>`;
        });
    }

    function renderDetail(item) {
        const kelas = item.kelas || [];

        const kelasHtml = kelas.length === 0
            ? `<div class="text-muted fs-7 text-center py-3">Belum ada kelas di ruangan ini</div>`
            : kelas.map(k => `
                <div class="kelas-item">
                    <div class="kelas-item__name">${escHtml(k.nama_kelas)}</div>
                    <div class="kelas-item__meta">
                        ${escHtml(k.hari)} · ${k.jam_mulai?.slice(0,5)} – ${k.jam_selesai?.slice(0,5)}
                        · ${escHtml(k.periode_semester)}
                    </div>
                </div>`).join('');

        document.getElementById('ruanganDetailBody').innerHTML = `
            <div class="detail-section">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:12px;background:#e3f2fd;color:#1976d2;display:flex;align-items:center;justify-content:center;font-size:24px;">🏛</div>
                    <div>
                        <div class="fw-bold fs-5">${escHtml(item.nama_ruangan)}</div>
                        <div class="kode-chip mt-1">${escHtml(item.kode_ruangan)}</div>
                    </div>
                </div>
            </div>
            <div class="detail-section">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="detail-label">Kapasitas</div>
                        <div class="detail-value">${item.kapasitas ?? '–'} <span class="text-muted fs-8">orang</span></div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Kelas Aktif</div>
                        <div class="detail-value">${kelas.length} kelas</div>
                    </div>
                    <div class="col-12">
                        <div class="detail-label">Lokasi</div>
                        <div class="detail-value">${escHtml(item.lokasi || '–')}</div>
                    </div>
                </div>
            </div>
            <div class="detail-section">
                <div class="detail-label mb-3">Jadwal Kelas</div>
                ${kelasHtml}
            </div>
            <div class="detail-section">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary flex-fill" onclick="editRuangan(${item.id}); bootstrap.Offcanvas.getInstance(document.getElementById('ruanganDetailOffcanvas')).hide();">
                        ✎ Edit Ruangan
                    </button>
                    <button class="btn btn-sm btn-light" onclick="showDeleteConfirm(${item.id}, '${escHtml(item.nama_ruangan)}'); bootstrap.Offcanvas.getInstance(document.getElementById('ruanganDetailOffcanvas')).hide();">
                        ✕ Hapus
                    </button>
                </div>
            </div>
        `;
    }

    /* ── Filter & Search ───────────────────────────────── */
    function applyFilters() {
        const q   = document.getElementById('searchInput').value.toLowerCase().trim();
        const lok = document.getElementById('filterLokasi').value;

        currentData = allData.filter(item => {
            const matchSearch = !q
                || item.kode_ruangan?.toLowerCase().includes(q)
                || item.nama_ruangan?.toLowerCase().includes(q)
                || item.lokasi?.toLowerCase().includes(q);
            const matchLokasi = !lok || item.lokasi === lok;
            return matchSearch && matchLokasi;
        });

        renderTable(currentData);
    }

    /* ── CRUD ──────────────────────────────────────────── */
    function editRuangan(id) {
        // Try local cache first, then API
        const cached = allData.find(x => x.id === id);
        if (cached) {
            populateForm(cached);
        } else {
            fetch(`${API_URL}/${id}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(result => result.success && populateForm(result.data))
            .catch(() => showToast('Gagal memuat data ruangan', 'error'));
        }
    }

    function populateForm(item) {
        editingId = item.id;
        document.getElementById('modalTitle').textContent     = 'Edit Ruangan';
        document.getElementById('kodeRuangan').value          = item.kode_ruangan || '';
        document.getElementById('namaRuangan').value          = item.nama_ruangan || '';
        document.getElementById('kapasitas').value            = item.kapasitas || '';
        document.getElementById('lokasi').value               = item.lokasi || '';
        document.getElementById('submitText').textContent     = 'Perbarui';
        new bootstrap.Modal(document.getElementById('ruanganModal')).show();
    }

    function showDeleteConfirm(id, name) {
        deleteId = id;
        document.getElementById('deleteItemName').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
    }

    /* Form submit */
    document.getElementById('ruanganForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const kode     = document.getElementById('kodeRuangan').value.trim();
        const nama     = document.getElementById('namaRuangan').value.trim();
        const kapasitas= parseInt(document.getElementById('kapasitas').value);
        const lokasi   = document.getElementById('lokasi').value.trim();

        if (!kode || !nama || !kapasitas || !lokasi) {
            this.classList.add('was-validated');
            return;
        }

        const payload = { kode_ruangan: kode, nama_ruangan: nama, kapasitas, lokasi };
        const isEdit  = !!editingId;
        const url     = isEdit ? `${API_URL}/${editingId}` : API_URL;
        const method  = isEdit ? 'PUT' : 'POST';

        setSubmitLoading(true);

        fetch(url, {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(payload)
        })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(result => {
            if (result.success) {
                showToast(
                    isEdit
                        ? `Ruangan "${nama}" berhasil diperbarui`
                        : `Ruangan "${nama}" berhasil ditambahkan`,
                    'success'
                );
                bootstrap.Modal.getInstance(document.getElementById('ruanganModal')).hide();
                fetchData();
            } else {
                throw result;
            }
        })
        .catch(err => {
            const msg = err?.message || (err?.errors ? Object.values(err.errors).flat().join(', ') : 'Terjadi kesalahan');
            showToast('Gagal menyimpan: ' + msg, 'error');
        })
        .finally(() => setSubmitLoading(false));
    });

    /* Delete confirm */
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteId) return;
        setDeleteLoading(true);

        fetch(`${API_URL}/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            }
        })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(result => {
            if (result.success) {
                const item = allData.find(x => x.id === deleteId);
                showToast(`Ruangan "${item?.nama_ruangan || ''}" berhasil dihapus`, 'success');
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                fetchData();
            } else {
                throw result;
            }
        })
        .catch(err => {
            showToast('Gagal menghapus: ' + (err?.message || 'Terjadi kesalahan'), 'error');
        })
        .finally(() => { setDeleteLoading(false); deleteId = null; });
    });

    /* Reset modal on close */
    document.getElementById('ruanganModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('ruanganForm').reset();
        document.getElementById('ruanganForm').classList.remove('was-validated');
        document.getElementById('modalTitle').textContent   = 'Tambah Ruangan';
        document.getElementById('submitText').textContent   = 'Simpan';
        editingId = null;
    });

    /* Search & filter listeners */
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('filterLokasi').addEventListener('change', applyFilters);

    /* Init */
    document.addEventListener('DOMContentLoaded', fetchData);
</script>
@endpush
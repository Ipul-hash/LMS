@extends('layouts.app')

@section('title', 'Approve Rencana Studi')
@section('page-title', 'Approve Rencana Studi')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Approve Rencana Studi</li>
@endsection

@section('content')

{{-- ========================= STAT CARDS ========================= --}}
<div class="row g-4 mb-6">
    <div class="col-6 col-xl-3">
        <div class="ap-stat-card ap-stat-blue">
            <div class="ap-stat-pattern"></div>
            <div class="ap-stat-label">Total Bimbingan</div>
            <div class="ap-stat-value" id="statTotal">–</div>
            <div class="ap-stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="ap-stat-card ap-stat-amber">
            <div class="ap-stat-pattern"></div>
            <div class="ap-stat-label">Menunggu Review</div>
            <div class="ap-stat-value" id="statMenunggu">–</div>
            <div class="ap-stat-icon"><i class="bi bi-hourglass-split"></i></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="ap-stat-card ap-stat-green">
            <div class="ap-stat-pattern"></div>
            <div class="ap-stat-label">Disetujui</div>
            <div class="ap-stat-value" id="statDisetujui">–</div>
            <div class="ap-stat-icon"><i class="bi bi-patch-check-fill"></i></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="ap-stat-card ap-stat-red">
            <div class="ap-stat-pattern"></div>
            <div class="ap-stat-label">Ditolak</div>
            <div class="ap-stat-value" id="statDitolak">–</div>
            <div class="ap-stat-icon"><i class="bi bi-x-circle-fill"></i></div>
        </div>
    </div>
</div>

{{-- ========================= MAIN CARD ========================= --}}
<div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden">

    <div class="card-header border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3 py-4 px-6">
        <div class="d-flex align-items-center gap-3">
            <div class="ap-header-icon"><i class="bi bi-journal-check"></i></div>
            <div>
                <h5 class="mb-0 fw-bold text-gray-900" style="font-size:1rem">Daftar KRS Mahasiswa Bimbingan</h5>
                <div class="text-muted fs-7 mt-1">Review dan berikan keputusan untuk setiap pengajuan KRS</div>
            </div>
        </div>
        <div class="ap-semester-wrap">
            <i class="bi bi-calendar3 ap-sel-icon"></i>
            <select class="ap-semester-sel" id="semesterSelect" onchange="loadKRSList()">
                <option value="2026/Genap" selected>2025/2026 Genap</option>
                <option value="2025/Ganjil">2025/2026 Ganjil</option>
                <option value="2025/Genap">2024/2025 Genap</option>
                <option value="2024/Ganjil">2024/2025 Ganjil</option>
            </select>
            <i class="bi bi-chevron-down ap-sel-arrow"></i>
        </div>
    </div>

    <div class="px-6 py-4 border-bottom" style="background:#fafbfc">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="ap-search-box">
                <i class="bi bi-search ap-search-icon"></i>
                <input type="text" class="ap-search-input"
                    placeholder="Cari nama atau NIM mahasiswa..."
                    id="searchInput" oninput="filterList()">
            </div>
            <div class="d-flex gap-2 flex-wrap" id="filterChips">
                <button class="ap-chip active" onclick="setFilter('all',this)">Semua</button>
                <button class="ap-chip" onclick="setFilter('menunggu',this)">
                    <span class="ap-chip-dot dot-amber"></span>Menunggu
                </button>
                <button class="ap-chip" onclick="setFilter('disetujui',this)">
                    <span class="ap-chip-dot dot-green"></span>Disetujui
                </button>
                <button class="ap-chip" onclick="setFilter('ditolak',this)">
                    <span class="ap-chip-dot dot-red"></span>Ditolak
                </button>
                <button class="ap-chip" onclick="setFilter('draft',this)">
                    <span class="ap-chip-dot dot-gray"></span>Draft / Kosong
                </button>
            </div>
            <span class="ms-auto text-muted fs-7" id="listCount"></span>
        </div>
    </div>

    <div class="card-body p-0">
        <div id="listLoading" class="d-flex align-items-center justify-content-center py-16">
            <div class="ap-spinner"></div>
            <span class="text-muted fs-6 ms-3">Memuat data bimbingan...</span>
        </div>
        <div id="listTableWrapper" class="d-none">
            <table class="table table-row-dashed table-row-gray-200 align-middle mb-0">
                <thead>
                    <tr class="text-muted fw-semibold fs-7 text-uppercase border-bottom">
                        <th class="ps-6 py-4" style="width:44px">#</th>
                        <th class="py-4">Mahasiswa</th>
                        <th class="py-4 text-center" style="width:100px">Total MK</th>
                        <th class="py-4 text-center" style="width:80px">SKS</th>
                        <th class="py-4 text-center" style="width:140px">Status KRS</th>
                        <th class="py-4 text-center" style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="listBody" class="fs-6 text-gray-700"></tbody>
            </table>
        </div>
        <div id="listEmpty" class="d-none text-center py-16">
            <div style="font-size:3rem;color:#d1d5db"><i class="bi bi-inbox"></i></div>
            <div class="fw-bold text-gray-600 fs-5 mt-4">Tidak Ada Data</div>
            <div class="text-muted fs-7 mt-1" id="emptySubtitle">Belum ada mahasiswa bimbingan</div>
        </div>
    </div>
</div>

{{-- ========================= OFFCANVAS ========================= --}}
<div class="offcanvas offcanvas-end ap-offcanvas" tabindex="-1" id="krsDetailPanel" data-bs-scroll="true">

    {{-- Header --}}
    <div class="offcanvas-header border-bottom ap-panel-header">
        <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">
            <div class="ap-avatar" id="panelAvatar">–</div>
            <div class="min-w-0">
                <div class="fw-bold text-gray-900 fs-5 text-truncate" id="panelNama">–</div>
                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="ap-nim-chip" id="panelNIM">–</span>
                    <span id="panelStatusBadge"></span>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close ms-3 flex-shrink-0" data-bs-dismiss="offcanvas"></button>
    </div>

    {{-- Meta --}}
    <div class="px-5 py-3 border-bottom" style="background:#fafbff">
        <div class="d-flex gap-2 flex-wrap">
            <span class="ap-meta-pill"><i class="bi bi-book text-primary me-1"></i><span id="panelTotalMK">0 MK</span></span>
            <span class="ap-meta-pill"><i class="bi bi-bar-chart text-success me-1"></i><span id="panelTotalSKS">0 SKS</span></span>
            <span class="ap-meta-pill"><i class="bi bi-calendar3 text-warning me-1"></i><span id="panelSemester">–</span></span>
        </div>
    </div>

    {{-- Scrollable body --}}
    <div class="offcanvas-body p-0" style="display:flex;flex-direction:column;overflow:hidden">

        {{-- Loading --}}
        <div id="panelLoading" class="d-flex align-items-center justify-content-center flex-grow-1 py-12">
            <div class="ap-spinner"></div>
            <span class="text-muted fs-7 ms-3">Memuat detail KRS...</span>
        </div>

        {{-- Empty --}}
        <div id="panelEmpty" class="d-none text-center flex-grow-1 d-flex flex-column align-items-center justify-content-center py-10">
            <div style="font-size:2.5rem;color:#d1d5db"><i class="bi bi-clipboard-x"></i></div>
            <div class="fw-bold text-gray-600 fs-6 mt-3">Belum Ada KRS</div>
            <div class="text-muted fs-7 mt-1">Mahasiswa ini belum mengajukan KRS</div>
        </div>

        {{-- Content --}}
        <div id="panelContent" class="d-none" style="display:flex!important;flex-direction:column;flex:1;overflow:hidden">

            {{-- MK list header --}}
            <div class="px-5 py-3 border-bottom d-flex align-items-center justify-content-between flex-shrink-0">
                <span class="fw-bold text-gray-800 fs-6">
                    <i class="bi bi-list-ul text-primary me-2"></i>Daftar Mata Kuliah
                </span>
                <span class="ap-badge ap-badge-primary" id="panelMKCount">0 MK</span>
            </div>

            {{-- MK scrollable list --}}
            <div id="panelMKList" class="px-4 py-3" style="overflow-y:auto;flex:1"></div>

            {{-- Catatan --}}
            <div class="px-5 pt-4 pb-3 border-top flex-shrink-0" style="background:#fafbfc">
                <label class="fw-semibold text-gray-700 fs-7 mb-2 d-block">
                    <i class="bi bi-chat-left-text text-muted me-1"></i>
                    Catatan <span class="text-muted fw-normal">(opsional)</span>
                </label>
                <textarea class="ap-textarea" id="catatanInput" rows="2"
                    placeholder="Tulis catatan atau alasan keputusan..."></textarea>
            </div>

            {{-- Decision buttons --}}
            <div class="px-5 pb-5 pt-3 flex-shrink-0" style="background:#fafbfc">
                <div class="d-flex gap-2 mb-2">
                    <button class="ap-btn-decision ap-btn-reject"  id="btnReject"  onclick="submitDecision('rejected')">
                        <i class="bi bi-x-lg me-1"></i>Tolak
                    </button>
                    <button class="ap-btn-decision ap-btn-pending" id="btnPending" onclick="submitDecision('pending')">
                        <i class="bi bi-hourglass-split me-1"></i>Menunggu
                    </button>
                    <button class="ap-btn-decision ap-btn-approve" id="btnApprove" onclick="submitDecision('approved')">
                        <i class="bi bi-check-lg me-1"></i>Setujui
                    </button>
                </div>
                <div class="text-muted fs-8" id="decisionNote">Pilih keputusan untuk KRS mahasiswa ini</div>
            </div>

        </div>
    </div>
</div>

<div id="toastContainer" class="ap-toast-container"></div>

@endsection

@push('styles')
<style>
/* ── Stat Cards ────────────────────────────── */
.ap-stat-card {
    position:relative;border-radius:14px;padding:22px 22px 18px;
    color:#fff;overflow:hidden;min-height:108px;
    display:flex;flex-direction:column;justify-content:space-between;
    box-shadow:0 4px 20px rgba(0,0,0,.14);transition:transform .2s,box-shadow .2s;
}
.ap-stat-card:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(0,0,0,.2); }
.ap-stat-blue  { background:linear-gradient(135deg,#2563eb,#1e40af); }
.ap-stat-amber { background:linear-gradient(135deg,#d97706,#b45309); }
.ap-stat-green { background:linear-gradient(135deg,#059669,#047857); }
.ap-stat-red   { background:linear-gradient(135deg,#dc2626,#b91c1c); }
.ap-stat-pattern {
    position:absolute;inset:0;
    background-image:radial-gradient(circle at 80% 10%,rgba(255,255,255,.14) 0%,transparent 50%),
                     radial-gradient(circle at 15% 85%,rgba(255,255,255,.08) 0%,transparent 40%);
}
.ap-stat-label { font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;opacity:.78;position:relative;z-index:1; }
.ap-stat-value { font-size:2rem;font-weight:800;letter-spacing:-.5px;line-height:1;position:relative;z-index:1; }
.ap-stat-icon  { position:absolute;right:18px;bottom:14px;font-size:2.6rem;opacity:.15; }

/* ── Header Icon ───────────────────────────── */
.ap-header-icon {
    width:42px;height:42px;border-radius:10px;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    color:#2563eb;font-size:1.2rem;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
}

/* ── Semester Select ───────────────────────── */
.ap-semester-wrap { position:relative;display:inline-flex;align-items:center; }
.ap-sel-icon  { position:absolute;left:11px;color:#aaa;font-size:13px;pointer-events:none; }
.ap-semester-sel {
    appearance:none;border:1px solid #e5e7eb;border-radius:8px;
    padding:8px 32px 8px 32px;font-size:.855rem;font-weight:600;
    color:#374151;background:#fff;cursor:pointer;outline:none;transition:border-color .2s;
}
.ap-semester-sel:focus { border-color:#2563eb; }
.ap-sel-arrow { position:absolute;right:11px;font-size:10px;color:#aaa;pointer-events:none; }

/* ── Search & Filter ───────────────────────── */
.ap-search-box { position:relative;width:280px; }
.ap-search-icon { position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px;pointer-events:none; }
.ap-search-input {
    width:100%;border:1px solid #e5e7eb;border-radius:8px;
    padding:8px 12px 8px 32px;font-size:.855rem;color:#374151;
    outline:none;background:#fff;transition:border-color .2s;
}
.ap-search-input:focus { border-color:#2563eb; }

.ap-chip {
    display:inline-flex;align-items:center;gap:6px;
    border:1px solid #e5e7eb;border-radius:20px;
    padding:5px 14px;font-size:.78rem;font-weight:600;
    color:#6b7280;background:#fff;cursor:pointer;transition:all .18s;
}
.ap-chip:hover { border-color:#2563eb;color:#2563eb;background:#eff6ff; }
.ap-chip.active { background:#2563eb;border-color:#2563eb;color:#fff; }
.ap-chip-dot { width:7px;height:7px;border-radius:50%;flex-shrink:0; }
.dot-amber { background:#d97706; }
.dot-green { background:#059669; }
.dot-red   { background:#dc2626; }
.dot-gray  { background:#9ca3af; }

/* ── Table ─────────────────────────────────── */
.table-row-dashed tbody tr { border-bottom:1px dashed #f3f4f6!important; }
.table-row-dashed tbody tr:last-child { border-bottom:none!important; }
.table-row-dashed tbody tr:hover { background:#f9fafb; }
.ap-row-pending { background:#fffbf0!important; }
.ap-row-pending:hover { background:#fff8e7!important; }

.ap-avatar-sm {
    width:34px;height:34px;border-radius:9px;
    font-size:.78rem;font-weight:800;flex-shrink:0;
    display:inline-flex;align-items:center;justify-content:center;
    color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);
}
.ap-nim-chip {
    font-size:.72rem;font-weight:700;font-family:'Courier New',monospace;
    background:#eff6ff;color:#2563eb;
    padding:.2rem .5rem;border-radius:5px;border:1px solid #dbeafe;display:inline-block;
}

/* ── Badges ────────────────────────────────── */
.ap-badge {
    display:inline-flex;align-items:center;gap:5px;
    padding:.28rem .7rem;border-radius:20px;
    font-size:.72rem;font-weight:700;white-space:nowrap;
}
.ap-badge-dot { width:6px;height:6px;border-radius:50%; }
.ap-badge-menunggu  { background:#fef3c7;color:#92400e; }
.ap-badge-menunggu  .ap-badge-dot { background:#d97706; }
.ap-badge-disetujui { background:#d1fae5;color:#065f46; }
.ap-badge-disetujui .ap-badge-dot { background:#059669; }
.ap-badge-ditolak   { background:#fee2e2;color:#991b1b; }
.ap-badge-ditolak   .ap-badge-dot { background:#dc2626; }
.ap-badge-draft     { background:#f3f4f6;color:#6b7280; }
.ap-badge-draft     .ap-badge-dot { background:#9ca3af; }
.ap-badge-primary   { background:#dbeafe;color:#1d4ed8;font-size:.72rem;font-weight:700;border-radius:20px;padding:.25rem .7rem; }

/* ── Action Buttons (table) ────────────────── */
.btn-review {
    display:inline-flex;align-items:center;gap:6px;
    border:1.5px solid #2563eb;border-radius:7px;
    padding:6px 14px;font-size:.785rem;font-weight:700;
    color:#2563eb;background:#eff6ff;cursor:pointer;transition:all .18s;
}
.btn-review:hover { background:#2563eb;color:#fff;box-shadow:0 3px 10px rgba(37,99,235,.25); }
.btn-lihat {
    display:inline-flex;align-items:center;gap:6px;
    border:1px solid #e5e7eb;border-radius:7px;
    padding:6px 14px;font-size:.785rem;font-weight:600;
    color:#6b7280;background:#f9fafb;cursor:pointer;transition:all .18s;
}
.btn-lihat:hover { border-color:#2563eb;color:#2563eb;background:#eff6ff; }

/* ── Offcanvas ─────────────────────────────── */
.ap-offcanvas {
    width:520px!important;
    border-left:1px solid #f0f0f0!important;
    box-shadow:-8px 0 40px rgba(0,0,0,.1)!important;
}
@media(max-width:600px){ .ap-offcanvas { width:100vw!important; } }

.ap-panel-header { padding:18px 20px;background:linear-gradient(135deg,#fafbff,#f0f4ff); }
.ap-avatar {
    width:44px;height:44px;border-radius:12px;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:#fff;font-size:1rem;font-weight:800;
    display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;
}
.ap-meta-pill {
    display:inline-flex;align-items:center;
    background:#fff;border:1px solid #e5e7eb;
    border-radius:20px;padding:.3rem .75rem;
    font-size:.8rem;font-weight:600;color:#374151;
}

/* ── MK Card ───────────────────────────────── */
.ap-mk-card {
    border:1px solid #f0f0f0;border-radius:10px;
    padding:13px 14px;margin-bottom:8px;
    background:#fff;transition:border-color .2s,box-shadow .2s;
}
.ap-mk-card:hover { border-color:#dbeafe;box-shadow:0 2px 8px rgba(37,99,235,.08); }
.ap-mk-card:last-child { margin-bottom:0; }
.ap-mk-kode {
    font-size:.7rem;font-weight:700;font-family:'Courier New',monospace;
    background:#eff6ff;color:#2563eb;
    padding:.18rem .5rem;border-radius:4px;border:1px solid #dbeafe;display:inline-block;
}
.ap-mk-sks {
    min-width:40px;height:24px;border-radius:6px;
    background:#2563eb;color:#fff;
    font-size:.7rem;font-weight:800;
    display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;
}
.ap-jadwal-hari { font-size:.78rem;font-weight:700;color:#1a1a2e; }
.ap-jadwal-jam  { font-size:.74rem;color:#9ca3af; }

/* ── Textarea ──────────────────────────────── */
.ap-textarea {
    width:100%;border:1px solid #e5e7eb;border-radius:8px;
    padding:9px 12px;font-size:.855rem;color:#374151;
    outline:none;resize:none;background:#fff;transition:border-color .2s;
}
.ap-textarea:focus { border-color:#2563eb; }

/* ── Decision Buttons ──────────────────────── */
.ap-btn-decision {
    flex:1;border-radius:9px;font-size:.855rem;font-weight:700;
    padding:10px 8px;cursor:pointer;transition:all .2s;
    display:inline-flex;align-items:center;justify-content:center;
    gap:5px;white-space:nowrap;
}
.ap-btn-reject  { background:#fff;border:1.5px solid #dc2626;color:#dc2626; }
.ap-btn-reject:hover:not(:disabled)  { background:#fee2e2; }
.ap-btn-reject.is-active             { background:#fee2e2; }

.ap-btn-pending { background:#fff;border:1.5px solid #d97706;color:#d97706; }
.ap-btn-pending:hover:not(:disabled) { background:#fef3c7; }
.ap-btn-pending.is-active            { background:#fef3c7; }

.ap-btn-approve { background:linear-gradient(135deg,#059669,#047857);border:none;color:#fff;box-shadow:0 3px 12px rgba(5,150,105,.28); }
.ap-btn-approve:hover:not(:disabled) { box-shadow:0 5px 18px rgba(5,150,105,.4);transform:translateY(-1px); }
.ap-btn-approve.is-active            { box-shadow:0 5px 18px rgba(5,150,105,.4); }

.ap-btn-decision:disabled { opacity:.5;cursor:default;transform:none; }

/* ── Spinner ───────────────────────────────── */
.ap-spinner {
    width:20px;height:20px;flex-shrink:0;
    border:2px solid #e5e7eb;border-top-color:#2563eb;
    border-radius:50%;animation:apSpin .7s linear infinite;
}
.btn-spin {
    width:14px;height:14px;border:2px solid rgba(255,255,255,.4);
    border-top-color:#fff;border-radius:50%;
    animation:apSpin .6s linear infinite;
    display:inline-block;vertical-align:middle;
}
.btn-spin-dark {
    width:14px;height:14px;border:2px solid rgba(0,0,0,.15);
    border-top-color:currentColor;border-radius:50%;
    animation:apSpin .6s linear infinite;
    display:inline-block;vertical-align:middle;
}
@keyframes apSpin { to{transform:rotate(360deg)} }

/* ── Toast ─────────────────────────────────── */
.ap-toast-container { position:fixed;bottom:24px;right:24px;z-index:1100;display:flex;flex-direction:column;gap:10px; }
.ap-toast {
    background:#fff;border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.14);
    display:flex;align-items:center;gap:12px;
    padding:13px 18px;min-width:280px;max-width:380px;
    position:relative;overflow:hidden;animation:apSlideIn .3s ease;
}
.ap-toast::before { content:'';position:absolute;left:0;top:0;bottom:0;width:4px; }
.ap-toast.t-success::before { background:#10b981; }
.ap-toast.t-error::before   { background:#ef4444; }
.ap-toast.t-warning::before { background:#f59e0b; }
.ap-toast.t-info::before    { background:#3b82f6; }
.ap-toast-ic { width:34px;height:34px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:15px; }
.ap-toast.t-success .ap-toast-ic { background:#d1fae5;color:#059669; }
.ap-toast.t-error   .ap-toast-ic { background:#fee2e2;color:#dc2626; }
.ap-toast.t-warning .ap-toast-ic { background:#fef3c7;color:#d97706; }
.ap-toast.t-info    .ap-toast-ic { background:#dbeafe;color:#2563eb; }
.ap-toast-msg { font-size:.855rem;font-weight:600;color:#1f2937;line-height:1.4; }
@keyframes apSlideIn  { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:none} }
@keyframes apSlideOut { from{opacity:1} to{opacity:0;transform:translateX(20px)} }
</style>
@endpush

@push('scripts')
<script>
/* ── State ──────────────────────────────────────── */
let allStudents  = [];
let activeFilter = 'all';
let activeSearch = '';
let panelKrsId   = null;
let panelUserId  = null;

const API_PA = '/api/v1/pa';

/* ── Helpers ────────────────────────────────────── */
function esc(v) {
    if (v == null) return '';
    return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
                    .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}
function fmtJam(t) { return t ? String(t).slice(0,5) : '–'; }
function csrf()    { return document.querySelector('meta[name="csrf-token"]')?.content||''; }
function getPeriode() { return document.getElementById('semesterSelect').value; }
function initials(n) { return (n||'?').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase(); }
function show(id)  { const el=document.getElementById(id); if(el) el.classList.remove('d-none'); }
function hide(id)  { const el=document.getElementById(id); if(el) el.classList.add('d-none'); }

/* ── Toast ──────────────────────────────────────── */
function showToast(msg, type='info') {
    const icons={success:'<i class="bi bi-check-lg"></i>',error:'<i class="bi bi-x-lg"></i>',
                 warning:'<i class="bi bi-exclamation"></i>',info:'<i class="bi bi-info-lg"></i>'};
    const id='t'+Date.now();
    document.getElementById('toastContainer').insertAdjacentHTML('beforeend',`
        <div id="${id}" class="ap-toast t-${type}">
            <div class="ap-toast-ic">${icons[type]||icons.info}</div>
            <div class="ap-toast-msg">${esc(msg)}</div>
        </div>`);
    const el=document.getElementById(id);
    setTimeout(()=>{el.style.animation='apSlideOut .3s ease forwards';setTimeout(()=>el.remove(),300);},4000);
}

/* ── Status (API returns lowercase) ────────────── */
function normSt(s) { return (s||'draft').toLowerCase(); }

function statusBadge(raw) {
    const s=normSt(raw);
    const map={
        menunggu:  ['ap-badge ap-badge-menunggu','pending'],
        disetujui: ['ap-badge ap-badge-disetujui','approved'],
        ditolak:   ['ap-badge ap-badge-ditolak','rejected'],
        draft:     ['ap-badge ap-badge-draft','draft'],
    };
    const [cls,label]=map[s]||['ap-badge ap-badge-draft',s||'draft'];
    return `<span class="${cls}"><span class="ap-badge-dot"></span>${label}</span>`;
}

/* ── Parse student data from list endpoint ──────── */
function getKrs(student)    { return student.krs?.length ? student.krs[0] : null; }
function getSt(student)     { const k=getKrs(student); return k ? normSt(k.status) : 'draft'; }
function getItems(student)  { const k=getKrs(student); return k?(k.items||k.detail_krs||k.detail||[]):[] ; }
function getSKS(student)    {
    return getItems(student).reduce((a,item)=>{
        const sks=item.sks_point??item.kelas?.mata_kuliah?.sks??item.kelas?.mataKuliah?.sks??0;
        return a+(parseInt(sks)||0);
    },0);
}

/* ── Stats ──────────────────────────────────────── */
function updateStats(data) {
    document.getElementById('statTotal').textContent     = data.length;
    document.getElementById('statMenunggu').textContent  = data.filter(s=>getSt(s)==='menunggu').length;
    document.getElementById('statDisetujui').textContent = data.filter(s=>getSt(s)==='disetujui').length;
    document.getElementById('statDitolak').textContent   = data.filter(s=>getSt(s)==='ditolak').length;
}

/* ── Load list ──────────────────────────────────── */
function loadKRSList() {
    show('listLoading'); hide('listTableWrapper'); hide('listEmpty');
    fetch(`${API_PA}/krs-request?periode_semester=${encodeURIComponent(getPeriode())}`,{
        headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
    })
    .then(r=>{if(!r.ok)throw new Error(`HTTP ${r.status}`);return r.json();})
    .then(res=>{
        hide('listLoading');
        if(res.success && Array.isArray(res.data)){
            allStudents=res.data;
            updateStats(allStudents);
            applyFilter();
        } else throw new Error(res.message||'Gagal memuat');
    })
    .catch(err=>{
        hide('listLoading'); show('listEmpty');
        document.getElementById('emptySubtitle').textContent='Gagal memuat: '+err.message;
    });
}

/* ── Filter ─────────────────────────────────────── */
function setFilter(f,el) {
    activeFilter=f;
    document.querySelectorAll('.ap-chip').forEach(c=>c.classList.remove('active'));
    el.classList.add('active');
    applyFilter();
}
function filterList() { activeSearch=document.getElementById('searchInput').value.toLowerCase().trim(); applyFilter(); }
function applyFilter() {
    const filtered=allStudents.filter(s=>{
        const st=getSt(s);
        const mF=activeFilter==='all'||st===activeFilter;
        const mS=!activeSearch||s.name.toLowerCase().includes(activeSearch)||(s.nim_nip||'').toLowerCase().includes(activeSearch);
        return mF&&mS;
    });
    renderList(filtered);
}

/* ── Render list ────────────────────────────────── */
function renderList(data) {
    document.getElementById('listCount').textContent=`${data.length} mahasiswa`;
    if(!data.length){
        hide('listTableWrapper'); show('listEmpty');
        document.getElementById('emptySubtitle').textContent=
            activeSearch?`Tidak ditemukan "${activeSearch}"`:'Tidak ada data untuk filter ini';
        return;
    }
    hide('listEmpty'); show('listTableWrapper');
    document.getElementById('listBody').innerHTML=data.map((s,i)=>{
        const st=getSt(s), items=getItems(s), krs=getKrs(s), sks=getSKS(s);
        const isPending=st==='menunggu';
        return `
        <tr class="${isPending?'ap-row-pending':''}">
            <td class="ps-6 py-4 text-muted fs-8">${i+1}</td>
            <td class="py-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="ap-avatar-sm">${esc(initials(s.name))}</div>
                    <div>
                        <div class="fw-bold text-gray-800 fs-6">${esc(s.name)}</div>
                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            <span class="ap-nim-chip">${esc(s.nim_nip)}</span>
                            <span class="text-muted fs-8">${esc(s.email)}</span>
                        </div>
                    </div>
                </div>
            </td>
            <td class="py-4 text-center">
                ${krs?`<span class="fw-bold text-gray-700 fs-6">${items.length}</span><span class="text-muted fs-8"> MK</span>`:'<span class="text-muted">–</span>'}
            </td>
            <td class="py-4 text-center">
                ${krs?`<span class="fw-bold text-primary fs-6">${sks}</span><span class="text-muted fs-8"> SKS</span>`:'<span class="text-muted">–</span>'}
            </td>
            <td class="py-4 text-center">${statusBadge(st)}</td>
            <td class="py-4 text-center">
                <button class="${isPending?'btn-review':'btn-lihat'}" onclick="openDetail(${s.id})">
                    <i class="bi bi-eye${isPending?'':'-fill'}"></i>${isPending?'Review':'Lihat'}
                </button>
            </td>
        </tr>`;
    }).join('');
}

/* ── Open detail panel ──────────────────────────── */
function openDetail(userId) {
    panelUserId=userId; panelKrsId=null;

    // Reset
    hide('panelContent'); hide('panelEmpty'); show('panelLoading');
    document.getElementById('catatanInput').value='';
    document.getElementById('decisionNote').textContent='Memuat keputusan...';
    ['btnApprove','btnReject','btnPending'].forEach(id=>{
        const b=document.getElementById(id);
        b.disabled=true; b.classList.remove('is-active');
    });

    // Prefill header from local cache
    const s=allStudents.find(x=>x.id===userId);
    if(s){
        document.getElementById('panelAvatar').textContent    = initials(s.name);
        document.getElementById('panelNama').textContent      = s.name;
        document.getElementById('panelNIM').textContent       = s.nim_nip;
        document.getElementById('panelSemester').textContent  = getPeriode().replace('/',' ');
        document.getElementById('panelStatusBadge').innerHTML = statusBadge(getSt(s));
        document.getElementById('panelTotalMK').textContent   = getItems(s).length+' MK';
        document.getElementById('panelTotalSKS').textContent  = getSKS(s)+' SKS';
    }

    bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('krsDetailPanel')).show();

    fetch(`${API_PA}/krs-request/${userId}`,{
        headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
    })
    .then(r=>{if(!r.ok)throw new Error(`HTTP ${r.status}`);return r.json();})
    .then(res=>{
        hide('panelLoading');
        if(!res.success||!res.data){ show('panelEmpty'); return; }

        const payload=res.data;

        /*
         * Deteksi shape response:
         * Shape A: data = KRS object langsung  → { id, status, items, mahasiswa, ... }
         * Shape B: data = User object          → { id, krs: [{...}], ... }
         */
        let krs, mahasiswa;
        if('items' in payload || 'mahasiswa_id' in payload) {
            // Shape A — data IS the krs object
            krs       = payload;
            mahasiswa = payload.mahasiswa || s;
        } else if(payload.krs?.length) {
            // Shape B — data is user with krs array
            krs       = payload.krs[0];
            mahasiswa = payload;
        } else {
            // User has no KRS
            show('panelEmpty'); return;
        }

        panelKrsId = krs.id;
        const krsStatus = normSt(krs.status);

        // Support items / detail_krs / detail
        const items = krs.items || krs.detail_krs || krs.detail || [];

        // Recompute from real data
        const totalSKS = items.reduce((a,item)=>{
            const sks=item.sks_point??item.kelas?.mata_kuliah?.sks??item.kelas?.mataKuliah?.sks??0;
            return a+(parseInt(sks)||0);
        },0);

        // Update header with fresh data
        if(mahasiswa){
            document.getElementById('panelNama').textContent      = mahasiswa.name||mahasiswa.nama||'';
            document.getElementById('panelNIM').textContent       = mahasiswa.nim_nip||'';
            document.getElementById('panelAvatar').textContent    = initials(mahasiswa.name||mahasiswa.nama||'?');
        }
        document.getElementById('panelStatusBadge').innerHTML = statusBadge(krsStatus);
        document.getElementById('panelTotalMK').textContent   = items.length+' MK';
        document.getElementById('panelTotalSKS').textContent  = totalSKS+' SKS';
        document.getElementById('panelMKCount').textContent   = items.length+' MK';

        // Pre-fill notes
        if(krs.notes||krs.catatan){
            document.getElementById('catatanInput').value=krs.notes||krs.catatan||'';
        }

        // Render MK cards
        const mkList=document.getElementById('panelMKList');
        if(!items.length){
            mkList.innerHTML=`
                <div class="text-center text-muted fs-7 py-8">
                    <i class="bi bi-inbox fs-2 d-block mb-2" style="opacity:.35"></i>
                    Belum ada mata kuliah dipilih
                </div>`;
        } else {
            mkList.innerHTML=items.map((item,idx)=>{
                // Flatten: support nested kelas OR flat fields
                const mk    = item.kelas?.mata_kuliah || item.kelas?.mataKuliah || item.mata_kuliah || {};
                const dosen = item.kelas?.dosen || item.dosen || {};
                const kelas = item.kelas || {};
                const sks         = item.sks_point ?? mk.sks ?? '–';
                const nama        = mk.nama_matkul || mk.nama || kelas.nama_kelas || `Kelas ID ${item.kelas_id||''}`;
                const kode        = mk.kode_matkul || mk.kode || '–';
                const hari        = kelas.hari || item.hari || '–';
                const jamMulai    = kelas.jam_mulai   || item.jam_mulai   || '';
                const jamSelesai  = kelas.jam_selesai || item.jam_selesai || '';
                const dosenName   = dosen.name || dosen.nama || '–';
                const namaKelas   = kelas.nama_kelas || item.nama_kelas || '';

                return `
                <div class="ap-mk-card">
                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <span class="ap-mk-kode">${esc(kode)}</span>
                        <span class="ap-mk-sks">${esc(sks)} SKS</span>
                        <span class="text-muted fs-8 ms-auto">#${idx+1}</span>
                    </div>
                    <div class="fw-bold text-gray-800 fs-6 mb-2">${esc(nama)}</div>
                    <div class="d-flex gap-4 flex-wrap">
                        <div>
                            <div class="ap-jadwal-hari">${esc(hari)}</div>
                            <div class="ap-jadwal-jam">${fmtJam(jamMulai)} – ${fmtJam(jamSelesai)}</div>
                        </div>
                        ${dosenName!=='–'?`<div class="text-muted fs-8 d-flex align-items-center gap-1"><i class="bi bi-person"></i>${esc(dosenName)}</div>`:''}
                        ${namaKelas?`<div class="text-muted fs-8 d-flex align-items-center gap-1"><i class="bi bi-door-open"></i>${esc(namaKelas)}</div>`:''}
                    </div>
                </div>`;
            }).join('');
        }

        // Show content section
        show('panelContent');

        // Enable buttons & highlight current status
        ['btnApprove','btnReject','btnPending'].forEach(id=>document.getElementById(id).disabled=false);
        if(krsStatus==='disetujui') document.getElementById('btnApprove').classList.add('is-active');
        if(krsStatus==='ditolak')   document.getElementById('btnReject').classList.add('is-active');
        if(krsStatus==='menunggu')  document.getElementById('btnPending').classList.add('is-active');

        const stLabels={disetujui:'Disetujui',ditolak:'Ditolak',menunggu:'Menunggu',draft:'Draft'};
        document.getElementById('decisionNote').textContent=
            `Status saat ini: ${stLabels[krsStatus]||krsStatus}. Anda dapat mengubah keputusan.`;
    })
    .catch(err=>{
        hide('panelLoading'); show('panelEmpty');
        console.error('Detail error:', err);
    });
}

/* ── Submit decision ────────────────────────────── */
function submitDecision(decision) {
    if(!panelKrsId){ showToast('Tidak ada KRS yang bisa diproses.','warning'); return; }

    const btnMap = { 'approved': 'btnApprove', 'rejected': 'btnReject', 'pending': 'btnPending' };
    const activeId = btnMap[decision];
    const catatan=document.getElementById('catatanInput').value.trim();

    ['btnApprove','btnReject','btnPending'].forEach(id=>document.getElementById(id).disabled=true);
    const btn=document.getElementById(activeId);
    const orig=btn.innerHTML;
    const spinCls=decision==='approved'?'btn-spin':'btn-spin-dark';
    btn.innerHTML=`<span class="${spinCls}"></span> Memproses...`;

    fetch(`${API_PA}/krs/${panelKrsId}/decision`,{
        method:'PUT',
        headers:{
            'Accept':'application/json','Content-Type':'application/json',
            'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':csrf(),
        },
        body:JSON.stringify({ status:decision, catatan:catatan||undefined, notes:catatan||undefined })
    })
    .then(r=>{if(!r.ok)return r.json().then(e=>Promise.reject(e));return r.json();})
    .then(result=>{
        if(!result.success) throw result;

        // Update local state
        const idx=allStudents.findIndex(s=>s.id===panelUserId);
        if(idx!==-1&&allStudents[idx].krs?.length) allStudents[idx].krs[0].status=decision;
        updateStats(allStudents);
        applyFilter();

        // Update panel
        document.getElementById('panelStatusBadge').innerHTML=statusBadge(decision);
        ['btnApprove','btnReject','btnPending'].forEach(id=>{
            document.getElementById(id).disabled=false;
            document.getElementById(id).classList.remove('is-active');
        });
        document.getElementById(activeId).classList.add('is-active');
        btn.innerHTML=orig;

        const msgs={approved:'KRS berhasil disetujui ✓',rejected:'KRS berhasil ditolak',pending:'Status diubah ke Menunggu'};
        const types={approved:'success',rejected:'warning',pending:'info'};
        showToast(msgs[decision]||'Berhasil',types[decision]||'info');

        const stLabels={approved:'Disetujui',rejected:'Ditolak',pending:'Menunggu'};
        document.getElementById('decisionNote').textContent=`Keputusan terakhir: ${stLabels[decision]||decision}`;
    })
    .catch(err=>{
        ['btnApprove','btnReject','btnPending'].forEach(id=>document.getElementById(id).disabled=false);
        btn.innerHTML=orig;
        const msg=err?.message||(err?.errors?Object.values(err.errors).flat().join(', '):'Terjadi kesalahan');
        showToast('Gagal: '+msg,'error');
    });
}

document.addEventListener('DOMContentLoaded', loadKRSList);
</script>
@endpush
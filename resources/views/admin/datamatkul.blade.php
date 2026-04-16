@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('page-title', 'Mata Kuliah')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Data Mata Kuliah</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#matakuliahModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Mata Kuliah
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari mata kuliah..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Kode</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Mata Kuliah</th>
                                    <th style="width: 70px;" class="text-muted fw-bold fs-7 text-uppercase">SKS</th>
                                    <th style="width: 110px;" class="text-muted fw-bold fs-7 text-uppercase">Semester</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="matakuliahTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data mata kuliah</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="matakuliahModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="matakuliahForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Kode Mata Kuliah</label>
                            <input type="text" class="form-control form-control-lg" id="kodeMatkul" placeholder="Contoh: MATH101" required>
                            <small class="text-muted">Kode unik untuk identifikasi mata kuliah</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Mata Kuliah</label>
                            <input type="text" class="form-control form-control-lg" id="namaMatkul" placeholder="Contoh: Kalkulus I" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">SKS</label>
                            <input type="number" class="form-control form-control-lg" id="sks" min="1" max="6" placeholder="3" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Status</label>
                            <select class="form-select form-select-lg" id="status" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Hapus Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-circle icon-warning" style="margin: 0 auto;">
                            ⚠
                        </div>
                    </div>
                    <p class="text-gray-700 text-center mb-0">
                        Apakah Anda yakin ingin menghapus <strong id="deleteItemName"></strong>?
                    </p>
                    <p class="text-muted text-center fs-8 mt-2">Tindakan ini tidak dapat dibatalkan</p>
                </div>

                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    </div>
@endsection

@push('styles')
    <style>
        .table tbody tr {
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .bg-light-gray {
            background-color: #f8f9fa !important;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            border-radius: 4px;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-secondary {
            background-color: #e7e7e7;
            color: #666;
        }

        .badge-light-primary {
            background-color: #e7f1ff;
            color: #0052cc;
        }

        .btn-actions {
            display: flex;
            gap: 6px;
        }

        .btn-icon-sm {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .btn-icon-edit {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .btn-icon-edit:hover {
            background-color: #1976d2;
            color: white;
        }

        .btn-icon-delete {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .btn-icon-delete:hover {
            background-color: #d32f2f;
            color: white;
        }

        .toast {
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            border: none;
            min-width: 340px;
            animation: slideIn 0.3s ease;
        }

        .toast-header {
            background-color: transparent;
            border-bottom: none;
            padding: 0;
        }

        .toast-body {
            padding: 16px;
        }

        .toast-success {
            border-left: 4px solid #4caf50;
        }

        .toast-error {
            border-left: 4px solid #f44336;
        }

        .toast-info {
            border-left: 4px solid #2196f3;
        }

        .toast-warning {
            border-left: 4px solid #ff9800;
        }

        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-success {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .icon-error {
            background-color: #ffebee;
            color: #f44336;
        }

        .icon-info {
            background-color: #e3f2fd;
            color: #2196f3;
        }

        .icon-warning {
            background-color: #fff3e0;
            color: #ff9800;
        }

        .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.12);
        }

        .form-control-lg, .form-select-lg {
            border-radius: 4px;
            border: 1px solid #e0e0e0;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
        }

        .form-control-lg:focus, .form-select-lg:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }

        .form-label {
            color: #333;
        }

        small {
            display: block;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: #1976d2;
            border-color: #1976d2;
        }

        .btn-primary:hover {
            background-color: #1565c0;
            border-color: #1565c0;
        }

        .btn-danger {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }

        .btn-danger:hover {
            background-color: #c62828;
            border-color: #c62828;
        }

        .btn-light {
            background-color: #f5f5f5;
            border-color: #e0e0e0;
            color: #333;
        }

        .btn-light:hover {
            background-color: #eeeeee;
        }

        .text-muted {
            color: #999 !important;
        }

        .table td {
            padding: 12px 16px;
            vertical-align: middle;
        }

        .table th {
            padding: 12px 16px;
            font-weight: 700;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(20px);
            }
        }

        .text-gray-700 {
            color: #555;
        }

        .fs-8 {
            font-size: 0.75rem !important;
        }

        .text-primary {
            color: #1976d2 !important;
        }

        .text-gray-600 {
            color: #666 !important;
        }

        .text-gray-900 {
            color: #333 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let editingId = null;
        let deleteId = null;
        let currentData = [];
        let allData = [];

        const API_URL = '/api/v1/courses';

        function renderTable(data) {
            const tbody = document.getElementById('matakuliahTableBody');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }

            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => `
                <tr>
                    <td><span class="fw-bold text-primary">${item.kode_matkul}</span></td>
                    <td><span class="fw-semibold">${item.nama_matkul}</span></td>
                    <td><span class="badge badge-light-primary">${item.sks} SKS</span></td>
                    <td><span class="text-gray-600">-</span></td>
                    <td>
                        <span class="badge badge-success">
                            ✓ Aktif
                        </span>
                    </td>
                    <td>
                        <div class="btn-actions">
                            <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editMatkul(${item.id})" title="Edit">
                                ✎
                            </button>
                            <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.nama_matkul}')" title="Hapus">
                                ✕
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function fetchData() {
            const tbody = document.getElementById('matakuliahTableBody');
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4"><span class="text-muted">Memuat data...</span></td></tr>';

            fetch(API_URL, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                if (result.success && result.data) {
                    const data = Array.isArray(result.data) ? result.data : [result.data];
                    allData = data;
                    currentData = data;
                    renderTable(currentData);
                    showToast('Data mata kuliah berhasil dimuat', 'success');
                } else {
                    throw new Error(result.message || 'Gagal mengambil data');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                renderTable([]);
                showToast('Gagal memuat data: ' + error.message, 'error');
            });
        }

        function editMatkul(id) {
            const item = currentData.find(x => x.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Mata Kuliah';
            document.getElementById('kodeMatkul').value = item.kode_matkul;
            document.getElementById('namaMatkul').value = item.nama_matkul;
            document.getElementById('sks').value = item.sks;
            document.getElementById('status').value = 'aktif';

            const modal = new bootstrap.Modal(document.getElementById('matakuliahModal'));
            modal.show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        function deleteMatkul() {
            if (deleteId === null) return;

            const index = currentData.findIndex(x => x.id === deleteId);
            if (index > -1) {
                const deletedItem = currentData.splice(index, 1)[0];
                renderTable(currentData);
                
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                showToast(`${deletedItem.nama_matkul} telah dihapus`, 'success');
                
                deleteId = null;
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            let icon = 'ℹ';
            let iconClass = 'icon-info';
            let toastClass = 'toast-info';

            if (type === 'success') {
                icon = '✓';
                iconClass = 'icon-success';
                toastClass = 'toast-success';
            } else if (type === 'error') {
                icon = '✕';
                iconClass = 'icon-error';
                toastClass = 'toast-error';
            } else if (type === 'warning') {
                icon = '⚠';
                iconClass = 'icon-warning';
                toastClass = 'toast-warning';
            }

            const toastHTML = `
                <div id="${toastId}" class="toast ${toastClass}" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-circle ${iconClass}" style="flex-shrink: 0;">${icon}</div>
                        <div class="flex-grow-1 pt-2">
                            <div class="fw-semibold text-gray-900" style="font-size: 0.95rem;">${message}</div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', toastHTML);

            const toastElement = document.getElementById(toastId);
            setTimeout(() => {
                toastElement.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => toastElement.remove(), 300);
            }, 4000);
        }

        document.getElementById('matakuliahForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                kode_matkul: document.getElementById('kodeMatkul').value,
                nama_matkul: document.getElementById('namaMatkul').value,
                sks: parseInt(document.getElementById('sks').value)
            };

            if (editingId) {
                const index = currentData.findIndex(x => x.id === editingId);
                if (index > -1) {
                    currentData[index] = { ...currentData[index], ...formData };
                    showToast(`${formData.nama_matkul} telah diperbarui`, 'success');
                    editingId = null;
                }
            } else {
                const newId = Math.max(...currentData.map(x => x.id), 0) + 1;
                currentData.unshift({ id: newId, ...formData, created_at: new Date().toISOString(), updated_at: new Date().toISOString() });
                showToast(`${formData.nama_matkul} telah ditambahkan`, 'success');
            }

            renderTable(currentData);

            this.reset();
            bootstrap.Modal.getInstance(document.getElementById('matakuliahModal')).hide();
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteMatkul();
        });

        document.getElementById('matakuliahModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('matakuliahForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Mata Kuliah';
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.kode_matkul.toLowerCase().includes(query) ||
                item.nama_matkul.toLowerCase().includes(query)
            );
            currentData = filtered;
            renderTable(currentData);
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetchData();
        });
    </script>

    <style>
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(20px);
            }
        }
    </style>
@endpush

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
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari kelas..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Kelas</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Mata Kuliah</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Kapasitas</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Periode</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kelasTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data kelas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kelasModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="kelasForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Kelas</label>
                            <input type="text" class="form-control form-control-lg" id="namaKelas" placeholder="Contoh: Kelas A" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Mata Kuliah</label>
                            <select class="form-select form-select-lg" id="matkulId" required>
                                <option value="">Pilih Mata Kuliah</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Kapasitas</label>
                            <input type="number" class="form-control form-control-lg" id="kapasitas" min="1" max="100" placeholder="40" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Periode Semester</label>
                            <input type="text" class="form-control form-control-lg" id="periode" placeholder="Contoh: 2026/Ganjil" required>
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
                    <h5 class="modal-title fw-bold">Hapus Kelas</h5>
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
        let matkulList = [];

        const API_URL = '/api/v1/classes';
        const MATKUL_API = '/api/v1/courses';

        function renderTable(data) {
            const tbody = document.getElementById('kelasTableBody');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }

            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => `
                <tr>
                    <td><span class="fw-bold text-primary">${item.nama_kelas}</span></td>
                    <td><span class="fw-semibold">${item.mata_kuliah?.nama_matkul || 'N/A'}</span></td>
                    <td><span class="badge badge-light-primary">${item.kapasitas} Siswa</span></td>
                    <td><span class="text-gray-600">${item.periode_semester}</span></td>
                    <td>
                        <span class="badge badge-success">
                            ✓ Aktif
                        </span>
                    </td>
                    <td>
                        <div class="btn-actions">
                            <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editKelas(${item.id})" title="Edit">
                                ✎
                            </button>
                            <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.nama_kelas}')" title="Hapus">
                                ✕
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function populateMatkulSelect() {
            const matkulSelect = document.getElementById('matkulId');
            
            if (!matkulList || matkulList.length === 0) {
                matkulSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option><option value="" disabled>Tidak ada data</option>';
                return;
            }

            const matkulOptions = '<option value="">Pilih Mata Kuliah</option>' + 
                matkulList.map(m => `<option value="${m.id}">${m.nama_matkul}</option>`).join('');
            
            matkulSelect.innerHTML = matkulOptions;
        }

        function fetchMatkulData() {
            fetch(MATKUL_API, {
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
                    matkulList = Array.isArray(result.data) ? result.data : [result.data];
                    populateMatkulSelect();
                }
            })
            .catch(error => {
                console.error('Error fetching matkul:', error);
            });
        }

        function fetchData() {
            const tbody = document.getElementById('kelasTableBody');
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
                    showToast('Data kelas berhasil dimuat', 'success');
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

        function editKelas(id) {
            const item = allData.find(x => x.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Kelas';
            document.getElementById('namaKelas').value = item.nama_kelas;
            document.getElementById('matkulId').value = item.matkul_id;
            document.getElementById('kapasitas').value = item.kapasitas;
            document.getElementById('periode').value = item.periode_semester;
            document.getElementById('status').value = 'aktif';

            const modal = new bootstrap.Modal(document.getElementById('kelasModal'));
            modal.show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        function deleteKelas() {
            if (deleteId === null) return;

            const index = allData.findIndex(x => x.id === deleteId);
            if (index > -1) {
                const deletedItem = allData.splice(index, 1)[0];
                currentData = allData;
                renderTable(currentData);
                
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                showToast(`${deletedItem.nama_kelas} telah dihapus`, 'success');
                
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

        document.getElementById('kelasForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                nama_kelas: document.getElementById('namaKelas').value,
                matkul_id: parseInt(document.getElementById('matkulId').value),
                dosen_id: 0,
                kapasitas: parseInt(document.getElementById('kapasitas').value),
                periode_semester: document.getElementById('periode').value
            };

            if (editingId) {
                const index = allData.findIndex(x => x.id === editingId);
                if (index > -1) {
                    allData[index] = { ...allData[index], ...formData };
                    showToast(`${formData.nama_kelas} telah diperbarui`, 'success');
                    editingId = null;
                }
            } else {
                const newId = Math.max(...allData.map(x => x.id), 0) + 1;
                const selectedMatkul = matkulList.find(m => m.id === formData.matkul_id);
                allData.unshift({ 
                    id: newId, 
                    ...formData, 
                    mata_kuliah: selectedMatkul,
                    dosen: null,
                    materi: [],
                    detail_krs: [],
                    created_at: new Date().toISOString(), 
                    updated_at: new Date().toISOString() 
                });
                showToast(`${formData.nama_kelas} telah ditambahkan`, 'success');
            }

            currentData = allData;
            renderTable(currentData);

            this.reset();
            bootstrap.Modal.getInstance(document.getElementById('kelasModal')).hide();
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteKelas();
        });

        document.getElementById('kelasModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('kelasForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Kelas';
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.nama_kelas.toLowerCase().includes(query) ||
                item.mata_kuliah?.nama_matkul.toLowerCase().includes(query)
            );
            currentData = filtered;
            renderTable(currentData);
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetchMatkulData();
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
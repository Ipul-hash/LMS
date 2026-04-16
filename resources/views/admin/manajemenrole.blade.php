@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('page-title', 'Manajemen Role & Permission')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manajemen Role</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#roleModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Role
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari role..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Role</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Deskripsi</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Permission</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="roleTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data role</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="roleForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Role</label>
                            <input type="text" class="form-control form-control-lg" id="namaRole" placeholder="Contoh: Manager" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Deskripsi</label>
                            <textarea class="form-control form-control-lg" id="deskripsi" rows="2" placeholder="Deskripsi role..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Permission</label>
                            <div class="permission-list">
                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="create" id="perm-create">
                                    <label class="form-check-label" for="perm-create">
                                        <span class="fw-semibold">Create/Tambah</span>
                                        <small class="text-muted d-block">Membuat data baru</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="read" id="perm-read">
                                    <label class="form-check-label" for="perm-read">
                                        <span class="fw-semibold">Read/Lihat</span>
                                        <small class="text-muted d-block">Melihat data</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="update" id="perm-update">
                                    <label class="form-check-label" for="perm-update">
                                        <span class="fw-semibold">Update/Edit</span>
                                        <small class="text-muted d-block">Mengubah data</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="delete" id="perm-delete">
                                    <label class="form-check-label" for="perm-delete">
                                        <span class="fw-semibold">Delete/Hapus</span>
                                        <small class="text-muted d-block">Menghapus data</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="manage_user" id="perm-manage-user">
                                    <label class="form-check-label" for="perm-manage-user">
                                        <span class="fw-semibold">Kelola Pengguna</span>
                                        <small class="text-muted d-block">Mengelola pengguna sistem</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input permission-check" type="checkbox" value="manage_role" id="perm-manage-role">
                                    <label class="form-check-label" for="perm-manage-role">
                                        <span class="fw-semibold">Kelola Role</span>
                                        <small class="text-muted d-block">Mengelola role dan permission</small>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input permission-check" type="checkbox" value="reports" id="perm-reports">
                                    <label class="form-check-label" for="perm-reports">
                                        <span class="fw-semibold">Laporan</span>
                                        <small class="text-muted d-block">Mengakses laporan</small>
                                    </label>
                                </div>
                            </div>
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
                    <h5 class="modal-title fw-bold">Hapus Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-circle icon-warning" style="margin: 0 auto;">
                            ⚠
                        </div>
                    </div>
                    <p class="text-gray-700 text-center mb-0">
                        Apakah Anda yakin ingin menghapus role <strong id="deleteItemName"></strong>?
                    </p>
                    <p class="text-muted text-center fs-8 mt-2">Role yang sudah digunakan oleh pengguna tidak dapat dihapus</p>
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
            margin-right: 4px;
            display: inline-block;
            margin-bottom: 4px;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-info {
            background-color: #cce5ff;
            color: #004085;
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

        .toast-success {
            border-left: 4px solid #4caf50;
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

        .form-check {
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.125rem;
            margin-right: 0.5rem;
            border-radius: 3px;
        }

        .form-check-input:checked {
            background-color: #1976d2;
            border-color: #1976d2;
        }

        .form-check-label {
            margin-bottom: 0;
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

        .permission-list {
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .permission-list .form-check:last-child {
            margin-bottom: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let editingId = null;
        let deleteId = null;
        let currentData = [];
        let allData = [
            {
                id: 1,
                name: 'Admin',
                description: 'Admin sistem dengan akses penuh',
                permissions: ['create', 'read', 'update', 'delete', 'manage_user', 'manage_role', 'reports'],
                status: 'aktif'
            },
            {
                id: 2,
                name: 'Dosen',
                description: 'Dosen pengelola kelas dan materi',
                permissions: ['create', 'read', 'update', 'reports'],
                status: 'aktif'
            },
            {
                id: 3,
                name: 'Mahasiswa',
                description: 'Mahasiswa pengguna sistem pembelajaran',
                permissions: ['read'],
                status: 'aktif'
            },
            {
                id: 4,
                name: 'Moderator',
                description: 'Moderator forum dan diskusi',
                permissions: ['create', 'read', 'update', 'delete'],
                status: 'aktif'
            }
        ];

        function getPermissionLabels(permissions) {
            const labels = {
                'create': 'Tambah',
                'read': 'Lihat',
                'update': 'Edit',
                'delete': 'Hapus',
                'manage_user': 'Kelola Pengguna',
                'manage_role': 'Kelola Role',
                'reports': 'Laporan'
            };
            return permissions.map(p => labels[p] || p).join(', ');
        }

        function renderTable(data) {
            const tbody = document.getElementById('roleTableBody');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }

            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => `
                <tr>
                    <td><span class="fw-bold text-primary">${item.name}</span></td>
                    <td><span class="text-gray-600">${item.description}</span></td>
                    <td>
                        ${item.permissions.map(p => `<span class="badge badge-info">${{
                            'create': 'Tambah',
                            'read': 'Lihat',
                            'update': 'Edit',
                            'delete': 'Hapus',
                            'manage_user': 'Kelola User',
                            'manage_role': 'Kelola Role',
                            'reports': 'Laporan'
                        }[p]}</span>`).join('')}
                    </td>
                    <td>
                        <span class="badge ${item.status === 'aktif' ? 'badge-success' : 'badge-secondary'}">
                            ${item.status === 'aktif' ? '✓ Aktif' : '○ Nonaktif'}
                        </span>
                    </td>
                    <td>
                        <div class="btn-actions">
                            <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editRole(${item.id})" title="Edit">
                                ✎
                            </button>
                            <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.name}')" title="Hapus">
                                ✕
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function editRole(id) {
            const item = allData.find(x => x.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Role';
            document.getElementById('namaRole').value = item.name;
            document.getElementById('deskripsi').value = item.description;
            
            document.querySelectorAll('.permission-check').forEach(check => {
                check.checked = item.permissions.includes(check.value);
            });

            document.getElementById('status').value = item.status;

            const modal = new bootstrap.Modal(document.getElementById('roleModal'));
            modal.show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        function deleteRole() {
            if (deleteId === null) return;

            const index = allData.findIndex(x => x.id === deleteId);
            if (index > -1) {
                const deletedItem = allData.splice(index, 1)[0];
                currentData = allData;
                renderTable(currentData);
                
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                showToast(`${deletedItem.name} telah dihapus`, 'success');
                
                deleteId = null;
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            let icon = '✓';
            let toastClass = 'toast-success';

            const toastHTML = `
                <div id="${toastId}" class="toast ${toastClass}" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-circle" style="flex-shrink: 0; background-color: #e8f5e9; color: #4caf50; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">${icon}</div>
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

        document.getElementById('roleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const permissions = Array.from(document.querySelectorAll('.permission-check:checked')).map(check => check.value);

            const formData = {
                name: document.getElementById('namaRole').value,
                description: document.getElementById('deskripsi').value,
                permissions: permissions,
                status: document.getElementById('status').value
            };

            if (editingId) {
                const index = allData.findIndex(x => x.id === editingId);
                if (index > -1) {
                    allData[index] = { ...allData[index], ...formData };
                    showToast(`${formData.name} telah diperbarui`, 'success');
                    editingId = null;
                }
            } else {
                const newId = Math.max(...allData.map(x => x.id), 0) + 1;
                allData.unshift({ id: newId, ...formData });
                showToast(`${formData.name} telah ditambahkan`, 'success');
            }

            currentData = allData;
            renderTable(currentData);

            this.reset();
            bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteRole();
        });

        document.getElementById('roleModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('roleForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Role';
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.name.toLowerCase().includes(query) ||
                item.description.toLowerCase().includes(query)
            );
            currentData = filtered;
            renderTable(currentData);
        });

        document.addEventListener('DOMContentLoaded', function() {
            renderTable(allData);
            currentData = allData;
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

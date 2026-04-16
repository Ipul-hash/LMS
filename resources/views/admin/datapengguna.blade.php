@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('page-title', 'Data Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Data Pengguna</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#userModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Pengguna
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari pengguna..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Lengkap</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">NIM/NIP</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Email</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Role</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="userForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="nama" placeholder="Toni Hermawan" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">NIM/NIP</label>
                            <input type="text" class="form-control form-control-lg" id="nimNip" placeholder="210203001" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="toni@kampus.ac.id" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="••••••••" required>
                            <small class="text-muted" id="passwordHint" style="display: none;">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Role</label>
                            <select class="form-select form-select-lg" id="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
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
                    <h5 class="modal-title fw-bold">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-circle icon-warning" style="margin: 0 auto;">⚠</div>
                    </div>
                    <p class="text-gray-700 text-center mb-0">
                        Apakah Anda yakin ingin menghapus pengguna <strong id="deleteItemName"></strong>?
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
        .table tbody tr { transition: background-color 0.2s ease; border-bottom: 1px solid #f0f0f0; }
        .table tbody tr:hover { background-color: #f9f9f9; }
        .table thead { background-color: #f8f9fa; }
        .bg-light-gray { background-color: #f8f9fa !important; }
        .badge { font-size: 0.75rem; padding: 0.4rem 0.8rem; font-weight: 600; border-radius: 4px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-secondary { background-color: #e7e7e7; color: #666; }
        .badge-primary { background-color: #cfe2ff; color: #084298; }
        .btn-actions { display: flex; gap: 6px; }
        .btn-icon-sm { width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; border: none; cursor: pointer; font-size: 16px; transition: all 0.2s ease; }
        .btn-icon-edit { background-color: #e3f2fd; color: #1976d2; }
        .btn-icon-edit:hover { background-color: #1976d2; color: white; }
        .btn-icon-delete { background-color: #ffebee; color: #d32f2f; }
        .btn-icon-delete:hover { background-color: #d32f2f; color: white; }
        .toast { background-color: white; border-radius: 6px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12); border: none; min-width: 340px; animation: slideIn 0.3s ease; }
        .toast-success { border-left: 4px solid #4caf50; }
        .icon-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .icon-warning { background-color: #fff3e0; color: #ff9800; }
        .modal-content { border: none; border-radius: 8px; box-shadow: 0 5px 30px rgba(0, 0, 0, 0.12); }
        .form-control-lg, .form-select-lg { border-radius: 4px; border: 1px solid #e0e0e0; padding: 0.65rem 1rem; font-size: 0.95rem; }
        .form-control-lg:focus, .form-select-lg:focus { border-color: #1976d2; box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1); }
        .form-label { color: #333; }
        .btn-primary { background-color: #1976d2; border-color: #1976d2; }
        .btn-primary:hover { background-color: #1565c0; border-color: #1565c0; }
        .btn-danger { background-color: #d32f2f; border-color: #d32f2f; }
        .btn-danger:hover { background-color: #c62828; border-color: #c62828; }
        .btn-light { background-color: #f5f5f5; border-color: #e0e0e0; color: #333; }
        .btn-light:hover { background-color: #eeeeee; }
        .text-muted { color: #999 !important; }
        .table td { padding: 12px 16px; vertical-align: middle; }
        .table th { padding: 12px 16px; font-weight: 700; }
        .text-gray-700 { color: #555; }
        .fs-8 { font-size: 0.75rem !important; }
        .text-primary { color: #1976d2 !important; }
        .text-gray-600 { color: #666 !important; }
        .text-gray-900 { color: #333 !important; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(20px); } }
    </style>
@endpush

@push('scripts')
    <script>
        let editingId = null, deleteId = null, currentData = [], allData = [
            { id: 1, name: 'Admin User', nim_nip: 'ADM001', email: 'admin@kampus.ac.id', role: 'admin', status: 'aktif' },
            { id: 2, name: 'Dr. Santoso, M.Kom', nim_nip: 'NIP1001', email: 'santoso@kampus.ac.id', role: 'dosen', status: 'aktif' },
            { id: 3, name: 'Ir. Rina, M.T', nim_nip: 'NIP1002', email: 'rina@kampus.ac.id', role: 'dosen', status: 'aktif' },
            { id: 4, name: 'Toni Hermawan', nim_nip: '210203001', email: 'toni@kampus.ac.id', role: 'mahasiswa', status: 'aktif' },
            { id: 5, name: 'Siti Nurhaliza', nim_nip: '210203002', email: 'siti@kampus.ac.id', role: 'mahasiswa', status: 'nonaktif' }
        ];

        function getRoleBadge(role) {
            const roles = { 'admin': { color: 'primary', text: 'Admin' }, 'dosen': { color: 'warning', text: 'Dosen' }, 'mahasiswa': { color: 'secondary', text: 'Mahasiswa' } };
            return roles[role] || { color: 'secondary', text: role };
        }

        function renderTable(data) {
            const tbody = document.getElementById('userTableBody');
            const emptyState = document.getElementById('emptyState');
            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }
            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => {
                const roleBadge = getRoleBadge(item.role);
                return `<tr>
                    <td><span class="fw-bold text-primary">${item.name}</span></td>
                    <td><span class="text-gray-600">${item.nim_nip}</span></td>
                    <td><span class="text-gray-600">${item.email}</span></td>
                    <td><span class="badge badge-${roleBadge.color}">${roleBadge.text}</span></td>
                    <td><span class="badge ${item.status === 'aktif' ? 'badge-success' : 'badge-secondary'}">${item.status === 'aktif' ? '✓ Aktif' : '○ Nonaktif'}</span></td>
                    <td><div class="btn-actions"><button type="button" class="btn-icon-sm btn-icon-edit" onclick="editUser(${item.id})" title="Edit">✎</button><button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.name}')" title="Hapus">✕</button></div></td>
                </tr>`;
            }).join('');
        }

        function editUser(id) {
            const item = allData.find(x => x.id === id);
            if (!item) return;
            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Pengguna';
            document.getElementById('nama').value = item.name;
            document.getElementById('nimNip').value = item.nim_nip;
            document.getElementById('email').value = item.email;
            document.getElementById('password').value = '';
            document.getElementById('passwordHint').style.display = 'block';
            document.getElementById('password').removeAttribute('required');
            document.getElementById('role').value = item.role;
            document.getElementById('status').value = item.status;
            new bootstrap.Modal(document.getElementById('userModal')).show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
        }

        function deleteUser() {
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
            let icon = '✓', toastClass = 'toast-success';
            const toastHTML = `
                <div id="${toastId}" class="toast ${toastClass}" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-circle" style="flex-shrink: 0; background-color: #e8f5e9; color: #4caf50;">${icon}</div>
                        <div class="flex-grow-1 pt-2"><div class="fw-semibold text-gray-900" style="font-size: 0.95rem;">${message}</div></div>
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

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = {
                name: document.getElementById('nama').value,
                nim_nip: document.getElementById('nimNip').value,
                email: document.getElementById('email').value,
                role: document.getElementById('role').value,
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
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
            if (window.updateSidebarFromRole) {
                window.updateSidebarFromRole(formData.role);
            }
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', deleteUser);
        document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.name.toLowerCase().includes(query) ||
                item.email.toLowerCase().includes(query) ||
                item.nim_nip.toLowerCase().includes(query)
            );
            currentData = filtered;
            renderTable(currentData);
        });

        document.addEventListener('DOMContentLoaded', function() {
            renderTable(allData);
            currentData = allData;
        });
    </script>
@endpush
@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('page-title', 'Data Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Data Pengguna</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#userModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Pengguna
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari pengguna..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Lengkap</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">NIM/NIP</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Email</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Role</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="userForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="nama" placeholder="Toni Hermawan" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">NIM/NIP</label>
                            <input type="text" class="form-control form-control-lg" id="nimNip" placeholder="210203001" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="toni@kampus.ac.id" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="••••••••" id="editMode" ? '' : 'required'>
                            <small class="text-muted" id="passwordHint" style="display: none;">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Role</label>
                            <select class="form-select form-select-lg" id="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
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
                    <h5 class="modal-title fw-bold">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-circle icon-warning" style="margin: 0 auto;">
                            ⚠
                        </div>
                    </div>
                    <p class="text-gray-700 text-center mb-0">
                        Apakah Anda yakin ingin menghapus pengguna <strong id="deleteItemName"></strong>?
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

        .badge-primary {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #664d03;
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
        let allData = [
            {
                id: 1,
                name: 'Admin User',
                nim_nip: 'ADM001',
                email: 'admin@kampus.ac.id',
                role: 'admin',
                status: 'aktif'
            },
            {
                id: 2,
                name: 'Dr. Santoso, M.Kom',
                nim_nip: 'NIP1001',
                email: 'santoso@kampus.ac.id',
                role: 'dosen',
                status: 'aktif'
            },
            {
                id: 3,
                name: 'Ir. Rina, M.T',
                nim_nip: 'NIP1002',
                email: 'rina@kampus.ac.id',
                role: 'dosen',
                status: 'aktif'
            },
            {
                id: 4,
                name: 'Toni Hermawan',
                nim_nip: '210203001',
                email: 'toni@kampus.ac.id',
                role: 'mahasiswa',
                status: 'aktif'
            },
            {
                id: 5,
                name: 'Siti Nurhaliza',
                nim_nip: '210203002',
                email: 'siti@kampus.ac.id',
                role: 'mahasiswa',
                status: 'nonaktif'
            }
        ];

        function getRoleBadge(role) {
            const roles = {
                'admin': { color: 'primary', text: 'Admin' },
                'dosen': { color: 'warning', text: 'Dosen' },
                'mahasiswa': { color: 'secondary', text: 'Mahasiswa' }
            };
            return roles[role] || { color: 'secondary', text: role };
        }

        function renderTable(data) {
            const tbody = document.getElementById('userTableBody');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }

            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => {
                const roleBadge = getRoleBadge(item.role);
                return `
                    <tr>
                        <td><span class="fw-bold text-primary">${item.name}</span></td>
                        <td><span class="text-gray-600">${item.nim_nip}</span></td>
                        <td><span class="text-gray-600">${item.email}</span></td>
                        <td><span class="badge badge-${roleBadge.color}">${roleBadge.text}</span></td>
                        <td>
                            <span class="badge ${item.status === 'aktif' ? 'badge-success' : 'badge-secondary'}">
                                ${item.status === 'aktif' ? '✓ Aktif' : '○ Nonaktif'}
                            </span>
                        </td>
                        <td>
                            <div class="btn-actions">
                                <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editUser(${item.id})" title="Edit">
                                    ✎
                                </button>
                                <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.name}')" title="Hapus">
                                    ✕
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function editUser(id) {
            const item = allData.find(x => x.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Pengguna';
            document.getElementById('nama').value = item.name;
            document.getElementById('nimNip').value = item.nim_nip;
            document.getElementById('email').value = item.email;
            document.getElementById('password').value = '';
            document.getElementById('passwordHint').style.display = 'block';
            document.getElementById('password').removeAttribute('required');
            document.getElementById('role').value = item.role;
            document.getElementById('status').value = item.status;

            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        function deleteUser() {
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

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('nama').value,
                nim_nip: document.getElementById('nimNip').value,
                email: document.getElementById('email').value,
                role: document.getElementById('role').value,
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
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteUser();
        });

        document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.name.toLowerCase().includes(query) ||
                item.email.toLowerCase().includes(query) ||
                item.nim_nip.toLowerCase().includes(query)
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

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#userModal">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="white" />
                <rect x="10.8891" y="5.25879" width="2.15616" height="12" fill="white" />
                <path d="M5.4044 9.75879H19.2257C20.1957 9.75879 21.1957 10.4798 21.1957 11.4798V21.4798C21.1957 22.4798 20.1957 23.1799 19.2257 23.1799H5.4044C4.4344 23.1799 3.4344 22.4798 3.4344 21.4798V11.4798C3.4344 10.4798 4.4344 9.75879 5.4044 9.75879Z" fill="white" />
            </svg>
        </span>
        Tambah Pengguna
    </button>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header py-4 d-flex align-items-center border-0">
                    <input type="text" class="form-control form-control-solid" placeholder="Cari pengguna..." id="searchInput" style="max-width: 250px;">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                            <thead class="bg-light-gray">
                                <tr>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Nama Lengkap</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">NIM/NIP</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Email</th>
                                    <th class="text-muted fw-bold fs-7 text-uppercase">Role</th>
                                    <th style="width: 100px;" class="text-muted fw-bold fs-7 text-uppercase">Status</th>
                                    <th style="width: 80px;" class="text-muted fw-bold fs-7 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="fs-6">
                            </tbody>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-8 d-none">
                        <div class="mb-2 text-muted fs-6">Tidak ada data pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="userForm">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="nama" placeholder="Toni Hermawan" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">NIM/NIP</label>
                            <input type="text" class="form-control form-control-lg" id="nimNip" placeholder="210203001" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="toni@kampus.ac.id" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="••••••••" id="editMode" ? '' : 'required'>
                            <small class="text-muted" id="passwordHint" style="display: none;">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Role</label>
                            <select class="form-select form-select-lg" id="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
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
                    <h5 class="modal-title fw-bold">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-circle icon-warning" style="margin: 0 auto;">
                            ⚠
                        </div>
                    </div>
                    <p class="text-gray-700 text-center mb-0">
                        Apakah Anda yakin ingin menghapus pengguna <strong id="deleteItemName"></strong>?
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

        .badge-primary {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #664d03;
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
        let allData = [
            {
                id: 1,
                name: 'Admin User',
                nim_nip: 'ADM001',
                email: 'admin@kampus.ac.id',
                role: 'admin',
                status: 'aktif'
            },
            {
                id: 2,
                name: 'Dr. Santoso, M.Kom',
                nim_nip: 'NIP1001',
                email: 'santoso@kampus.ac.id',
                role: 'dosen',
                status: 'aktif'
            },
            {
                id: 3,
                name: 'Ir. Rina, M.T',
                nim_nip: 'NIP1002',
                email: 'rina@kampus.ac.id',
                role: 'dosen',
                status: 'aktif'
            },
            {
                id: 4,
                name: 'Toni Hermawan',
                nim_nip: '210203001',
                email: 'toni@kampus.ac.id',
                role: 'mahasiswa',
                status: 'aktif'
            },
            {
                id: 5,
                name: 'Siti Nurhaliza',
                nim_nip: '210203002',
                email: 'siti@kampus.ac.id',
                role: 'mahasiswa',
                status: 'nonaktif'
            }
        ];

        function getRoleBadge(role) {
            const roles = {
                'admin': { color: 'primary', text: 'Admin' },
                'dosen': { color: 'warning', text: 'Dosen' },
                'mahasiswa': { color: 'secondary', text: 'Mahasiswa' }
            };
            return roles[role] || { color: 'secondary', text: role };
        }

        function renderTable(data) {
            const tbody = document.getElementById('userTableBody');
            const emptyState = document.getElementById('emptyState');

            if (data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }

            emptyState.classList.add('d-none');
            tbody.innerHTML = data.map((item) => {
                const roleBadge = getRoleBadge(item.role);
                return `
                    <tr>
                        <td><span class="fw-bold text-primary">${item.name}</span></td>
                        <td><span class="text-gray-600">${item.nim_nip}</span></td>
                        <td><span class="text-gray-600">${item.email}</span></td>
                        <td><span class="badge badge-${roleBadge.color}">${roleBadge.text}</span></td>
                        <td>
                            <span class="badge ${item.status === 'aktif' ? 'badge-success' : 'badge-secondary'}">
                                ${item.status === 'aktif' ? '✓ Aktif' : '○ Nonaktif'}
                            </span>
                        </td>
                        <td>
                            <div class="btn-actions">
                                <button type="button" class="btn-icon-sm btn-icon-edit" onclick="editUser(${item.id})" title="Edit">
                                    ✎
                                </button>
                                <button type="button" class="btn-icon-sm btn-icon-delete" onclick="showDeleteConfirm(${item.id}, '${item.name}')" title="Hapus">
                                    ✕
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function editUser(id) {
            const item = allData.find(x => x.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Pengguna';
            document.getElementById('nama').value = item.name;
            document.getElementById('nimNip').value = item.nim_nip;
            document.getElementById('email').value = item.email;
            document.getElementById('password').value = '';
            document.getElementById('passwordHint').style.display = 'block';
            document.getElementById('password').removeAttribute('required');
            document.getElementById('role').value = item.role;
            document.getElementById('status').value = item.status;

            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        function showDeleteConfirm(id, name) {
            deleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }

        function deleteUser() {
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

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('nama').value,
                nim_nip: document.getElementById('nimNip').value,
                email: document.getElementById('email').value,
                role: document.getElementById('role').value,
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
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteUser();
        });

        document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
            document.getElementById('passwordHint').style.display = 'none';
            document.getElementById('password').setAttribute('required', '');
            editingId = null;
        });

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = allData.filter(item =>
                item.name.toLowerCase().includes(query) ||
                item.email.toLowerCase().includes(query) ||
                item.nim_nip.toLowerCase().includes(query)
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

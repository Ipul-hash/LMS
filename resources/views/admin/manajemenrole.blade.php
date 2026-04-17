@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('page-title', 'Manajemen Role & Permission')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Master Data</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manajemen Role</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary"
        data-bs-toggle="modal" data-bs-target="#roleModal">
        <i class="ki-outline ki-plus-square fs-3 me-1"></i>
        Tambah Role
    </button>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
            <i class="ki-outline ki-check-circle fs-4 me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
            <i class="ki-outline ki-cross-circle fs-4 me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-flush">

                <div class="card-header py-4 border-0">
                    <form method="GET" action="{{ route('manajemenRole') }}" class="d-flex gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-solid w-250px"
                            placeholder="Cari nama role...">
                        <button type="submit" class="btn btn-light-primary">Filter</button>
                        @if (request('search'))
                            <a href="{{ route('manajemenRole') }}" class="btn btn-light">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="min-w-150px">Nama Role</th>
                                    <th class="min-w-80px text-center">Pengguna</th>
                                    <th class="min-w-300px">Permission</th>
                                    <th class="min-w-80px text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>
                                            <span class="text-gray-900 fw-bold fs-6">{{ ucfirst($role->name) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light-primary fw-semibold">
                                                {{ $role->users_count }} user
                                            </span>
                                        </td>
                                        <td>
                                            @forelse ($role->permissions as $permission)
                                                <span class="badge badge-light-secondary fw-semibold me-1 mb-1">
                                                    {{ $permission->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted fs-7">Belum ada permission</span>
                                            @endforelse
                                        </td>
                                        <td class="text-end">
                                            @if ($role->name !== 'admin')
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-light-primary me-1 edit-role-btn"
                                                    data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}"
                                                    data-permissions="{{ $role->permissions->pluck('name')->implode(',') }}"
                                                    title="Edit">
                                                    <i class="ki-outline ki-pencil fs-4"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-light-danger delete-role-btn"
                                                    data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}"
                                                    data-users="{{ $role->users_count }}"
                                                    data-url="{{ route('manajemenRole.destroy', $role) }}"
                                                    title="Hapus">
                                                    <i class="ki-outline ki-trash fs-4"></i>
                                                </button>
                                            @else
                                                <span class="text-muted fs-7">Terlindungi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10">
                                            <i class="ki-outline ki-shield-cross fs-2x text-muted d-block mb-3"></i>
                                            <span class="text-muted fs-6">Belum ada data role</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($roles->hasPages())
                        <div class="d-flex justify-content-between align-items-center pt-4">
                            <span class="text-muted fs-7">
                                Menampilkan {{ $roles->firstItem() }}–{{ $roles->lastItem() }}
                                dari {{ $roles->total() }} role
                            </span>
                            {{ $roles->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Tambah / Edit --}}
    <div class="modal fade" id="roleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="roleForm" novalidate>
                    @csrf
                    <input type="hidden" id="roleId">
                    <input type="hidden" id="formMethod" value="POST">

                    <div class="modal-body">

                        <div id="formErrorAlert" class="alert alert-danger d-none mb-4">
                            <ul id="formErrorList" class="mb-0 ps-3"></ul>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold required">Nama Role</label>
                            <input type="text" class="form-control form-control-solid"
                                id="inputName" placeholder="Contoh: dosen, mahasiswa, kaprodi">
                            <div class="text-muted fs-7 mt-1">Nama role akan otomatis diubah ke huruf kecil.</div>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold">Permission</label>
                            <div class="text-muted fs-7 mb-3">
                                Centang permission yang ingin diberikan ke role ini.
                            </div>
                            <div class="row g-3">
                                @forelse ($permissions as $permission)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check form-check-custom form-check-solid border rounded p-3">
                                            <input class="form-check-input perm-check"
                                                type="checkbox"
                                                value="{{ $permission->name }}"
                                                id="perm-{{ $loop->index }}">
                                            <label class="form-check-label ms-2 fs-7 fw-semibold"
                                                for="perm-{{ $loop->index }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <span class="text-muted fs-7">
                                            Belum ada permission terdaftar di sistem.
                                        </span>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Hapus Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
                    <i class="ki-outline ki-trash fs-3x text-danger mb-4 d-block"></i>
                    <p class="text-gray-700 fs-5 mb-1">
                        Hapus role <strong id="deleteRoleName"></strong>?
                    </p>
                    <p class="text-muted fs-7" id="deleteWarning"></p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <span class="indicator-label">Hapus</span>
                        <span class="indicator-progress d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

@endsection

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let deleteUrl = null;

    // ─── Edit Button ──────────────────────────────────────────────────────────────
    document.querySelectorAll('.edit-role-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id          = this.dataset.id;
            const name        = this.dataset.name;
            const permissions = this.dataset.permissions
                ? this.dataset.permissions.split(',').map(p => p.trim()).filter(Boolean)
                : [];

            document.getElementById('modalTitle').textContent = 'Edit Role';
            document.getElementById('roleId').value           = id;
            document.getElementById('formMethod').value       = 'PUT';
            document.getElementById('inputName').value        = name;

            document.querySelectorAll('.perm-check').forEach(cb => {
                cb.checked = permissions.includes(cb.value);
            });

            clearFormErrors();
            new bootstrap.Modal(document.getElementById('roleModal')).show();
        });
    });

    // ─── Delete Button ────────────────────────────────────────────────────────────
    document.querySelectorAll('.delete-role-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const name      = this.dataset.name;
            const userCount = parseInt(this.dataset.users);

            deleteUrl = this.dataset.url;

            document.getElementById('deleteRoleName').textContent = ucfirst(name);
            document.getElementById('deleteWarning').textContent  = userCount > 0
                ? `Role ini digunakan oleh ${userCount} pengguna dan tidak dapat dihapus.`
                : 'Tindakan ini tidak dapat dibatalkan.';

            document.getElementById('confirmDeleteBtn').disabled = userCount > 0;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    // ─── Form Submit ──────────────────────────────────────────────────────────────
    document.getElementById('roleForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearFormErrors();

        const id     = document.getElementById('roleId').value;
        const method = document.getElementById('formMethod').value;
        const url    = id
            ? `{{ url('/master/role') }}/${id}`
            : '{{ route('manajemenRole.store') }}';

        const permissions = [...document.querySelectorAll('.perm-check:checked')]
            .map(cb => cb.value);

        const payload = {
            name:        document.getElementById('inputName').value.trim(),
            permissions: permissions,
        };

        setSubmitLoading(true);

        fetch(url, {
            method:  method,
            headers: {
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        })
        .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
        .then(({ ok, status, data }) => {
            if (ok) {
                bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 800);
            } else if (status === 422 && data.errors) {
                showFormErrors(data.errors);
            } else {
                showToast(data.message ?? 'Terjadi kesalahan.', 'error');
            }
        })
        .catch(() => showToast('Gagal terhubung ke server.', 'error'))
        .finally(() => setSubmitLoading(false));
    });

    // ─── Confirm Delete ───────────────────────────────────────────────────────────
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteUrl) return;

        setDeleteLoading(true);

        fetch(deleteUrl, {
            method:  'DELETE',
            headers: {
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (ok) {
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 800);
            } else {
                showToast(data.message ?? 'Gagal menghapus role.', 'error');
            }
        })
        .catch(() => showToast('Gagal terhubung ke server.', 'error'))
        .finally(() => setDeleteLoading(false));
    });

    // ─── Reset Modal on Close ─────────────────────────────────────────────────────
    document.getElementById('roleModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('roleForm').reset();
        document.getElementById('roleId').value       = '';
        document.getElementById('formMethod').value   = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Role';
        document.querySelectorAll('.perm-check').forEach(cb => { cb.checked = false; });
        clearFormErrors();
    });

    // ─── Helpers ──────────────────────────────────────────────────────────────────
    function showFormErrors(errors) {
        const alert = document.getElementById('formErrorAlert');
        const list  = document.getElementById('formErrorList');

        list.innerHTML = Object.values(errors).flat()
            .map(m => `<li>${m}</li>`).join('');
        alert.classList.remove('d-none');

        if (errors.name) {
            document.getElementById('inputName').classList.add('is-invalid');
            document.getElementById('nameError').textContent = errors.name[0];
        }
    }

    function clearFormErrors() {
        document.getElementById('formErrorAlert').classList.add('d-none');
        document.getElementById('formErrorList').innerHTML = '';
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('nameError').textContent = '';
    }

    function setSubmitLoading(on) {
        const btn = document.getElementById('submitBtn');
        btn.querySelector('.indicator-label').classList.toggle('d-none', on);
        btn.querySelector('.indicator-progress').classList.toggle('d-none', !on);
        btn.disabled = on;
    }

    function setDeleteLoading(on) {
        const btn = document.getElementById('confirmDeleteBtn');
        btn.querySelector('.indicator-label').classList.toggle('d-none', on);
        btn.querySelector('.indicator-progress').classList.toggle('d-none', !on);
        btn.disabled = on;
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const id    = 'toast-' + Date.now();
        const color = type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary';
        const icon  = type === 'success' ? 'ki-check-circle'
                    : type === 'error'   ? 'ki-cross-circle'
                    : 'ki-information-5';

        container.insertAdjacentHTML('beforeend', `
            <div id="${id}" class="toast show align-items-center text-bg-${color} border-0 mb-2" role="alert">
                <div class="d-flex align-items-center gap-3 p-3">
                    <i class="ki-outline ${icon} fs-2 text-white"></i>
                    <div class="me-auto fw-semibold fs-6">${message}</div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);

        setTimeout(() => document.getElementById(id)?.remove(), 4500);
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>
@endpush

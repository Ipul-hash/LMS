@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('page-title', 'Data Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Master Data</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Data Pengguna</li>
@endsection

@section('toolbar-actions')
    <button type="button" class="btn btn-sm fw-bold btn-primary"
        data-bs-toggle="modal" data-bs-target="#userModal">
        <i class="ki-outline ki-plus-square fs-3 me-1"></i>
        Tambah Pengguna
    </button>
@endsection

@section('content')

    {{-- Flash Messages --}}
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

                <div class="card-header py-4 gap-3 border-0 flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <form method="GET" action="{{ route('dataPengguna') }}" class="d-flex gap-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-solid w-250px"
                                placeholder="Cari nama, NIM/NIP, email...">

                            <select name="role" class="form-select form-select-solid w-150px">
                                <option value="">Semua Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="status" class="form-select form-select-solid w-150px">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>

                            <button type="submit" class="btn btn-light-primary">Filter</button>
                            @if (request()->hasAny(['search', 'role', 'status']))
                                <a href="{{ route('dataPengguna') }}" class="btn btn-light">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="min-w-180px">Nama Lengkap</th>
                                    <th class="min-w-120px">NIM / NIP</th>
                                    <th class="min-w-200px">Email</th>
                                    <th class="min-w-100px">Role</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="symbol symbol-35px">
                                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 fw-bold fs-6">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-semibold">{{ $user->nim_nip }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-semibold">{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            @php $roleName = $user->roles->first()?->name ?? null @endphp
                                            @if ($roleName === 'admin')
                                                <span class="badge badge-light-primary fw-semibold">Admin</span>
                                            @elseif ($roleName === 'dosen')
                                                <span class="badge badge-light-warning fw-semibold">Dosen</span>
                                            @elseif ($roleName === 'mahasiswa')
                                                <span class="badge badge-light-info fw-semibold">Mahasiswa</span>
                                            @elseif ($roleName)
                                                <span class="badge badge-light-secondary fw-semibold">{{ ucfirst($roleName) }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm px-3 py-1 fw-semibold toggle-status-btn
                                                    {{ $user->is_active ? 'btn-light-success' : 'btn-light-danger' }}"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-active="{{ $user->is_active ? '1' : '0' }}"
                                                data-url="{{ route('dataPengguna.toggleStatus', $user) }}"
                                                {{ $user->id === auth()->id() ? 'disabled title=Tidak dapat mengubah status akun sendiri' : '' }}>
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-light-primary me-1 edit-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-nim="{{ $user->nim_nip }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->roles->first()?->name }}"
                                                data-active="{{ $user->is_active ? '1' : '0' }}"
                                                title="Edit">
                                                <i class="ki-outline ki-pencil fs-4"></i>
                                            </button>
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-light-danger delete-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-url="{{ route('dataPengguna.destroy', $user) }}"
                                                {{ $user->id === auth()->id() ? 'disabled title=Tidak dapat menghapus akun sendiri' : '' }}
                                                title="Hapus">
                                                <i class="ki-outline ki-trash fs-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <i class="ki-outline ki-people fs-2x text-muted d-block mb-3"></i>
                                            <span class="text-muted fs-6">Belum ada data pengguna</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($users->hasPages())
                        <div class="d-flex justify-content-between align-items-center pt-4">
                            <span class="text-muted fs-7">
                                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                                dari {{ $users->total() }} pengguna
                            </span>
                            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Tambah / Edit --}}
    <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="userForm" novalidate>
                    @csrf
                    <input type="hidden" id="userId">
                    <input type="hidden" id="formMethod" value="POST">

                    <div class="modal-body">

                        <div id="formErrorAlert" class="alert alert-danger d-none mb-4">
                            <ul id="formErrorList" class="mb-0 ps-3"></ul>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold required">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-solid"
                                id="inputName" name="name" placeholder="Contoh: Toni Hermawan">
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold required">NIM / NIP</label>
                            <input type="text" class="form-control form-control-solid"
                                id="inputNimNip" name="nim_nip" placeholder="210203001">
                            <div class="invalid-feedback" id="nimNipError"></div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold required">Email</label>
                            <input type="email" class="form-control form-control-solid"
                                id="inputEmail" name="email" placeholder="toni@kampus.ac.id">
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold" id="passwordLabel">
                                Password <span class="text-danger" id="passwordRequired">*</span>
                            </label>
                            <input type="password" class="form-control form-control-solid"
                                id="inputPassword" name="password" placeholder="Min. 8 karakter">
                            <div class="text-muted fs-7 mt-1 d-none" id="passwordHint">
                                Kosongkan jika tidak ingin mengubah password
                            </div>
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold" id="passwordConfirmLabel">
                                Konfirmasi Password <span class="text-danger" id="passwordConfirmRequired">*</span>
                            </label>
                            <input type="password" class="form-control form-control-solid"
                                id="inputPasswordConfirm" name="password_confirmation" placeholder="Ulangi password">
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold required">Role</label>
                            <select class="form-select form-select-solid" id="inputRole" name="role">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="roleError"></div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold required">Status</label>
                            <select class="form-select form-select-solid" id="inputStatus" name="is_active">
                                <option value="">Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            <div class="invalid-feedback" id="isActiveError"></div>
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
                    <h5 class="modal-title fw-bold">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-6">
                    <i class="ki-outline ki-trash fs-3x text-danger mb-4 d-block"></i>
                    <p class="text-gray-700 fs-5 mb-1">
                        Hapus pengguna <strong id="deleteUserName"></strong>?
                    </p>
                    <p class="text-muted fs-7">Tindakan ini tidak dapat dibatalkan.</p>
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

    let deleteUrl  = null;
    let isEditMode = false;

    // ─── Edit Button ─────────────────────────────────────────────────────────────
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            isEditMode = true;

            const id     = this.dataset.id;
            const name   = this.dataset.name;
            const nim    = this.dataset.nim;
            const email  = this.dataset.email;
            const role   = this.dataset.role;
            const active = this.dataset.active;

            document.getElementById('modalTitle').textContent    = 'Edit Pengguna';
            document.getElementById('userId').value              = id;
            document.getElementById('formMethod').value          = 'PUT';
            document.getElementById('inputName').value           = name;
            document.getElementById('inputNimNip').value         = nim;
            document.getElementById('inputEmail').value          = email;
            document.getElementById('inputRole').value           = role;
            document.getElementById('inputStatus').value         = active;
            document.getElementById('inputPassword').value       = '';
            document.getElementById('inputPasswordConfirm').value = '';

            document.getElementById('passwordHint').classList.remove('d-none');
            document.getElementById('passwordRequired').classList.add('d-none');
            document.getElementById('passwordConfirmRequired').classList.add('d-none');

            clearFormErrors();
            new bootstrap.Modal(document.getElementById('userModal')).show();
        });
    });

    // ─── Delete Button ────────────────────────────────────────────────────────────
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            deleteUrl = this.dataset.url;
            document.getElementById('deleteUserName').textContent = this.dataset.name;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    // ─── Toggle Status ────────────────────────────────────────────────────────────
    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const url    = this.dataset.url;
            const name   = this.dataset.name;
            const btnEl  = this;

            btnEl.disabled = true;

            fetch(url, {
                method:  'PATCH',
                headers: {
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const isActive = data.is_active;
                    btnEl.textContent   = isActive ? 'Aktif' : 'Nonaktif';
                    btnEl.dataset.active = isActive ? '1' : '0';
                    btnEl.className = btnEl.className
                        .replace(/btn-light-(success|danger)/, `btn-light-${isActive ? 'success' : 'danger'}`);
                    showToast(`Status ${name} diubah ke ${data.label}`, 'success');
                } else {
                    showToast(data.error ?? 'Gagal mengubah status.', 'error');
                }
            })
            .catch(() => showToast('Gagal terhubung ke server.', 'error'))
            .finally(() => { btnEl.disabled = false; });
        });
    });

    // ─── Form Submit ──────────────────────────────────────────────────────────────
    document.getElementById('userForm').addEventListener('submit', function (e) {
        e.preventDefault();

        clearFormErrors();

        const id     = document.getElementById('userId').value;
        const method = document.getElementById('formMethod').value;
        const url    = id
            ? `{{ url('/master/pengguna') }}/${id}`
            : '{{ route('dataPengguna.store') }}';

        const payload = {
            name:                  document.getElementById('inputName').value.trim(),
            nim_nip:               document.getElementById('inputNimNip').value.trim(),
            email:                 document.getElementById('inputEmail').value.trim(),
            role:                  document.getElementById('inputRole').value,
            is_active:             document.getElementById('inputStatus').value,
            password:              document.getElementById('inputPassword').value,
            password_confirmation: document.getElementById('inputPasswordConfirm').value,
        };

        // Remove password fields if edit mode & password is empty
        if (isEditMode && !payload.password) {
            delete payload.password;
            delete payload.password_confirmation;
        }

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
                bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
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
                showToast(data.message ?? 'Gagal menghapus pengguna.', 'error');
            }
        })
        .catch(() => showToast('Gagal terhubung ke server.', 'error'))
        .finally(() => setDeleteLoading(false));
    });

    // ─── Reset Modal on Close ─────────────────────────────────────────────────────
    document.getElementById('userModal').addEventListener('hidden.bs.modal', function () {
        isEditMode = false;
        document.getElementById('userForm').reset();
        document.getElementById('userId').value       = '';
        document.getElementById('formMethod').value   = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
        document.getElementById('passwordHint').classList.add('d-none');
        document.getElementById('passwordRequired').classList.remove('d-none');
        document.getElementById('passwordConfirmRequired').classList.remove('d-none');
        clearFormErrors();
    });

    // ─── Helpers ──────────────────────────────────────────────────────────────────
    function showFormErrors(errors) {
        const alert = document.getElementById('formErrorAlert');
        const list  = document.getElementById('formErrorList');

        list.innerHTML = Object.values(errors).flat()
            .map(m => `<li>${m}</li>`).join('');
        alert.classList.remove('d-none');
        alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        const map = {
            name:      'inputName',
            nim_nip:   'inputNimNip',
            email:     'inputEmail',
            password:  'inputPassword',
            role:      'inputRole',
            is_active: 'inputStatus',
        };

        Object.entries(errors).forEach(([field, messages]) => {
            const inputId = map[field];
            if (!inputId) return;
            const input = document.getElementById(inputId);
            const errEl = document.getElementById(field.replace('_', '') + 'Error')
                       ?? document.getElementById(inputId + 'Error');
            if (input)  input.classList.add('is-invalid');
            if (errEl)  errEl.textContent = messages[0];
        });
    }

    function clearFormErrors() {
        document.getElementById('formErrorAlert').classList.add('d-none');
        document.getElementById('formErrorList').innerHTML = '';
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        ['nameError', 'nimNipError', 'emailError', 'passwordError',
         'roleError', 'isActiveError'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '';
        });
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
</script>
@endpush

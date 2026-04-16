@extends('layouts.app')

@section('title', 'Manajemen Sidebar')

@section('page-title', 'Manajemen Sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manajemen Sidebar</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atur Menu Sidebar Per Role</h3>
                    <p class="text-muted mt-2">Klik pada card role untuk mengatur menu sidebar yang akan ditampilkan</p>
                </div>
                <div class="card-body">
                    <div class="row" id="rolesContainer">
                        <!-- Role cards akan di-generate oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Sidebar Menu -->
<div class="modal fade" id="sidebarConfigModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRoleTitle">Konfigurasi Menu Sidebar - </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="menuAccordion">
                    <!-- Menu items akan di-generate oleh JavaScript -->
                </div>
                <div class="mt-4 p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Centang menu yang ingin ditampilkan untuk role ini
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveSidebarBtn">
                    <i class="fas fa-save"></i> Simpan Konfigurasi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .role-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e3e6f0;
        position: relative;
        overflow: hidden;
    }

    .role-card:hover {
        border-color: #007bff;
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.15);
        transform: translateY(-5px);
    }

    .role-card.active {
        border-color: #28a745;
        background-color: #f8fff9;
    }

    .role-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .role-badge.admin {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .role-badge.dosen {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .role-badge.mahasiswa {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .role-badge.moderator {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .role-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    .menu-item-checkbox {
        margin-bottom: 15px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 5px;
        transition: all 0.2s ease;
    }

    .menu-item-checkbox:hover {
        background: #e9ecef;
    }

    .menu-item-checkbox input[type="checkbox"] {
        cursor: pointer;
    }

    .menu-item-checkbox label {
        cursor: pointer;
        margin-bottom: 0;
        margin-left: 8px;
        font-weight: 500;
    }

    .menu-category {
        font-weight: 700;
        color: #007bff;
        margin-top: 15px;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .menu-category-first {
        margin-top: 0;
    }
</style>

<script>
    // Data hardcoded untuk roles dan menu items
    const rolesList = [
        {
            id: 1,
            name: 'Admin',
            description: 'Administrator sistem',
            icon: 'fas fa-crown',
            color: 'admin',
            permissions: ['create', 'read', 'update', 'delete', 'manage-user', 'manage-role', 'reports']
        },
        {
            id: 2,
            name: 'Dosen',
            description: 'Dosen pengelola kelas',
            icon: 'fas fa-chalkboard-user',
            color: 'dosen',
            permissions: ['create', 'read', 'update', 'reports']
        },
        {
            id: 3,
            name: 'Mahasiswa',
            description: 'Mahasiswa pengguna sistem',
            icon: 'fas fa-graduation-cap',
            color: 'mahasiswa',
            permissions: ['read']
        },
        {
            id: 4,
            name: 'Moderator',
            description: 'Moderator forum diskusi',
            icon: 'fas fa-comments',
            color: 'moderator',
            permissions: ['create', 'read', 'update', 'delete']
        }
    ];

    // Data menu items yang tersedia dalam sidebar
    const menuItems = [
        {
            category: 'Master Data',
            items: [
                { id: 'data-pengguna', name: 'Data Pengguna', icon: 'fas fa-users', requiredPermissions: ['manage-user'] },
                { id: 'data-matkul', name: 'Data Mata Kuliah', icon: 'fas fa-book', requiredPermissions: ['read'] },
                { id: 'manajemen-kelas', name: 'Manajemen Kelas', icon: 'fas fa-chalkboard', requiredPermissions: ['create', 'read'] },
                { id: 'manajemen-role', name: 'Manajemen Role', icon: 'fas fa-lock', requiredPermissions: ['manage-role'] }
            ]
        },
        {
            category: 'Pembelajaran',
            items: [
                { id: 'krs', name: 'KRS / Mata Kuliah Saya', icon: 'fas fa-receipt', requiredPermissions: ['read'] },
                { id: 'materi', name: 'Materi Pembelajaran', icon: 'fas fa-file-pdf', requiredPermissions: ['read'] },
                { id: 'nilai', name: 'Nilai', icon: 'fas fa-chart-bar', requiredPermissions: ['read'] }
            ]
        },
        {
            category: 'Laporan',
            items: [
                { id: 'laporan-akademik', name: 'Laporan Akademik', icon: 'fas fa-file-excel', requiredPermissions: ['reports'] },
                { id: 'laporan-kehadiran', name: 'Laporan Kehadiran', icon: 'fas fa-calendar-check', requiredPermissions: ['reports'] }
            ]
        },
        {
            category: 'Pengaturan',
            items: [
                { id: 'sidebar-management', name: 'Manajemen Sidebar', icon: 'fas fa-cog', requiredPermissions: ['manage-role'] },
                { id: 'profile', name: 'Profil Saya', icon: 'fas fa-user', requiredPermissions: ['read'] }
            ]
        }
    ];

    // Data untuk menyimpan konfigurasi sidebar per role (hardcoded)
    let sidebarConfigData = {
        1: ['data-pengguna', 'data-matkul', 'manajemen-kelas', 'manajemen-role', 'laporan-akademik', 'laporan-kehadiran', 'sidebar-management', 'profile'],
        2: ['data-matkul', 'manajemen-kelas', 'krs', 'materi', 'nilai', 'laporan-akademik', 'profile'],
        3: ['krs', 'materi', 'nilai', 'laporan-akademik', 'profile'],
        4: ['krs', 'materi', 'profile']
    };

    let currentEditingRoleId = null;

    // Initialize - render semua role cards
    function initializeRoles() {
        const container = document.getElementById('rolesContainer');
        container.innerHTML = '';

        rolesList.forEach(role => {
            const card = document.createElement('div');
            card.className = 'col-md-6 col-lg-3 mb-4';
            card.innerHTML = `
                <div class="card role-card" onclick="editRoleConfig(${role.id})" style="height: 100%;">
                    <div class="role-badge ${role.color}">${role.name}</div>
                    <div class="card-body text-center">
                        <i class="role-icon text-primary ${role.icon}"></i>
                        <h5 class="card-title mt-2">${role.name}</h5>
                        <p class="card-text text-muted small">${role.description}</p>
                        <div class="mt-3">
                            <span class="badge bg-light text-dark">${sidebarConfigData[role.id].length} menu aktif</span>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // Fungsi untuk membuka modal konfigurasi sidebar
    function editRoleConfig(roleId) {
        currentEditingRoleId = roleId;
        const role = rolesList.find(r => r.id === roleId);

        // Update modal title
        document.getElementById('modalRoleTitle').textContent = `Konfigurasi Menu Sidebar - ${role.name}`;

        // Generate menu items di accordion
        const accordion = document.getElementById('menuAccordion');
        accordion.innerHTML = '';

        menuItems.forEach((categoryItem, categoryIndex) => {
            let categoryHtml = `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading${categoryIndex}">
                        <button class="accordion-button ${categoryIndex === 0 ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse${categoryIndex}" aria-expanded="${categoryIndex === 0}">
                            <i class="fas fa-folder-open me-2"></i> ${categoryItem.category}
                        </button>
                    </h2>
                    <div id="collapse${categoryIndex}" class="accordion-collapse collapse ${categoryIndex === 0 ? 'show' : ''}" 
                         data-bs-parent="#menuAccordion">
                        <div class="accordion-body">
            `;

            categoryItem.items.forEach(menuItem => {
                const isChecked = sidebarConfigData[roleId].includes(menuItem.id);
                categoryHtml += `
                    <div class="menu-item-checkbox">
                        <div class="form-check">
                            <input class="form-check-input menu-checkbox" type="checkbox" id="menu_${menuItem.id}" 
                                   data-menu-id="${menuItem.id}" ${isChecked ? 'checked' : ''}>
                            <label class="form-check-label" for="menu_${menuItem.id}">
                                <i class="${menuItem.icon} me-2"></i>
                                <strong>${menuItem.name}</strong>
                            </label>
                        </div>
                        <small class="text-muted ms-4 d-block mt-1">
                            Diperlukan: <span class="badge bg-secondary">${menuItem.requiredPermissions.join(', ')}</span>
                        </small>
                    </div>
                `;
            });

            categoryHtml += `
                        </div>
                    </div>
                </div>
            `;

            accordion.innerHTML += categoryHtml;
        });

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('sidebarConfigModal'));
        modal.show();
    }

    // Fungsi untuk save konfigurasi sidebar
    document.getElementById('saveSidebarBtn').addEventListener('click', function() {
        const checkedItems = Array.from(document.querySelectorAll('.menu-checkbox:checked'))
            .map(checkbox => checkbox.getAttribute('data-menu-id'));

        // Update hardcoded data
        sidebarConfigData[currentEditingRoleId] = checkedItems;

        // Show success message
        showToast(`Konfigurasi sidebar untuk ${rolesList.find(r => r.id === currentEditingRoleId).name} berhasil diperbarui!`, 'success');

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('sidebarConfigModal')).hide();

        // Re-initialize untuk update count menu aktif
        initializeRoles();
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';

        const toastHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type === 'success' ? '✓ Berhasil' : type === 'error' ? '✗ Error' : 'Info'}!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        const container = document.createElement('div');
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        container.innerHTML = toastHtml;
        document.body.appendChild(container);

        setTimeout(() => {
            container.remove();
        }, 4000);
    }

    // Initialize ketika halaman loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeRoles();
    });
</script>
@endsection
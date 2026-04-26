<div id="kt_app_sidebar" class="app-sidebar flex-column"
    data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/media/logos/default.svg') }}"
                class="h-25px app-sidebar-logo-default" />
            <img src="{{ asset('assets/media/logos/default-small.svg') }}"
                class="h-20px app-sidebar-logo-minimize" />
        </a>

        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-double-left fs-2 rotate-180"></i>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_wrapper"
                class="app-sidebar-primary menu-column-fluid px-3 py-5"
                data-kt-scroll="true"
                data-kt-scroll-activate="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu_wrapper"
                data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">

                <div id="kt_app_sidebar_menu"
                    class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                    data-kt-menu="true">

                    {{-- DASHBOARD --}}
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-home-2 fs-2"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>

                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                        </div>
                    </div>

                    {{-- MASTER DATA GROUP --}}
                    @canany(['users.manage', 'roles.manage', 'sidebar.manage', 'matkul.view', 'kelas.view'])
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('master.*') || request()->routeIs('dataPengguna') || request()->routeIs('manajemenRole') || request()->routeIs('manajemenSidebar') || request()->routeIs('dataMatkul') || request()->routeIs('dataKelas') ? 'here show' : '' }}">

                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-outline ki-folder fs-2"></i>
                            </span>
                            <span class="menu-title">Master Data</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @can('users.manage')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataPengguna') ? 'active' : '' }}"
                                    href="{{ route('dataPengguna') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Data Pengguna</span>
                                </a>
                            </div>
                            @endcan

                            @can('roles.manage')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('manajemenRole') ? 'active' : '' }}"
                                    href="{{ route('manajemenRole') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Manajemen Role</span>
                                </a>
                            </div>
                            @endcan

                            @can('sidebar.manage')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('manajemenSidebar') ? 'active' : '' }}"
                                    href="{{ route('manajemenSidebar') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Manajemen Sidebar</span>
                                </a>
                            </div>
                            @endcan

                            @can('matkul.view')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataMatkul') ? 'active' : '' }}"
                                    href="{{ route('dataMatkul') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Data Mata Kuliah</span>
                                </a>
                            </div>
                            @endcan

                            @can('kelas.view')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataKelas') ? 'active' : '' }}"
                                    href="{{ route('dataKelas') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Manajemen Kelas Aktif</span>
                                </a>
                            </div>
                            @endcan
                            
                            @can('ruangan.view')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('manajemenRuangan') ? 'active' : '' }}"
                                    href="{{ route('manajemenRuangan') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Manajemen Ruangan</span>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    @canany(['krs.approve', 'nilai.input', 'nilai.publish'])
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion {{ request()->routeIs('krsApprove') ? 'here show' : '' }}">
                                                
                                                <span class="menu-link">
                                                    <span class="menu-icon">
                                                        <i class="ki-outline ki-teacher fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">Manajemen Akademik</span>
                                                    <span class="menu-arrow"></span>
                                                </span>

                                                <div class="menu-sub menu-sub-accordion">
                                                    @can('krs.approve')
                                                    <div class="menu-item">
                                                        <a class="menu-link {{ request()->routeIs('krsApprove') ? 'active' : '' }}"
                                                            href="{{ route('krsApprove') }}">
                                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                            <span class="menu-title">Persetujuan KRS</span>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endcanany
                                        @canany(['nilai.input', 'nilai.publish'])
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->routeIs('akademik.nilai.*') ? 'active' : '' }}"
                                                href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Publikasi Nilai (KHS)</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endcanany
                       

                    {{-- Pengaturan Sistem & Akademik (Unified) --}}
                    @canany(['settings.view', 'academic.view'])
                    <div class="menu-item">
                        <a class="menu-link {{ request()->is('settings*') ? 'active' : '' }}" href="{{ route('settings') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-setting-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Pengaturan Sistem</span>
                        </a>
                    </div>
                    @endcanany

                    {{-- MAHASISWA SECTION --}}
                    @canany(['krs.view', 'kelas.view'])
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Mahasiswa</span>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('krsMahasiswa') || request()->routeIs('kelasSaya') ? 'here show' : '' }}">

                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-outline ki-book fs-2"></i>
                            </span>
                            <span class="menu-title">Akademik Saya</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion">
                            @can('krs.view')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('krsMahasiswa') ? 'active' : '' }}"
                                    href="{{ route('krsMahasiswa') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Kartu Rencana Studi</span>
                                </a>
                            </div>
                            @endcan

                            @can('kelas.view')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('kelasSaya') ? 'active' : '' }}"
                                    href="#">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">Kelas Saya</span>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    {{-- PROFIL AKUN --}}
                    @can('profile.view')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-user fs-2"></i>
                            </span>
                            <span class="menu-title">Akun Profil</span>
                        </a>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
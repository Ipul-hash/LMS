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
            <img alt="Logo"
                src="{{ asset('assets/media/logos/default.svg') }}"
                class="h-25px app-sidebar-logo-default theme-light-show" />
            <img alt="Logo"
                src="{{ asset('assets/media/logos/default-dark.svg') }}"
                class="h-25px app-sidebar-logo-default theme-dark-show" />
            <img alt="Logo"
                src="{{ asset('assets/media/logos/default-small.svg') }}"
                class="h-20px app-sidebar-logo-minimize" />
        </a>

        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-black-left-line fs-3 rotate-180"></i>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll"
                class="scroll-y my-5 mx-3"
                data-kt-scroll="true"
                data-kt-scroll-activate="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">

                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                    id="#kt_app_sidebar_menu"
                    data-kt-menu="true"
                    data-kt-menu-expand="false">

                    {{-- Dashboard --}}
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
                            <span class="menu-heading fw-bold text-uppercase fs-7 ls-1">Menu</span>
                        </div>
                    </div>

                    {{-- Master Data --}}
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('master.*') ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-outline ki-folder fs-2"></i>
                            </span>
                            <span class="menu-title">Master Data</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataPengguna ') ? 'active' : '' }}"
                                    href="{{ route('dataPengguna') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Pengguna</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('manajemenRole') ? 'active' : '' }}"
                                    href="{{route ('manajemenRole') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Manajemen Role</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('manajemenSidebar') ? 'active' : '' }}"
                                    href="{{route ('manajemenSidebar') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Manajemen Sidebar</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataMatkul') ? 'active' : '' }}"
                                    href="{{route ('dataMatkul') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Data Mata Kuliah</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('dataKelas') ? 'active' : '' }}"
                                    href="{{route ('dataKelas') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Manajemen Kelas Aktif</span>
                                </a>
                            </div>
                        </div>
                        </div>

                   

                    {{-- Manajemen Akademik --}}
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ request()->routeIs('akademik.*') ? 'here show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-outline ki-teacher fs-2"></i>
                            </span>
                            <span class="menu-title">Manajemen Akademik</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('akademik.krs.*') ? 'active' : '' }}"
                                    href="#">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Persetujuan KRS</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('akademik.nilai.*') ? 'active' : '' }}"
                                    href="#">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Publikasi Nilai (KHS)</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="app-sidebar-footer flex-column-auto px-6 pb-6" id="kt_app_sidebar_footer">
        <a href="#"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 w-100"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-dismiss="click"
            title="Pusat Bantuan">
            <span class="btn-label">Pusat Bantuan</span>
            <i class="ki-outline ki-information-5 btn-icon fs-2 m-0"></i>
        </a>
    </div>

</div>

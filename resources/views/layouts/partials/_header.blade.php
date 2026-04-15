<div id="kt_app_header" class="app-header"
    data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">

    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Tampilkan sidebar">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
            </div>
        </div>

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/default-small.svg') }}" class="h-30px" />
            </a>
        </div>

        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <div class="app-header-menu app-header-mobile-drawer align-items-stretch"
                data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu"
                data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true"
                data-kt-drawer-width="250px"
                data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle"
                data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
            </div>

            <div class="app-navbar flex-shrink-0">

                <div class="app-navbar-item ms-1 ms-md-4">
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-notification-status fs-2"></i>
                    </div>
                </div>

                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <span class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>
                    </div>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">

                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-4">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->user()->name ?? 'Pengguna' }}
                                    </div>
                                    <span class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ auth()->user()->email ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">Profil Saya</a>
                        </div>

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="menu-link px-5 border-0 bg-transparent w-100 text-start">
                                    Keluar
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="app-navbar-item d-lg-none ms-2 me-n2">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-element-4 fs-1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

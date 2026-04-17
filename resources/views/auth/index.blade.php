<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Masuk &mdash; {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank">

    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                themeMode = localStorage.getItem("data-bs-theme") ?? defaultThemeMode;
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            {{-- Panel Kiri --}}
            <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
                style="background-image: url('{{ asset('assets/media/misc/auth-bg.png') }}')">
                <div class="d-flex flex-column flex-center py-15 px-5 px-md-15 w-100">

                    <a href="{{ route('dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ asset('assets/media/logos/custom-1.svg') }}" class="h-60px" />
                    </a>

                    <img class="mx-auto w-275px w-md-50 w-xl-450px mb-10"
                        src="{{ asset('assets/media/misc/auth-screens.png') }}"
                        alt="Ilustrasi LMS" />

                    <h1 class="text-white fs-2qx fw-bold text-center mb-5">
                        Selamat Datang di {{ config('app.name') }}
                    </h1>

                    <div class="text-white fs-base text-center">
                        Platform pembelajaran terpadu untuk mengelola <br />
                        <span class="fw-bold">kelas, mata kuliah,</span> dan <span class="fw-bold">nilai akademik</span> secara efisien.
                    </div>

                </div>
            </div>

            {{-- Panel Kanan --}}
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px w-sm-400px p-10">

                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">Masuk ke Akun</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Gunakan kredensial yang telah diberikan</div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                    <i class="ki-outline ki-shield-cross fs-2hx text-danger me-4"></i>
                                    <div class="d-flex flex-column">
                                        <span>{{ $errors->first() }}</span>
                                    </div>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                    <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
                                    <div class="d-flex flex-column">
                                        <span>{{ session('status') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="fv-row mb-8">
                                <label class="form-label fs-6 fw-bolder text-gray-900" for="email">
                                    Email
                                </label>
                                <input
                                    class="form-control bg-transparent @error('email') is-invalid @enderror"
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@contoh.ac.id"
                                    autocomplete="email"
                                    autofocus
                                />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fv-row mb-3">
                                <label class="form-label fw-bolder text-gray-900 fs-6 mb-0" for="password">
                                    Kata Sandi
                                </label>
                                <div class="position-relative mb-3">
                                    <input
                                        class="form-control bg-transparent @error('password') is-invalid @enderror"
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="••••••••"
                                        autocomplete="current-password"
                                    />
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="ki-outline ki-eye-slash fs-2"></i>
                                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label text-gray-700" for="remember">
                                        Ingat saya
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-primary">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Masuk</span>
                                    <span class="indicator-progress">
                                        Memproses...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="d-flex flex-center flex-wrap px-5">
                    <div class="d-flex fw-semibold text-muted fs-base">
                        <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>var hostUrl = "{{ asset('assets/') }}";</script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>

</body>
</html>
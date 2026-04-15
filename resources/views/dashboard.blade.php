@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Dashboard</li>
@endsection

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

        <div class="col-md-6 col-xl-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                style="background-color: #F1416C; background-image: url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Pengguna</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                style="background-color: #7239EA; background-image: url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Mata Kuliah Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                style="background-color: #17C653; background-image: url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Kelas Berjalan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
                style="background-color: #0095E8; background-image: url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">KRS Menunggu Persetujuan</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Selamat datang, {{ auth()->user()->name ?? 'Admin' }} 👋</span>
                        <span class="text-muted mt-1 fw-semibold fs-6">Sistem Informasi Manajemen Pembelajaran</span>
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-gray-600 fs-6">
                        Gunakan menu di sebelah kiri untuk mengakses fitur-fitur yang tersedia.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/data-matkul', [PageController::class, 'dataMatkul'])->name('dataMatkul');
Route::get('/data-kelas', [PageController::class, 'dataKelas'])->name('dataKelas');
Route::get('/data-pengguna', [PageController::class, 'dataPengguna'])->name('dataPengguna');
Route::get('/manajemen-role', [PageController::class, 'manajemenRole'])->name('manajemenRole');
Route::get('/manajemen-sidebar', [PageController::class, 'manajemenSidebar'])->name('manajemenSidebar');
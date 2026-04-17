<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Master Data - Data Pengguna (User CRUD)
    Route::prefix('/master/pengguna')->middleware('can:manage users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dataPengguna');
        Route::post('/', [UserController::class, 'store'])->name('dataPengguna.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('dataPengguna.show');
        Route::put('/{user}', [UserController::class, 'update'])->name('dataPengguna.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('dataPengguna.destroy');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('dataPengguna.toggleStatus');
    });

    // Master Data - Manajemen Role (Role CRUD)
    Route::prefix('/master/role')->middleware('can:manage roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('manajemenRole');
        Route::post('/', [RoleController::class, 'store'])->name('manajemenRole.store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('manajemenRole.show');
        Route::put('/{role}', [RoleController::class, 'update'])->name('manajemenRole.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('manajemenRole.destroy');
    });

    // Master Data - Data Mata Kuliah
    Route::get('/data-matkul', [PageController::class, 'dataMatkul'])
        ->middleware('permission:view matkul')
        ->name('dataMatkul');

    // Master Data - Data Kelas
    Route::get('/data-kelas', [PageController::class, 'dataKelas'])
        ->middleware('permission:create kelas|edit kelas|delete kelas')
        ->name('dataKelas');

    // Master Data - Manajemen Sidebar
    Route::get('/manajemen-sidebar', [PageController::class, 'manajemenSidebar'])
        ->middleware('permission:manage sidebar')
        ->name('manajemenSidebar');

});
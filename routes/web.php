<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/master/pengguna')->middleware('can:users.manage')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dataPengguna');
        Route::post('/', [UserController::class, 'store'])->name('dataPengguna.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('dataPengguna.show');
        Route::put('/{user}', [UserController::class, 'update'])->name('dataPengguna.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('dataPengguna.destroy');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('dataPengguna.toggleStatus');
    });

    Route::prefix('/master/role')->middleware('can:roles.manage')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('manajemenRole');
        Route::post('/', [RoleController::class, 'store'])->name('manajemenRole.store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('manajemenRole.show');
        Route::put('/{role}', [RoleController::class, 'update'])->name('manajemenRole.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('manajemenRole.destroy');
    });

    Route::get('/krs', [PageController::class, 'krsMahasiswa'])
    ->middleware('can:krs.view')
    ->name('krsMahasiswa');

    Route::get('/krs-dosen', [PageController::class, 'krsApprove'])
    ->middleware('can:krs.view')
    ->name('krsApprove');

    Route::get('/kelas-saya', [PageController::class, 'kelasSaya'])
        ->middleware('can:kelas.view')
        ->name('kelasSaya');
    
    Route::get('/data-matkul', [PageController::class, 'dataMatkul'])
        ->middleware('permission:matkul.view')
        ->name('dataMatkul');
    
    Route::get('/data-ruangan', [PageController::class, 'manajemenRuangan'])
        ->middleware('permission:ruangan.view')
        ->name('manajemenRuangan');

    Route::get('/data-kelas', [PageController::class, 'dataKelas'])
        ->middleware('permission:kelas.create|kelas.edit|kelas.delete')
        ->name('dataKelas');

    Route::get('/manajemen-sidebar', [PageController::class, 'manajemenSidebar'])
        ->middleware('permission:sidebar.manage')
        ->name('manajemenSidebar');

    Route::get('/settings', [PageController::class, 'settings'])
        ->name('settings');
});
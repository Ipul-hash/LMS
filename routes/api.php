<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\KrsController;
use App\Http\Controllers\Api\V1\KhsController;
use App\Http\Controllers\Api\V1\ClassController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | COURSES (MATA KULIAH)
        |--------------------------------------------------------------------------
        */
        Route::get('/courses', [CourseController::class, 'daftarMataKuliah'])
            ->middleware('permission:view matkul');

        Route::get('/courses/{id}', [CourseController::class, 'melihatMataKuliah'])
            ->middleware('permission:view matkul');

        Route::post('/courses', [CourseController::class, 'membuatMataKuliah'])
            ->middleware('permission:create matkul');

        Route::put('/courses/{id}', [CourseController::class, 'mengubahMataKuliah'])
            ->middleware('permission:edit matkul');

        Route::delete('/courses/{id}', [CourseController::class, 'menghapusMataKuliah'])
            ->middleware('permission:delete matkul');


        /*
        |--------------------------------------------------------------------------
        | KRS (KARTU RENCANA STUDI)
        |--------------------------------------------------------------------------
        */
        Route::get('/pa/krs-request', [KrsController::class, 'daftarKrsMahasiswa'])
            ->middleware('permission:approve krs');

        Route::put('/krs/{id}/approve', [KrsController::class, 'approveKrs'])
            ->middleware('permission:approve krs');

        Route::put('/krs/{id}/reject', [KrsController::class, 'tolakKrs'])
            ->middleware('permission:approve krs');

        Route::get('/krs/active', [KrsController::class, 'melihatKrsAktif'])
            ->middleware('permission:view krs');


        /*
        |--------------------------------------------------------------------------
        | KHS (KARTU HASIL STUDI)
        |--------------------------------------------------------------------------
        */
        Route::put('/khs/publish', [KhsController::class, 'publishNilai'])
            ->middleware('permission:publish nilai');

        Route::get('/khs/{semester}', [KhsController::class, 'lihatKhs'])
            ->middleware('permission:view khs');


        /*
        |--------------------------------------------------------------------------
        | CLASSES (KELAS)
        |--------------------------------------------------------------------------
        */
        Route::get('/classes', [ClassController::class, 'jadwalKelas'])
            ->middleware('permission:view kelas');

        Route::post('/classes', [ClassController::class, 'membuatKelas'])
            ->middleware('permission:manage kelas');
    });
});
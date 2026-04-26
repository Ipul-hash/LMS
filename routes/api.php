<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\KhsController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\RuanganController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\AcademicPeriodController;
use App\Http\Controllers\Api\V1\MahasiswaKrsController;
use App\Http\Controllers\Api\V1\DosenKrsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Untuk Admin - Settings & Academic Period
        |--------------------------------------------------------------------------
        */
        Route::get('/settings', [SettingController::class, 'index'])
            ->middleware('can:settings.view');
        Route::post('/settings/update', [SettingController::class, 'updateSettings'])
            ->middleware('can:settings.edit');

        Route::get('/academic-periods', [AcademicPeriodController::class, 'index'])
            ->middleware('can:academic.view');
        Route::post('/academic-periods', [AcademicPeriodController::class, 'store'])
            ->middleware('can:academic.create');
        Route::post('/academic-periods/{id}/set-active', [AcademicPeriodController::class, 'setActive'])
            ->middleware('can:academic.edit');
        Route::delete('/academic-periods/{id}', [AcademicPeriodController::class, 'destroy'])
            ->middleware('can:academic.delete');


        /*
        |--------------------------------------------------------------------------
        | Untuk Admin - Manajemen Mata Kuliah
        |--------------------------------------------------------------------------
        */
        Route::get('/courses', [CourseController::class, 'daftarMataKuliah'])->middleware('can:matkul.view');
        Route::get('/courses/{id}', [CourseController::class, 'melihatMataKuliah'])->middleware('can:matkul.view');
        Route::post('/courses', [CourseController::class, 'membuatMataKuliah'])->middleware('can:matkul.create');
        Route::put('/courses/{id}', [CourseController::class, 'mengubahMataKuliah'])->middleware('can:matkul.edit');
        Route::delete('/courses/{id}', [CourseController::class, 'menghapusMataKuliah'])->middleware('can:matkul.delete');


       /*
        |--------------------------------------------------------------------------
        | Untuk Mahasiwa - KRS (KARTU RENCANA STUDI)
        |--------------------------------------------------------------------------
        */

        Route::prefix('krs')->group(function () {
                Route::get('/active', [MahasiswaKrsController::class, 'index'])
                    ->middleware('can:krs.view');

                Route::post('/add', [MahasiswaKrsController::class, 'store'])
                    ->middleware('can:krs.create');

                Route::delete('/item/{item_id}', [MahasiswaKrsController::class, 'destroy'])
                    ->middleware('can:krs.edit');
            });
         /*
        |--------------------------------------------------------------------------
        | Untuk Dosen - KRS (KARTU RENCANA STUDI)
        |--------------------------------------------------------------------------
        */
        Route::prefix('pa')->group(function () {
            Route::get('/krs-request', [DosenKrsController::class, 'index'])
                ->middleware('can:krs.view');

            Route::get('/krs-request/{id}', [DosenKrsController::class, 'show'])
                ->middleware('can:krs.view');

            Route::put('/krs/{id}/decision', [DosenKrsController::class, 'update'])
                ->middleware('can:krs.approve');
        });

        /*
        |--------------------------------------------------------------------------
        | KHS (KARTU HASIL STUDI)
        |--------------------------------------------------------------------------
        */
        Route::put('/khs/publish', [KhsController::class, 'publishNilai'])->middleware('can:khs.publish');
        Route::get('/khs/{semester}', [KhsController::class, 'lihatKhs'])->middleware('can:khs.view');


        /*
        |--------------------------------------------------------------------------
        | CLASSES (KELAS)
        |--------------------------------------------------------------------------
        */
        Route::get('/classes', [ClassController::class, 'jadwalKelas'])->middleware('can:kelas.view');
        Route::post('/classes', [ClassController::class, 'membuatKelas'])->middleware('can:kelas.create');
        Route::get('/classes/{id}', [ClassController::class, 'show'])->middleware('can:kelas.view');
        Route::put('/classes/{id}', [ClassController::class, 'update'])->middleware('can:kelas.edit');
        Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->middleware('can:kelas.delete');
        Route::get('/mahasiswa/kelas-saya', [ClassController::class, 'kelasSaya'])->middleware('can:kelas.view');

        /*
        |--------------------------------------------------------------------------
        | RUANGAN & USERS
        |--------------------------------------------------------------------------
        */
        Route::get('/ruangan', [RuanganController::class, 'daftarRuangan'])->middleware('can:ruangan.view');
        Route::post('/ruangan', [RuanganController::class, 'store'])->middleware('can:ruangan.create');
        Route::get('/ruangan/{id}', [RuanganController::class, 'detailRuangan'])->middleware('can:ruangan.view');
        Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->middleware('can:ruangan.edit');
        Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->middleware('can:ruangan.delete');
        
        Route::get('/lecturers', [UserController::class, 'listDosen']);
    });
});
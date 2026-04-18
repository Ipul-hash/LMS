<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\KrsController;
use App\Http\Controllers\Api\V1\KhsController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\RuanganController;
use App\Http\Controllers\APi\v1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
        Route::get('/pa/krs-request', [KrsController::class, 'daftarKrsMahasiswa']);

Route::get('/ruangan', [RuanganController::class, 'daftarRuangan']);
Route::get('/ruangan/{id}', [RuanganController::class, 'detailRuangan']);
Route::get('/pa/krs-request', [KrsController::class, 'daftarKrsMahasiswa']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | COURSES (MATA KULIAH)
        |--------------------------------------------------------------------------
        */
        Route::get('/courses', [CourseController::class, 'daftarMataKuliah'])
            ->middleware('can:matkul.view');

        Route::get('/courses/{id}', [CourseController::class, 'melihatMataKuliah'])
            ->middleware('can:matkul.view');

        Route::post('/courses', [CourseController::class, 'membuatMataKuliah'])
            ->middleware('can:matkul.create');

        Route::put('/courses/{id}', [CourseController::class, 'mengubahMataKuliah'])
            ->middleware('can:matkul.edit');

        Route::delete('/courses/{id}', [CourseController::class, 'menghapusMataKuliah'])
            ->middleware('can:matkul.delete');


        /*
        |--------------------------------------------------------------------------
        | KRS (KARTU RENCANA STUDI)
        |--------------------------------------------------------------------------
        */
        Route::get('/pa/krs-request', [KrsController::class, 'daftarKrsMahasiswa'])
            ->middleware('can:krs.view');

        Route::put('/krs/{id}/approve', [KrsController::class, 'approveKrs'])
            ->middleware('can:krs.approve');

        Route::put('/krs/{id}/reject', [KrsController::class, 'tolakKrs'])
            ->middleware('can:krs.reject');

        Route::get('/krs/active', [KrsController::class, 'melihatKrsAktif'])
            ->middleware('can:krs.view');


        /*
        |--------------------------------------------------------------------------
        | KHS (KARTU HASIL STUDI)
        |--------------------------------------------------------------------------
        */
        Route::put('/khs/publish', [KhsController::class, 'publishNilai'])
            ->middleware('can:khs.publish');

        Route::get('/khs/{semester}', [KhsController::class, 'lihatKhs'])
            ->middleware('can:khs.view');


        /*
        |--------------------------------------------------------------------------
        | CLASSES (KELAS)
        |--------------------------------------------------------------------------
        */
        Route::get('/classes', [ClassController::class, 'jadwalKelas'])
            ->middleware('can:kelas.view');

        Route::post('/classes', [ClassController::class, 'membuatKelas'])
            ->middleware('can:kelas.create');

        Route::get('/classes/{id}', [ClassController::class, 'show'])
            ->middleware('can:kelas.view');

        Route::put('/classes/{id}', [ClassController::class, 'update'])
            ->middleware('can:kelas.edit');

        Route::delete('/classes/{id}', [ClassController::class, 'destroy'])
            ->middleware('can:kelas.delete');

        /*
        |--------------------------------------------------------------------------
        | RUANGAN 
        |--------------------------------------------------------------------------
        */
        Route::get('/ruangan', [RuanganController::class, 'daftarRuangan'])
            ->middleware('can:ruangan.view');
        Route::post('/ruangan', [RuanganController::class, 'store'])
            ->middleware('can:ruangan.create');
        Route::get('/ruangan/{id}', [RuanganController::class, 'detailRuangan'])
            ->middleware('can:ruangan.view');
        Route::put('/ruangan/{id}', [RuanganController::class, 'update'])
            ->middleware('can:ruangan.edit');
        Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])
            ->middleware('can:ruangan.delete');
        Route::get('/lecturers', [UserController::class, 'listDosen']);
    });
});
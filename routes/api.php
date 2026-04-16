<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\KrsController;
use App\Http\Controllers\Api\V1\KhsController;
use App\Http\Controllers\Api\V1\ClassController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/courses', [CourseController::class, 'daftarMataKuliah']);
Route::get('/v1/courses/{id}', [CourseController::class, 'melihatMataKuliah']);
Route::post('/v1/courses/', [CourseController::class, 'membuatMataKuliah']);
Route::put('/v1/courses/{id}', [CourseController::class, 'mengubahMataKuliah']);
Route::delete('/v1/courses/{id}', [CourseController::class, 'menghapusMataKuliah']);

Route::get('/v1/pa/krs-request', [KrsController::class, 'daftarKrsMahasiswa']);
Route::put('/v1/krs/{id}/approve', [KrsController::class, 'approveKrs']);
Route::put('/v1/krs/{id}/reject', [KrsController::class, 'tolakKrs']);
Route::get('/v1/krs/active', [KrsController::class, 'melihatKrsAktif']);

Route::put('/v1/khs/publish', [KhsController::class, 'publishNilai']);
Route::get('/v1/khs/{semseter}', [KhsController::class, 'lihatKhs']);

Route::get('/v1/classes', [ClassController::class, 'jadwalKelas']);
Route::post('/v1/classes', [ClassController::class, 'membuatKelas']);
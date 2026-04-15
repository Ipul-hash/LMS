<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/courses', [CourseController::class, 'daftarMataKuliah']);
Route::get('/v1/courses/{id}', [CourseController::class, 'melihatMataKuliah']);
Route::post('/v1/courses/', [CourseController::class, 'membuatMataKuliah']);
Route::put('/v1/courses/{id}', [CourseController::class, 'mengubahMataKuliah']);
Route::delete('/v1/courses/{id}', [CourseController::class, 'menghapusMataKuliah']);

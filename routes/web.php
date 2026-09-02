<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/profile', function () {
    return view('profile');
});

Route::get('/konsultasi', function () {
    return view('konsultasi.index');
})->name('konsultasi');

use App\Http\Controllers\KonsultasiController;
Route::get('konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
Route::post('konsultasi', [KonsultasiController::class, 'store'])->name('konsultasi.store');
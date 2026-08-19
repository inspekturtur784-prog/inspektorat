<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KmsController;
use App\Http\Controllers\PedomanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/knowledge-base', [KmsController::class, 'index'])->name('kms.index');
Route::get('/knowledge-base/{slug}', [KmsController::class, 'kategori'])->name('kms.kategori');

Route::get('/pedoman', [PedomanController::class, 'index'])->name('pedoman.index');
Route::get('/pedoman/{slug}', [PedomanController::class, 'kategori'])->name('pedoman.kategori');
Route::get('/pedoman/{slug}/{id}', [PedomanController::class, 'detail'])->name('pedoman.detail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
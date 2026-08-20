<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------- Profil (Section A-D ada langsung di halaman ini) ----------
Route::view('/profil', 'profil');
Route::get('/profil/data-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');

// ---------- F. Galeri (bagian dari Profil, tapi halaman tersendiri) ----------
Route::get('/profil/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/profil/galeri/{slug}', [GaleriController::class, 'show'])->name('galeri.show');

// ---------- Layanan ----------
Route::view('/layanan', 'coming-soon', ['title' => 'Layanan Utama']);
Route::view('/layanan/konsultansi', 'coming-soon', ['title' => 'Konsultansi Online']);
Route::view('/layanan/kms', 'coming-soon', ['title' => 'KMS / Pedoman']);
Route::view('/layanan/buletin', 'coming-soon', ['title' => 'Buletin Pengawasan']);
Route::view('/layanan/skm', 'coming-soon', ['title' => 'SKM Inspektorat']);

Route::view('/berita', 'coming-soon', ['title' => 'Berita']);
Route::view('/kontak', 'coming-soon', ['title' => 'Kontak Kami']);

// ---------- Artikel (publik) ----------
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// ---------- Admin: CRUD Artikel, Data Pegawai, Galeri ----------
// PENTING: tambahkan middleware login admin di sini sebelum production,
// contoh: Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () { ... }
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/artikel', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/tambah', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/tambah', [AdminPegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [AdminPegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [AdminPegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [AdminPegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/tambah', [AdminGaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');
});
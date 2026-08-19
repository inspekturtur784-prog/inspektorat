<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------- Profil (Section A Tentang Inspektorat & B Visi-Misi ada di halaman ini langsung) ----------
Route::view('/profil', 'profil');
Route::view('/profil/peta-jabatan', 'coming-soon', ['title' => 'Peta Jabatan Inspektorat']);
Route::view('/profil/data-pegawai', 'coming-soon', ['title' => 'Data Pegawai']);

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

// ---------- Admin: CRUD Artikel ----------
// PENTING: tambahkan middleware login admin di sini sebelum production,
// contoh: Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () { ... }
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/artikel', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/tambah', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
});
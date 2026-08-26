<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\PengaturanProfilController;
use App\Http\Controllers\Admin\TugasFungsiController;
use App\Http\Controllers\Admin\StrukturBagianController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\PasswordController as AdminPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------- Profil (Section A-D ada langsung di halaman ini, sekarang dari database) ----------
Route::get('/profil', [ProfilController::class, 'index']);
Route::get('/profil/struktur/{struktur}', [StrukturController::class, 'show'])->name('struktur.show');
Route::get('/profil/data-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/profil/data-pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');

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

// ---------- Admin: Login / Logout (TIDAK butuh login untuk akses ini) ----------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit')->middleware('guest');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// ---------- Admin: semua halaman di bawah ini WAJIB login ----------
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/ganti-password', [AdminPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [AdminPasswordController::class, 'update'])->name('password.update');

    // Tentang Inspektorat, Visi & Misi, Tugas Pokok (1 halaman form)
    Route::get('/pengaturan', [PengaturanProfilController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [PengaturanProfilController::class, 'update'])->name('pengaturan.update');

    // Kartu Fungsi (Tugas & Fungsi)
    Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugasfungsi.index');
    Route::get('/tugas-fungsi/tambah', [TugasFungsiController::class, 'create'])->name('tugasfungsi.create');
    Route::post('/tugas-fungsi', [TugasFungsiController::class, 'store'])->name('tugasfungsi.store');
    Route::get('/tugas-fungsi/{tugasFungsi}/edit', [TugasFungsiController::class, 'edit'])->name('tugasfungsi.edit');
    Route::put('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'update'])->name('tugasfungsi.update');
    Route::delete('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'destroy'])->name('tugasfungsi.destroy');

    // Struktur Organisasi
    Route::get('/struktur', [StrukturBagianController::class, 'index'])->name('struktur.index');
    Route::get('/struktur/tambah', [StrukturBagianController::class, 'create'])->name('struktur.create');
    Route::post('/struktur', [StrukturBagianController::class, 'store'])->name('struktur.store');
    Route::get('/struktur/{struktur}/edit', [StrukturBagianController::class, 'edit'])->name('struktur.edit');
    Route::put('/struktur/{struktur}', [StrukturBagianController::class, 'update'])->name('struktur.update');
    Route::delete('/struktur/{struktur}', [StrukturBagianController::class, 'destroy'])->name('struktur.destroy');

    // Artikel
    Route::get('/artikel', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/tambah', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    // Data Pegawai
    Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/tambah', [AdminPegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [AdminPegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [AdminPegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [AdminPegawaiController::class, 'destroy'])->name('pegawai.destroy');

    // Galeri
    Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/tambah', [AdminGaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');
});
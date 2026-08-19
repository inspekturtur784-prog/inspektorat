<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
| Halaman lain (Profil, Layanan, Berita, Kontak, SKM) menyusul —
| tinggal tambahkan controller & route-nya di sini.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Placeholder untuk halaman yang link-nya sudah ada di Home,
// supaya tombol/nav tidak 404 dulu sebelum halamannya dibuat.
Route::view('/profil', 'coming-soon', ['title' => 'Profil Inspektorat']);
Route::view('/layanan', 'coming-soon', ['title' => 'Layanan Utama']);
Route::view('/layanan/konsultansi', 'coming-soon', ['title' => 'Konsultansi Online']);
Route::view('/layanan/kms', 'coming-soon', ['title' => 'KMS / Pedoman']);
Route::view('/layanan/buletin', 'coming-soon', ['title' => 'Buletin Pengawasan']);
Route::view('/layanan/skm', 'coming-soon', ['title' => 'SKM Inspektorat']);
Route::view('/berita', 'coming-soon', ['title' => 'Berita']);
Route::view('/kontak', 'coming-soon', ['title' => 'Kontak Kami']);
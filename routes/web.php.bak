<?php

Route::get('/kms-file/{path}', function ($path) {
    $fullPath = public_path('kms-files/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*');

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KmsController;
use App\Http\Controllers\PedomanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SkmController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\InformasiController;
use App\Models\Buletin;

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\BuletinController as AdminBuletinController;
use App\Http\Controllers\Admin\PengaturanProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesanController as AdminPesanController;
use App\Http\Controllers\Admin\TugasFungsiController;
use App\Http\Controllers\Admin\StrukturBagianController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\PasswordController as AdminPasswordController;
use App\Http\Controllers\Admin\ProfilHighlightController;
use App\Http\Controllers\Admin\KmsPedomanDashboardController;
use App\Http\Controllers\Admin\KategoriKmsController;
use App\Http\Controllers\Admin\SubkategoriKmsController;
use App\Http\Controllers\Admin\GrupDokumenController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\PedomanKategoriController;
use App\Http\Controllers\Admin\PedomanDokumenController;
use App\Http\Controllers\Admin\InformasiDokumenController;

// ---------- Beranda ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------- Pengaduan ----------
Route::get('/pengaduan', function () {
    return view('pengaduan');
})->name('pengaduan');

// ---------- Profil Publik ----------
Route::redirect('/profile-dinas', '/profil', 301);

Route::get('/profil', [ProfilController::class, 'index'])
    ->name('profil.index');

Route::get('/profil/struktur/{struktur}', [StrukturController::class, 'show'])
    ->name('struktur.show');

Route::get('/profil/data-pegawai', [PegawaiController::class, 'index'])
    ->name('pegawai.index');

Route::get('/profil/data-pegawai/{pegawai}', [PegawaiController::class, 'show'])
    ->name('pegawai.show');

// ---------- Galeri Publik ----------
Route::get('/profil/galeri', [GaleriController::class, 'index'])
    ->name('galeri.index');

Route::get('/profil/galeri/{slug}', [GaleriController::class, 'show'])
    ->name('galeri.show');

// ---------- Layanan ----------
Route::redirect('/layanan', '/#layanan');

Route::get('/layanan/konsultansi', [KonsultasiController::class, 'index'])
    ->name('konsultasi.index');

Route::post('/konsultasi', [KonsultasiController::class, 'store'])
    ->name('konsultasi.store');

Route::get('/layanan/konsultasi', function () {
    return redirect()->route('konsultasi.index');
});

Route::view('/layanan/kms', 'coming-soon', [
    'title' => 'KMS / Pedoman'
]);

Route::redirect('/layanan/buletin', '/buletin', 301);

Route::view('/layanan/skm', 'coming-soon', [
    'title' => 'SKM Inspektorat'
]);

// ---------- Berita & Artikel Publik ----------
Route::get('/berita', [BeritaController::class, 'index'])
    ->name('berita.index');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])
    ->name('articles.show');

// ---------- Kontak ----------
Route::get('/kontak', [KontakController::class, 'show'])
    ->name('kontak.show');

Route::post('/kontak', [KontakController::class, 'store'])
    ->name('kontak.store');

// ---------- Informasi (SOP, Informasi Berkala, Informasi Setiap Saat, IKM, Persepsi Korupsi) ----------
Route::get('/informasi/{slug}', [InformasiController::class, 'show'])
    ->name('informasi.show');

// ---------- Knowledge Base & Pedoman (PUBLIK — TIDAK DIUBAH) ----------
Route::get('/knowledge-base', [KmsController::class, 'index'])->name('kms.index');
Route::get('/knowledge-base/{slug}', [KmsController::class, 'kategori'])->name('kms.kategori');

Route::get('/pedoman', [PedomanController::class, 'index'])->name('pedoman.index');
Route::get('/pedoman/{slug}', [PedomanController::class, 'kategori'])->name('pedoman.kategori');
Route::get('/pedoman/{slug}/{id}', [PedomanController::class, 'detail'])->name('pedoman.detail');

// ==========================================================
// BULETIN PUBLIK (dari database)
// ==========================================================
Route::get('/buletin', function () {
    $buletins = Buletin::published()->get();
    return view('buletin.index', ['buletins' => $buletins]);
})->name('buletin.index');

Route::get('/buletin/{slug}', function ($slug) {
    $buletin = Buletin::where('slug', $slug)->published()->firstOrFail();
    return view('buletin.show', ['buletin' => $buletin]);
})->name('buletin.show');

// ---------- Redirect Login User ke Admin Login ----------
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// ==========================================================
// ADMIN AUTHENTICATION (LOGIN / LOGOUT)
// ==========================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login')
        ->middleware('guest');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.submit')
        ->middleware('guest');

    // Menggunakan match agar logout bisa diakses via GET maupun POST
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');
});

// Redirect /dashboard biasa ke Dashboard Admin
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->middleware('auth');

// ==========================================================
// ADMIN DASHBOARD & PANEL (WAJIB LOGIN)
// ==========================================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // ---------- Dashboard Utama ----------
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ---------- Pesan ----------
    Route::get('/pesan', [AdminPesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [AdminPesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [AdminPesanController::class, 'destroy'])->name('pesan.destroy');

    // ---------- Ganti Password ----------
    Route::get('/ganti-password', [AdminPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [AdminPasswordController::class, 'update'])->name('password.update');

    // ---------- Pengaturan Profil ----------
    Route::get('/pengaturan', [PengaturanProfilController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [PengaturanProfilController::class, 'update'])->name('pengaturan.update');

    // ---------- Tugas & Fungsi ----------
    Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugasfungsi.index');
    Route::put('/tugas-fungsi/tugas-pokok', [TugasFungsiController::class, 'updateTugasPokok'])->name('tugasfungsi.tugaspokok.update');
    Route::get('/tugas-fungsi/tambah', [TugasFungsiController::class, 'create'])->name('tugasfungsi.create');
    Route::post('/tugas-fungsi', [TugasFungsiController::class, 'store'])->name('tugasfungsi.store');
    Route::get('/tugas-fungsi/{tugasFungsi}/edit', [TugasFungsiController::class, 'edit'])->name('tugasfungsi.edit');
    Route::put('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'update'])->name('tugasfungsi.update');
    Route::delete('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'destroy'])->name('tugasfungsi.destroy');

    // ---------- Struktur ----------
    Route::get('/struktur', [StrukturBagianController::class, 'index'])->name('struktur.index');
    Route::get('/struktur/tambah', [StrukturBagianController::class, 'create'])->name('struktur.create');
    Route::post('/struktur', [StrukturBagianController::class, 'store'])->name('struktur.store');
    Route::get('/struktur/{struktur}/edit', [StrukturBagianController::class, 'edit'])->name('struktur.edit');
    Route::put('/struktur/{struktur}', [StrukturBagianController::class, 'update'])->name('struktur.update');
    Route::delete('/struktur/{struktur}', [StrukturBagianController::class, 'destroy'])->name('struktur.destroy');

    // ---------- Artikel ----------
    Route::get('/artikel', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/tambah', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    // ---------- Pegawai ----------
    Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/tambah', [AdminPegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [AdminPegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [AdminPegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [AdminPegawaiController::class, 'destroy'])->name('pegawai.destroy');

    // ---------- Galeri ----------
    Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/tambah', [AdminGaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

    // ---------- Buletin ----------
    Route::get('/buletin', [AdminBuletinController::class, 'index'])->name('buletin.index');
    Route::get('/buletin/tambah', [AdminBuletinController::class, 'create'])->name('buletin.create');
    Route::post('/buletin', [AdminBuletinController::class, 'store'])->name('buletin.store');
    Route::get('/buletin/{buletin}/edit', [AdminBuletinController::class, 'edit'])->name('buletin.edit');
    Route::put('/buletin/{buletin}', [AdminBuletinController::class, 'update'])->name('buletin.update');
    Route::delete('/buletin/{buletin}', [AdminBuletinController::class, 'destroy'])->name('buletin.destroy');

    // ---------- Dokumen Informasi (SOP, IKM, Persepsi Korupsi, dst) ----------
    Route::get('/informasi-dokumen', [InformasiDokumenController::class, 'index'])->name('informasidokumen.index');
    Route::get('/informasi-dokumen/tambah', [InformasiDokumenController::class, 'create'])->name('informasidokumen.create');
    Route::post('/informasi-dokumen', [InformasiDokumenController::class, 'store'])->name('informasidokumen.store');
    Route::get('/informasi-dokumen/{informasiDokumen}/edit', [InformasiDokumenController::class, 'edit'])->name('informasidokumen.edit');
    Route::put('/informasi-dokumen/{informasiDokumen}', [InformasiDokumenController::class, 'update'])->name('informasidokumen.update');
    Route::delete('/informasi-dokumen/{informasiDokumen}', [InformasiDokumenController::class, 'destroy'])->name('informasidokumen.destroy');

    // ==========================================================
    // KMS & PEDOMAN (dashboard admin, terpisah dari halaman publik)
    // ==========================================================

    // ---------- Dashboard gabungan (KMS + Pedoman) ----------
    Route::get('/kms', [KmsPedomanDashboardController::class, 'index'])->name('kms.index');

    // ---------- KMS: Kategori ----------
    Route::get('/kms/kategori/tambah', [KategoriKmsController::class, 'create'])->name('kms.kategori.create');
    Route::post('/kms/kategori', [KategoriKmsController::class, 'store'])->name('kms.kategori.store');
    Route::get('/kms/kategori/{kategori}', [KategoriKmsController::class, 'show'])->name('kms.kategori.show');
    Route::get('/kms/kategori/{kategori}/edit', [KategoriKmsController::class, 'edit'])->name('kms.kategori.edit');
    Route::put('/kms/kategori/{kategori}', [KategoriKmsController::class, 'update'])->name('kms.kategori.update');
    Route::delete('/kms/kategori/{kategori}', [KategoriKmsController::class, 'destroy'])->name('kms.kategori.destroy');

    // ---------- KMS: Subkategori ----------
    Route::get('/kms/kategori/{kategori}/subkategori/tambah', [SubkategoriKmsController::class, 'create'])->name('kms.subkategori.create');
    Route::post('/kms/kategori/{kategori}/subkategori', [SubkategoriKmsController::class, 'store'])->name('kms.subkategori.store');
    Route::get('/kms/subkategori/{subkategori}', [SubkategoriKmsController::class, 'show'])->name('kms.subkategori.show');
    Route::get('/kms/subkategori/{subkategori}/edit', [SubkategoriKmsController::class, 'edit'])->name('kms.subkategori.edit');
    Route::put('/kms/subkategori/{subkategori}', [SubkategoriKmsController::class, 'update'])->name('kms.subkategori.update');
    Route::delete('/kms/subkategori/{subkategori}', [SubkategoriKmsController::class, 'destroy'])->name('kms.subkategori.destroy');

    // ---------- KMS: Grup Dokumen ----------
    Route::get('/kms/subkategori/{subkategori}/grup/tambah', [GrupDokumenController::class, 'create'])->name('kms.grup.create');
    Route::post('/kms/subkategori/{subkategori}/grup', [GrupDokumenController::class, 'store'])->name('kms.grup.store');
    Route::get('/kms/grup/{grup}', [GrupDokumenController::class, 'show'])->name('kms.grup.show');
    Route::get('/kms/grup/{grup}/edit', [GrupDokumenController::class, 'edit'])->name('kms.grup.edit');
    Route::put('/kms/grup/{grup}', [GrupDokumenController::class, 'update'])->name('kms.grup.update');
    Route::delete('/kms/grup/{grup}', [GrupDokumenController::class, 'destroy'])->name('kms.grup.destroy');

    // ---------- KMS: Dokumen ----------
    Route::get('/kms/subkategori/{subkategori}/dokumen/tambah', [DokumenController::class, 'create'])->name('kms.dokumen.create');
    Route::post('/kms/dokumen', [DokumenController::class, 'store'])->name('kms.dokumen.store');
    Route::get('/kms/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])->name('kms.dokumen.edit');
    Route::put('/kms/dokumen/{dokumen}', [DokumenController::class, 'update'])->name('kms.dokumen.update');
    Route::delete('/kms/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('kms.dokumen.destroy');

    // ---------- Pedoman: Kategori ----------
    Route::get('/pedoman/kategori/tambah', [PedomanKategoriController::class, 'create'])->name('pedoman.kategori.create');
    Route::post('/pedoman/kategori', [PedomanKategoriController::class, 'store'])->name('pedoman.kategori.store');
    Route::get('/pedoman/kategori/{kategori}/edit', [PedomanKategoriController::class, 'edit'])->name('pedoman.kategori.edit');
    Route::put('/pedoman/kategori/{kategori}', [PedomanKategoriController::class, 'update'])->name('pedoman.kategori.update');
    Route::delete('/pedoman/kategori/{kategori}', [PedomanKategoriController::class, 'destroy'])->name('pedoman.kategori.destroy');

    // ---------- Pedoman: Dokumen ----------
    Route::get('/pedoman/dokumen/tambah', [PedomanDokumenController::class, 'create'])->name('pedoman.dokumen.create');
    Route::post('/pedoman/dokumen', [PedomanDokumenController::class, 'store'])->name('pedoman.dokumen.store');
    Route::get('/pedoman/dokumen/{dokumen}/edit', [PedomanDokumenController::class, 'edit'])->name('pedoman.dokumen.edit');
    Route::put('/pedoman/dokumen/{dokumen}', [PedomanDokumenController::class, 'update'])->name('pedoman.dokumen.update');
    Route::delete('/pedoman/dokumen/{dokumen}', [PedomanDokumenController::class, 'destroy'])->name('pedoman.dokumen.destroy');

});
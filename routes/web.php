<?php

use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
*/

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

// ---------- Knowledge Base & Pedoman ----------
Route::get('/knowledge-base', [KmsController::class, 'index'])->name('kms.index');
Route::get('/knowledge-base/{slug}', [KmsController::class, 'kategori'])->name('kms.kategori');

Route::get('/pedoman', [PedomanController::class, 'index'])->name('pedoman.index');
Route::get('/pedoman/{slug}', [PedomanController::class, 'kategori'])->name('pedoman.kategori');
Route::get('/pedoman/{slug}/{id}', [PedomanController::class, 'detail'])->name('pedoman.detail');

// ==========================================================
// BULETIN PUBLIK
// ==========================================================
$editions = [
    'edisi-01-2026' => [
        'label' => 'EDISI 01 · TRIWULAN I 2026',
        'title' => 'Evaluasi SAKIP',
        'intro' => 'Edisi ini mengajak pembaca melihat lebih dekat bagaimana proses reviu berjalan sebelum anggaran direalisasikan.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Reviu Sebelum Realisasi'],
            ['no' => '06', 't' => 'Sorotan — Capaian Tindak Lanjut Triwulan I'],
            ['no' => '08', 't' => 'Wawancara — Menjaga Independensi Auditor'],
            ['no' => '10', 't' => 'Ruang Publik — Cara Mengajukan Pengaduan'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Reviu Sebelum Realisasi',
        'art_p1' => 'Sebagian besar temuan pemeriksaan sebenarnya bisa dicegah sejak dokumen perencanaan disusun.',
        'art_pull' => '"Koreksi di atas kertas jauh lebih murah dibanding koreksi setelah anggaran cair."',
        'art_p2' => 'Sepanjang triwulan pertama, puluhan dokumen rencana kerja telah melalui proses reviu.',
        'stats_title' => 'Capaian Triwulan I',
        'stats' => [
            ['label' => 'Selesai Tuntas', 'value' => 78, 'color' => 'brass'],
            ['label' => 'Verifikasi', 'value' => 14, 'color' => 'brass'],
            ['label' => 'Belum Ditindak', 'value' => 8, 'color' => 'rust'],
        ],
        'stats_note' => 'Dari 96 rekomendasi triwulan sebelumnya, mayoritas telah tuntas usai verifikasi lapangan.',
        'iv_title' => 'Menjaga Independensi',
        'iv_q' => 'Apa tantangan terbesar dalam reviu di awal tahun anggaran?',
        'iv_a' => 'Waktunya sempit — unit kerja sering mengajukan dokumen mepet deadline.',
        'iv_who' => 'Tim Reviu Perencanaan, Inspektorat',
    ],
];

Route::get('/buletin', function () use ($editions) {
    return view('buletin.index', ['editions' => $editions]);
})->name('buletin.index');

Route::get('/buletin/{slug}', function ($slug) use ($editions) {
    $current = $editions[$slug] ?? $editions['edisi-01-2026'];
    return view('buletin.show', [
        'current' => $current,
        'totalPages' => 8,
        'slug' => $slug,
    ]);
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
});
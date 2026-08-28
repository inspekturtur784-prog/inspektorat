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
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesanController as AdminPesanController;
use App\Http\Controllers\Admin\TugasFungsiController;
use App\Http\Controllers\Admin\StrukturBagianController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\PasswordController as AdminPasswordController;
use App\Http\Controllers\BeritaController;

/*
|--------------------------------------------------------------------------
| Web Routes — Inspektorat Kota Mojokerto
|--------------------------------------------------------------------------
*/

// ---------- Beranda ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pengaduan', function () {
    return view('pengaduan');
})->name('pengaduan');

// ---------- Profil ----------
Route::redirect('/profile', '/profil', 301);

Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/struktur/{struktur}', [StrukturController::class, 'show'])->name('struktur.show');
Route::get('/profil/data-pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/profil/data-pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');

// Galeri Publik
Route::get('/profil/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/profil/galeri/{slug}', [GaleriController::class, 'show'])->name('galeri.show');

// ---------- Layanan ----------
Route::redirect('/layanan', '/#layanan');
Route::view('/layanan/konsultansi', 'coming-soon', ['title' => 'Konsultansi Online']);
Route::view('/layanan/kms', 'coming-soon', ['title' => 'KMS / Pedoman']);
Route::redirect('/layanan/buletin', '/buletin', 301);
Route::view('/layanan/skm', 'coming-soon', ['title' => 'SKM Inspektorat']);

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/kontak', [KontakController::class, 'show'])->name('kontak.show');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// ---------- Artikel (publik) ----------
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// ---------- Buletin ----------
$editions = [

    'edisi-01-2026' => [
        'label' => 'EDISI 01 · TRIWULAN I 2026',
        'title' => 'Reviu Sebelum Realisasi',
        'intro' => 'Edisi ini mengajak pembaca melihat lebih dekat bagaimana proses reviu berjalan sebelum anggaran direalisasikan — langkah kecil yang berdampak besar pada kualitas belanja pemerintah.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Reviu Sebelum Realisasi'],
            ['no' => '06', 't' => 'Sorotan — Capaian Tindak Lanjut Triwulan I'],
            ['no' => '08', 't' => 'Wawancara — Menjaga Independensi Auditor'],
            ['no' => '10', 't' => 'Ruang Publik — Cara Mengajukan Pengaduan'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Reviu Sebelum Realisasi',
        'art_p1' => 'Sebagian besar temuan pemeriksaan sebenarnya bisa dicegah sejak dokumen perencanaan disusun. Inspektorat mendorong setiap unit kerja mengajukan reviu sebelum anggaran direalisasikan, bukan menunggu audit di akhir tahun.',
        'art_pull' => '"Koreksi di atas kertas jauh lebih murah dibanding koreksi setelah anggaran cair."',
        'art_p2' => 'Sepanjang triwulan pertama, puluhan dokumen rencana kerja telah melalui proses reviu — sebagian besar catatannya ringan dan cepat ditindaklanjuti.',
        'stats_title' => 'Capaian Triwulan I',
        'stats' => [
            ['label' => 'Selesai Tuntas', 'value' => 78, 'color' => 'brass'],
            ['label' => 'Verifikasi', 'value' => 14, 'color' => 'brass'],
            ['label' => 'Belum Ditindak', 'value' => 8, 'color' => 'rust'],
        ],
        'stats_note' => 'Dari 96 rekomendasi triwulan sebelumnya, mayoritas telah tuntas usai verifikasi lapangan.',
        'iv_title' => 'Menjaga Independensi',
        'iv_q' => 'Apa tantangan terbesar dalam reviu di awal tahun anggaran?',
        'iv_a' => 'Waktunya sempit — unit kerja sering mengajukan dokumen mepet deadline, padahal reviu butuh waktu untuk ditelaah dengan cermat.',
        'iv_who' => 'Tim Reviu Perencanaan, Inspektorat',
    ],

    'edisi-24-2025' => [
        'label' => 'EDISI 24 · 2025',
        'title' => 'Tata Garis Tegak Batas Pengawasan',
        'intro' => 'Sejauh mana sebuah kesalahan administratif berubah menjadi penyimpangan yang harus ditindak? Edisi ini menelusuri batas itu lewat lima studi kasus dari daerah berbeda.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Menarik Garis Batas'],
            ['no' => '07', 't' => 'Sorotan — Lima Studi Kasus Daerah'],
            ['no' => '09', 't' => 'Wawancara — Auditor Senior Bicara'],
            ['no' => '11', 't' => 'Ruang Publik — Hak Jawab Terperiksa'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Menarik Garis Batas',
        'art_p1' => 'Tidak semua selisih angka berarti korupsi, dan tidak semua kesalahan kecil bisa dianggap wajar. Inspektorat menyusun kriteria yang lebih tegas untuk membedakan kelalaian administratif dari dugaan penyimpangan.',
        'art_pull' => '"Batasnya bukan besar-kecilnya angka, tapi ada-tidaknya niat dan pola yang berulang."',
        'art_p2' => 'Lima studi kasus dalam edisi ini menunjukkan bagaimana tim pemeriksa menimbang unsur kesengajaan sebelum menjatuhkan rekomendasi sanksi.',
        'stats_title' => 'Klasifikasi Temuan 2025',
        'stats' => [
            ['label' => 'Administratif', 'value' => 64, 'color' => 'brass'],
            ['label' => 'Perlu Perbaikan', 'value' => 27, 'color' => 'brass'],
            ['label' => 'Dugaan Pidana', 'value' => 9, 'color' => 'rust'],
        ],
        'stats_note' => 'Kasus yang mengarah ke dugaan pidana diteruskan ke aparat penegak hukum sesuai prosedur.',
        'iv_title' => 'Auditor Senior Bicara',
        'iv_q' => 'Bagaimana cara memutuskan sebuah temuan itu administratif atau bukan?',
        'iv_a' => 'Kami lihat polanya — kalau terjadi berulang dan ada upaya menyembunyikan, itu sudah beda kelas dari sekadar salah catat.',
        'iv_who' => 'Auditor Madya, Tim Pemeriksa Khusus',
    ],

    'edisi-23-2025' => [
        'label' => 'EDISI 23 · 2025',
        'title' => 'Integritas di Balik Angka',
        'intro' => 'Laporan keuangan yang rapi belum tentu mencerminkan praktik yang bersih. Edisi ini membedah bagaimana integritas diuji jauh sebelum angka itu sampai ke meja auditor.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Angka yang Jujur'],
            ['no' => '06', 't' => 'Sorotan — Deteksi Dini Anomali'],
            ['no' => '08', 't' => 'Wawancara — Bendahara yang Taat'],
            ['no' => '10', 't' => 'Ruang Publik — Membaca Laporan Keuangan Daerah'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Angka yang Jujur',
        'art_p1' => 'Laporan keuangan hanyalah representasi akhir dari ratusan keputusan kecil yang diambil sepanjang tahun anggaran. Ketika satu keputusan kecil menyimpang, hasil akhirnya tetap bisa terlihat rapi di atas kertas.',
        'art_pull' => '"Angka yang rapi bisa menyembunyikan proses yang berantakan."',
        'art_p2' => 'Karena itu, pemeriksaan tidak berhenti di dokumen akhir, tapi menelusuri jejak keputusan di baliknya — dari usulan, persetujuan, hingga pencairan.',
        'stats_title' => 'Anomali Terdeteksi 2025',
        'stats' => [
            ['label' => 'Terdeteksi Dini', 'value' => 71, 'color' => 'brass'],
            ['label' => 'Ditemukan Saat Audit', 'value' => 23, 'color' => 'brass'],
            ['label' => 'Laporan Masyarakat', 'value' => 6, 'color' => 'rust'],
        ],
        'stats_note' => 'Sistem deteksi dini membantu menangkap anomali sebelum berkembang jadi temuan besar.',
        'iv_title' => 'Bendahara yang Taat',
        'iv_q' => 'Apa yang bikin bendahara unit kerja patuh pada aturan, bukan sekadar takut diperiksa?',
        'iv_a' => 'Kalau paham kenapa aturan itu ada, kepatuhan jadi kebiasaan, bukan beban. Itu yang kami coba bangun lewat pendampingan rutin.',
        'iv_who' => 'Bendahara Pengeluaran, Unit Kerja Percontohan',
    ],

    'edisi-22-2025' => [
        'label' => 'EDISI 22 · 2025',
        'title' => 'Reviu Sebagai Rem Awal',
        'intro' => 'Sebelum masalah membesar, ada satu tahap yang sering dilewatkan: reviu awal. Edisi ini mengangkat kenapa tahap ini layak disebut "rem" pertama dalam sistem pengawasan.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Rem yang Sering Dilewatkan'],
            ['no' => '06', 't' => 'Sorotan — Perbandingan Biaya Koreksi'],
            ['no' => '08', 't' => 'Wawancara — Kepala Unit Kerja Bercerita'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Rem yang Sering Dilewatkan',
        'art_p1' => 'Banyak unit kerja menganggap reviu sebagai formalitas administratif yang menghambat kecepatan realisasi anggaran. Padahal, di sinilah kesalahan paling sering dan paling murah untuk dikoreksi.',
        'art_pull' => '"Reviu bukan menghambat, dia mengerem sebelum arahnya salah."',
        'art_p2' => 'Perbandingan biaya menunjukkan koreksi pasca-realisasi bisa memakan waktu dan sumber daya jauh lebih besar dibanding koreksi di tahap perencanaan.',
        'stats_title' => 'Perbandingan Biaya Koreksi',
        'stats' => [
            ['label' => 'Koreksi di Reviu', 'value' => 12, 'color' => 'brass'],
            ['label' => 'Koreksi Pasca-Realisasi', 'value' => 88, 'color' => 'rust'],
        ],
        'stats_note' => 'Angka dalam skala relatif — koreksi setelah anggaran cair butuh proses jauh lebih panjang.',
        'iv_title' => 'Kepala Unit Kerja Bercerita',
        'iv_q' => 'Awalnya sempat menganggap reviu sebagai hambatan?',
        'iv_a' => 'Jujur, iya. Tapi setelah dokumen kami tertahan di reviu dan ternyata memang ada yang keliru, saya baru sadar itu menyelamatkan kami dari masalah lebih besar.',
        'iv_who' => 'Kepala Unit Kerja, Pemohon Reviu',
    ],

    'edisi-21-2025' => [
        'label' => 'EDISI 21 · 2025',
        'title' => 'Jejak Tindak Lanjut',
        'intro' => 'Rekomendasi hasil pemeriksaan bukan akhir cerita — ia baru permulaan. Edisi ini menelusuri ke mana saja rekomendasi itu berjalan setelah laporan diserahkan.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Setelah Laporan Diserahkan'],
            ['no' => '06', 't' => 'Sorotan — Peta Status Tindak Lanjut'],
            ['no' => '08', 't' => 'Wawancara — Tim Pemantau Bertugas'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Setelah Laporan Diserahkan',
        'art_p1' => 'Sebuah rekomendasi hasil pemeriksaan hanya bernilai jika benar-benar dijalankan. Tim pemantauan bertugas mengawal setiap rekomendasi — dari yang selesai dalam hitungan minggu, hingga yang butuh waktu bertahun-tahun.',
        'art_pull' => '"Laporan yang bagus tanpa tindak lanjut, hanya jadi arsip."',
        'art_p2' => 'Setiap status tindak lanjut diverifikasi ulang di lapangan sebelum dinyatakan tuntas — bukan sekadar berdasarkan laporan tertulis dari unit kerja.',
        'stats_title' => 'Status Tindak Lanjut 2025',
        'stats' => [
            ['label' => 'Tuntas Terverifikasi', 'value' => 81, 'color' => 'brass'],
            ['label' => 'Dalam Proses', 'value' => 15, 'color' => 'brass'],
            ['label' => 'Mangkrak', 'value' => 4, 'color' => 'rust'],
        ],
        'stats_note' => 'Rekomendasi berstatus mangkrak dieskalasi ke pimpinan unit kerja terkait.',
        'iv_title' => 'Tim Pemantau Bertugas',
        'iv_q' => 'Bagaimana memastikan status "selesai" itu benar-benar selesai?',
        'iv_a' => 'Kami turun langsung, cek fisik atau dokumen buktinya. Kalau cuma laporan di atas kertas, itu belum cukup buat kami tutup statusnya.',
        'iv_who' => 'Tim Pemantauan Tindak Lanjut',
    ],

    'edisi-20-2025' => [
        'label' => 'EDISI 20 · 2025',
        'title' => 'Menjaga Independensi Auditor',
        'intro' => 'Independensi bukan sekadar aturan di atas kertas — ia diuji setiap hari, terutama saat objek pemeriksaan adalah rekan kerja sendiri. Edisi ini membahas bagaimana batas itu dijaga.',
        'toc' => [
            ['no' => '03', 't' => 'Dari Redaksi'],
            ['no' => '04', 't' => 'Laporan Utama — Menjaga Jarak'],
            ['no' => '06', 't' => 'Sorotan — Kode Etik dalam Praktik'],
            ['no' => '08', 't' => 'Wawancara — Menjaga Independensi'],
        ],
        'art_kicker' => 'Laporan Utama',
        'art_title' => 'Menjaga Jarak',
        'art_p1' => 'Tantangan terbesar independensi bukan datang dari luar, tapi dari kedekatan sehari-hari dengan pihak yang diperiksa. Inspektorat menerapkan rotasi penugasan dan mekanisme deklarasi konflik kepentingan untuk menjaga jarak itu.',
        'art_pull' => '"Independensi paling sering diuji oleh kedekatan, bukan tekanan."',
        'art_p2' => 'Setiap auditor wajib mengisi deklarasi konflik kepentingan sebelum penugasan — langkah kecil yang menjaga integritas hasil pemeriksaan.',
        'stats_title' => 'Deklarasi Konflik Kepentingan',
        'stats' => [
            ['label' => 'Tidak Ada Konflik', 'value' => 92, 'color' => 'brass'],
            ['label' => 'Dialihkan Penugasan', 'value' => 8, 'color' => 'rust'],
        ],
        'stats_note' => 'Auditor yang menyatakan ada potensi konflik langsung dialihkan ke tim lain.',
        'iv_title' => 'Menjaga Independensi',
        'iv_q' => 'Apa tantangan terbesar menjaga independensi di tengah tekanan?',
        'iv_a' => 'Bukan soal aturan, tapi soal keberanian menjaga jarak — termasuk dari pihak yang justru paling dekat dengan kita sehari-hari di kantor.',
        'iv_who' => 'Tim Pemeriksa Inspektorat',
    ],

];

Route::get('/buletin', function () use ($editions) {
    return view('buletin.index', [
        'editions' => $editions,
    ]);
})->name('buletin.index');

Route::get('/buletin/{slug}', function ($slug) use ($editions) {
    $current = $editions[$slug] ?? $editions['edisi-01-2026'];

    return view('buletin.show', [
        'current' => $current,
        'totalPages' => 8,
    ]);
})->name('buletin.show');

// Redirect login bawaan Laravel
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// ---------- Admin: Login / Logout ----------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit')->middleware('guest');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// ---------- Admin: WAJIB LOGIN ----------
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/pesan', [AdminPesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [AdminPesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [AdminPesanController::class, 'destroy'])->name('pesan.destroy');

    Route::get('/ganti-password', [AdminPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::get('/pengaturan', [PengaturanProfilController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [PengaturanProfilController::class, 'update'])->name('pengaturan.update');

    Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugasfungsi.index');
    Route::get('/tugas-fungsi/tambah', [TugasFungsiController::class, 'create'])->name('tugasfungsi.create');
    Route::post('/tugas-fungsi', [TugasFungsiController::class, 'store'])->name('tugasfungsi.store');
    Route::get('/tugas-fungsi/{tugasFungsi}/edit', [TugasFungsiController::class, 'edit'])->name('tugasfungsi.edit');
    Route::put('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'update'])->name('tugasfungsi.update');
    Route::delete('/tugas-fungsi/{tugasFungsi}', [TugasFungsiController::class, 'destroy'])->name('tugasfungsi.destroy');

    Route::get('/struktur', [StrukturBagianController::class, 'index'])->name('struktur.index');
    Route::get('/struktur/tambah', [StrukturBagianController::class, 'create'])->name('struktur.create');
    Route::post('/struktur', [StrukturBagianController::class, 'store'])->name('struktur.store');
    Route::get('/struktur/{struktur}/edit', [StrukturBagianController::class, 'edit'])->name('struktur.edit');
    Route::put('/struktur/{struktur}', [StrukturBagianController::class, 'update'])->name('struktur.update');
    Route::delete('/struktur/{struktur}', [StrukturBagianController::class, 'destroy'])->name('struktur.destroy');

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
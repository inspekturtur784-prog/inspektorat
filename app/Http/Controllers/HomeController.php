<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Galeri;
use App\Models\ProfilHighlight;
use App\Models\PengaturanProfil;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Beranda Inspektorat Kota Mojokerto.
     */
    public function index()
    {
        // 1. Ambil artikel dipublikasi (dengan fallback jika Model Article belum siap)
        $articles = class_exists('\App\Models\Article') 
            ? Article::published()->limit(3)->get() 
            : collect();

        // 2. Ambil data Pengaturan Profil
        $p = class_exists('\App\Models\PengaturanProfil') 
            ? PengaturanProfil::semua() 
            : null;

        // Fallback data RINGKAS khusus untuk Beranda (Teaser)
        if (!$p) {
            $p = [
                'kedudukan' => 'Unsur pengawas penyelenggaraan pemerintahan daerah yang dipimpin oleh Inspektur dan bertanggung jawab langsung kepada Wali Kota.',
                'peran'     => 'Mitra strategis perangkat daerah sebagai APIP dalam mendorong tata kelola yang taat aturan.',
                'tujuan'    => 'Mewujudkan penyelenggaraan pemerintahan Kota Mojokerto yang bersih, akuntabel, dan transparan.',
                'fungsi'    => 'Melaksanakan perumusan kebijakan teknis, audit, reviu, evaluasi, serta pemantauan pengawasan internal.'
            ];
        }

        // 3. Statistik singkat
        $stats = [
            'artikel'   => class_exists('\App\Models\Article') ? Article::published()->count() : 0,
            'pedoman'   => 12,
            'layanan'   => 4,
            'publikasi' => 8,
        ];

        // 4. Ambil 6 foto galeri terbaru (dengan fallback jika Model Galeri belum siap)
        $galeries = class_exists('\App\Models\Galeri')
            ? Galeri::terbaru()->limit(6)->get()
            : collect();

        // 5. Kartu "Mengenal Kami" (Kedudukan, Peran, dll) — dikelola bebas lewat Admin
        $highlights = class_exists('\App\Models\ProfilHighlight')
            ? ProfilHighlight::urut()->get()
            : collect();

        return view('home', compact('articles', 'stats', 'p', 'galeries', 'highlights'));
    }
}
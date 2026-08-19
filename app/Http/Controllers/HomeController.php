<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Beranda Inspektorat Kota Mojokerto.
     *
     * Section yang dirender di view home.blade.php:
     * - Hero / Banner
     * - Apa Itu Inspektorat (Pengertian, Peran, Fungsi, Tujuan)
     * - Layanan Utama
     * - Artikel / Informasi Terbaru (CRUD dari Admin, lihat App\Http\Controllers\Admin\ArticleController)
     * - Statistik singkat (opsional)
     */
    public function index()
    {
        $articles = Article::published()->limit(3)->get();

        // Statistik: Jumlah Artikel sudah dari data asli (tabel articles).
        // Pedoman / Layanan / Publikasi masih placeholder — tinggal ganti
        // dengan Model::count() masing-masing begitu modulnya dibuat.
        $stats = [
            'artikel'   => Article::published()->count(),
            'pedoman'   => 12,
            'layanan'   => 4,
            'publikasi' => 8,
        ];

        return view('home', compact('articles', 'stats'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Article;

class BeritaController extends Controller
{
    /** Halaman /berita — arsip semua artikel (beda dari Beranda yang cuma nampilin 3 terbaru). */
    public function index()
    {
        $articles = Article::published()->paginate(9);

        return view('berita', compact('articles'));
    }
}
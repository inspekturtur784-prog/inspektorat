<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Buletin;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('q'));

        if (!$keyword) {
            return redirect()->back();
        }

        // Cari di Berita/Artikel (Hanya menggunakan 'title' agar tidak error jika nama kolom isi berbeda)
        $articles = Article::where('title', 'like', "%{$keyword}%")
            ->latest()
            ->get();

        // Cari di Buletin
        $buletins = Buletin::where('judul', 'like', "%{$keyword}%")
            ->orWhere('deskripsi', 'like', "%{$keyword}%")
            ->latest()
            ->get();

        return view('search.index', compact('keyword', 'articles', 'buletins'));
    }
}
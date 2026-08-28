<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /** Halaman /profil/galeri — bisa difilter ?kategori=Kegiatan dst. */
    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori');

        $items = Galeri::kategori($kategoriAktif)->terbaru()->get();

        // Kategori diambil dari data yang benar-benar ada di database
        $kategoriList = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('galeri', [
            'items'         => $items,
            'kategoriList'  => $kategoriList,
            'kategoriAktif' => $kategoriAktif,
        ]);
    }

    /** Halaman detail satu foto: /profil/galeri/{slug} */
    public function show(string $slug)
    {
        $galeri = Galeri::where('slug', $slug)->firstOrFail();

        $related = Galeri::where('kategori', $galeri->kategori)
            ->where('id', '!=', $galeri->id)
            ->terbaru()
            ->limit(4)
            ->get();

        return view('galeri-detail', compact('galeri', 'related'));
    }
}
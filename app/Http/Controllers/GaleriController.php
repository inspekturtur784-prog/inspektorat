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

        $items = Galeri::kategori($kategoriAktif)->terbaru()->paginate(12)->withQueryString();

        return view('galeri', [
            'items' => $items,
            'kategoriList' => Galeri::KATEGORI,
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
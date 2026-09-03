<?php

namespace App\Http\Controllers;

use App\Models\PedomanKategori;
use App\Models\PedomanDokumen;
use Illuminate\Http\Request;

class PedomanController extends Controller
{
    // Halaman utama Pedoman (daftar semua kategori + search lintas kategori)
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $kategoris = PedomanKategori::withCount('dokumens')->get();

        $dokumens = null;
        if ($keyword) {
            $dokumens = PedomanDokumen::where('judul', 'like', "%{$keyword}%")
                ->with('kategori')
                ->get();
        }

        return view('pedoman.index', compact('kategoris', 'dokumens', 'keyword'));
    }

    // Halaman daftar dokumen per kategori (dengan search & sort)
    public function kategori(Request $request, $slug)
    {
        $kategori = PedomanKategori::where('slug', $slug)->firstOrFail();

        $query = PedomanDokumen::where('pedoman_kategori_id', $kategori->id);

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $dokumens = $query->get();

        return view('pedoman.kategori', compact('kategori', 'dokumens'));
    }

    // Halaman detail dokumen + PDF/video viewer
    public function detail($slug, $id)
    {
        $dokumen = PedomanDokumen::findOrFail($id);
        $dokumen->increment('downloads');

        return view('pedoman.detail', compact('dokumen'));
    }
}
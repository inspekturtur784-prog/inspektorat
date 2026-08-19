<?php

namespace App\Http\Controllers;

use App\Models\PedomanKategori;
use App\Models\PedomanDokumen;
use Illuminate\Http\Request;

class PedomanController extends Controller
{
    // Halaman utama Pedoman (daftar semua kategori)
    public function index()
    {
        $kategoris = PedomanKategori::withCount('dokumens')->get();
        return view('pedoman.index', compact('kategoris'));
    }

    // Halaman daftar dokumen per kategori (dengan search & sort)
    public function kategori(Request $request, $slug)
    {
        $kategori = PedomanKategori::where('slug', $slug)->firstOrFail();

        $query = PedomanDokumen::where('pedoman_kategori_id', $kategori->id);

        // Fitur search
        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        // Fitur sort
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $dokumens = $query->get();

        return view('pedoman.kategori', compact('kategori', 'dokumens'));
    }

    // Halaman detail dokumen + PDF viewer
    public function detail($slug, $id)
    {
        $dokumen = PedomanDokumen::findOrFail($id);
        $dokumen->increment('downloads'); // hitung setiap kali dibuka

        return view('pedoman.detail', compact('dokumen'));
    }
}
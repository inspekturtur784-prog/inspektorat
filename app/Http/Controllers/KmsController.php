<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class KmsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $kategoris = Kategori::withCount('dokumens')->get();

        $dokumens = null;
        if ($keyword) {
            $dokumens = Dokumen::where('judul', 'like', "%{$keyword}%")
                ->with('kategori')
                ->get();
        }

        return view('kms.index', compact('kategoris', 'dokumens', 'keyword'));
    }

    public function kategori($slug)
    {
        $kategori = Kategori::where('slug', $slug)
            ->with(['subkategoris.grupDokumens.dokumens', 'subkategoris.dokumensLangsung'])
            ->firstOrFail();

        return view('kms.kategori', compact('kategori'));
    }
}
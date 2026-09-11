<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\GrupDokumen;
use App\Models\Dokumen;
use App\Models\PedomanKategori;
use App\Models\PedomanDokumen;

class KmsPedomanDashboardController extends Controller
{
    public function index()
    {
        // KMS
        $kmsKategoris = Kategori::orderBy('nama')->get();
        $kmsSubkategoris = Subkategori::with('kategori')->orderBy('nama')->get();
        $kmsGrups = GrupDokumen::with('subkategori.kategori')->orderBy('nama')->get();
        $kmsDokumens = Dokumen::with(['kategori', 'subkategori', 'grupDokumen'])->orderByDesc('created_at')->get();

        // Pedoman
        $pedomanKategoris = PedomanKategori::orderBy('nama')->get();
        $pedomanDokumens = PedomanDokumen::with('kategori')->orderByDesc('created_at')->get();

        return view('admin.kms-pedoman.index', compact(
            'kmsKategoris', 'kmsSubkategoris', 'kmsGrups', 'kmsDokumens',
            'pedomanKategoris', 'pedomanDokumens'
        ));
    }
}

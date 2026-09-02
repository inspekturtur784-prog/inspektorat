<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Pegawai;
use App\Models\Galeri;
use App\Models\StrukturBagian;
use App\Models\TugasFungsi;
use App\Models\Pesan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'artikel'   => Article::count(),
            'pegawai'   => Pegawai::count(),
            'galeri'    => Galeri::count(),
            'struktur'  => StrukturBagian::count(),
            'fungsi'    => TugasFungsi::count(),
            'pesan'     => Pesan::where('is_read', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
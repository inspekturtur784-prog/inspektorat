<?php

namespace App\Http\Controllers;

use App\Models\PengaturanProfil;
use App\Models\TugasFungsi;
use App\Models\StrukturBagian;
use App\Models\Pegawai;

class ProfilController extends Controller
{
    /**
     * Halaman Profil (Section A-D) — semua kontennya sekarang diambil
     * dari database lewat panel Admin, tidak ada lagi yang hardcode
     * di file blade.
     */
    public function index()
    {
        $p = PengaturanProfil::semua();
        $misiList = isset($p['misi']) ? preg_split('/\r\n|\r|\n/', trim($p['misi'])) : [];

        $tugasFungsiList = TugasFungsi::urut()->get();
        $strukturList = StrukturBagian::urut()->get();
        $pegawaiPerBidang = Pegawai::urut()->get()->groupBy('bidang');

        return view('profil', compact('p', 'misiList', 'tugasFungsiList', 'strukturList', 'pegawaiPerBidang'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;

class ProfilController extends Controller
{
    /**
     * Halaman Profil (Section A-D).
     * Section D (Struktur Organisasi) menampilkan nama pejabat asli
     * per bidang, diambil dari data Pegawai — supaya nggak perlu
     * di-update dobel kalau ada mutasi pegawai (cukup update di
     * halaman Data Pegawai / Admin, otomatis ikut di sini).
     */
    public function index()
    {
        $pegawaiPerBidang = Pegawai::urut()->get()->groupBy('bidang');

        return view('profil', compact('pegawaiPerBidang'));
    }
}
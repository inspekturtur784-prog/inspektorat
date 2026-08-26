<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /** Halaman /profil/data-pegawai — bisa dicari & difilter per bidang. */
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $bidangAktif = $request->query('bidang');

        $pegawais = Pegawai::urut()
            ->when($cari, fn($q) => $q->where('nama', 'like', "%{$cari}%"))
            ->when($bidangAktif, fn($q) => $q->where('bidang', $bidangAktif))
            ->get();

        // Daftar bidang unik untuk tab filter, urut sesuai kemunculan data (bukan alfabet).
        $bidangList = Pegawai::urut()->pluck('bidang')->filter()->unique()->values();

        return view('pegawai', [
            'pegawais' => $pegawais,
            'bidangList' => $bidangList,
            'bidangAktif' => $bidangAktif,
            'cari' => $cari,
        ]);
    }

    /** Halaman detail satu pegawai: /profil/data-pegawai/{pegawai} */
    public function show(Pegawai $pegawai)
    {
        return view('pegawai-detail', compact('pegawai'));
    }
}
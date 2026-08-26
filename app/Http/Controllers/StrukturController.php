<?php

namespace App\Http\Controllers;

use App\Models\StrukturBagian;
use App\Models\Pegawai;

class StrukturController extends Controller
{
    /**
     * Halaman detail 1 bagian struktur organisasi.
     * Menghubungkan: Bagian -> Jabatan -> Pegawai -> Tugas (masing-masing
     * pegawai punya tugas & fungsi sendiri, bukan cuma teks generik bagian).
     */
    public function show(StrukturBagian $struktur)
    {
        $pegawaiList = $struktur->bidang_key
            ? Pegawai::urut()->where('bidang', $struktur->bidang_key)->get()
            : collect();

        return view('struktur-detail', compact('struktur', 'pegawaiList'));
    }
}
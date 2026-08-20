<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;

class PegawaiController extends Controller
{
    /** Halaman publik /profil/data-pegawai */
    public function index()
    {
        $pegawais = Pegawai::urut()->get();
        return view('pegawai', compact('pegawais'));
    }
}
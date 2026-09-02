<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        return view('konsultasi.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_wa' => 'required|string|max:20',
        'instansi' => 'nullable|string|max:255',
        'kategori' => 'required|string',
        'pertanyaan' => 'required|string',
    ]);

    $konsultasi = Konsultasi::create([
        'nomor_tiket' => 'KNS-' . date('ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
        'nama' => $request->nama,
        'email' => $request->email,
        'no_wa' => $request->no_wa,
        'instansi' => $request->instansi,
        'kategori' => $request->kategori,
        'pertanyaan' => $request->pertanyaan,
        'status' => 'menunggu',
    ]);

    return view('konsultasi.sukses', [
        'konsultasi' => $konsultasi
    ]);
}
}
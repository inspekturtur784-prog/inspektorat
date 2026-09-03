<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /** Halaman /kontak — info kontak + form kirim pesan. */
    public function show()
    {
        return view('kontak');
    }

    /** Proses kirim pesan dari form. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:150',
            'email'   => 'required|email|max:150',
            'telepon' => 'nullable|string|max:30',
            'pesan'   => 'required|string|max:2000',
        ]);

        Pesan::create($data);

        return back()->with('status', 'Pesan Anda berhasil terkirim. Terima kasih, kami akan segera menghubungi Anda kembali.');
    }
}
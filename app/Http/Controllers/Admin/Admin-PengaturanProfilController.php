<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanProfil;
use Illuminate\Http\Request;

/**
 * Kelola konten "Tentang Inspektorat", "Visi & Misi", dan "Tugas Pokok"
 * dari Admin — tidak perlu ubah kode Laravel tiap kali informasinya berubah.
 */
class PengaturanProfilController extends Controller
{
    public function edit()
    {
        $p = PengaturanProfil::semua();

        return view('admin.pengaturan.edit', ['p' => $p]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tentang_intro'  => 'required|string',
            'kedudukan'      => 'required|string',
            'peran'          => 'required|string',
            'tujuan'         => 'required|string',
            'fungsi_singkat' => 'required|string',
            'visi'           => 'required|string',
            'misi'           => 'required|string', // satu poin per baris
            'tugas_pokok'    => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            PengaturanProfil::set($key, $value);
        }

        return redirect()->route('admin.pengaturan.edit')->with('status', 'Konten Tentang Inspektorat & Visi Misi berhasil disimpan.');
    }
}
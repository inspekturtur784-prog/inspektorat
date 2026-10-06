<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanProfil;
use App\Models\ProfilHighlight;
use Illuminate\Http\Request;

/**
 * Kelola konten "Tentang Inspektorat" dan "Visi & Misi" dari Admin.
 *
 * Catatan: kartu "Kedudukan, Peran, Tujuan, Fungsi" sudah TIDAK lagi
 * berupa field tetap di sini — sekarang jadi daftar kartu bebas
 * (tambah/edit/hapus) lewat ProfilHighlightController, ditampilkan
 * di halaman yang sama (admin.pengaturan.edit).
 */
class PengaturanProfilController extends Controller
{
    public function edit()
    {
        $p = PengaturanProfil::semua();
        $highlights = ProfilHighlight::urut()->get();

        return view('admin.pengaturan.edit', ['p' => $p, 'highlights' => $highlights]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tentang_intro' => 'required|string',
            'visi'          => 'required|string',
            'misi'          => 'required|string', // satu poin per baris
        ]);

        foreach ($data as $key => $value) {
            PengaturanProfil::set($key, $value);
        }

        return redirect()->route('admin.pengaturan.edit')->with('status', 'Konten Tentang Inspektorat & Visi Misi berhasil disimpan.');
    }
    // ===== Halaman terpisah: Tentang (Beranda) =====
    public function editTentang()
    {
        $p = PengaturanProfil::semua();
        return view('admin.pengaturan.tentang', ['p' => $p]);
    }

    public function updateTentang(Request $request)
    {
        $data = $request->validate([
            'tentang_intro' => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            PengaturanProfil::set($key, $value);
        }

        return redirect()->route('admin.pengaturan.tentang')->with('status', 'Paragraf Tentang Inspektorat berhasil disimpan.');
    }

    // ===== Halaman terpisah: Visi & Misi (Profil) =====
    public function editVisiMisi()
    {
        $p = PengaturanProfil::semua();
        return view('admin.pengaturan.visi-misi', ['p' => $p]);
    }

    public function updateVisiMisi(Request $request)
    {
        $data = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string', // satu poin per baris
        ]);

        foreach ($data as $key => $value) {
            PengaturanProfil::set($key, $value);
        }

        return redirect()->route('admin.pengaturan.visimisi')->with('status', 'Visi dan Misi berhasil disimpan.');
    }
}
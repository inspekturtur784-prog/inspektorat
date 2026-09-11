<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilHighlight;
use Illuminate\Http\Request;

/**
 * CRUD Kartu Profil (Kedudukan, Peran, dll).
 *
 * Tidak punya halaman index/create/edit sendiri lagi — semua
 * ditampilkan & dikelola langsung dari halaman
 * admin.pengaturan.edit ("Tentang Inspektorat & Visi Misi").
 * Controller ini cuma menangani proses simpan/hapusnya saja.
 */
class ProfilHighlightController extends Controller
{
    /** Simpan kartu baru. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'urutan'    => 'nullable|integer|min:0',
        ]);

        ProfilHighlight::create($data);

        return redirect()
            ->route('admin.pengaturan.edit')
            ->with('status', 'Kartu profil berhasil ditambahkan.');
    }

    /** Update kartu. */
    public function update(Request $request, ProfilHighlight $profilhighlight)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'urutan'    => 'nullable|integer|min:0',
        ]);

        $profilhighlight->update($data);

        return redirect()
            ->route('admin.pengaturan.edit')
            ->with('status', 'Kartu profil berhasil diperbarui.');
    }

    /** Hapus kartu. */
    public function destroy(ProfilHighlight $profilhighlight)
    {
        $profilhighlight->delete();

        return redirect()
            ->route('admin.pengaturan.edit')
            ->with('status', 'Kartu profil berhasil dihapus.');
    }
}
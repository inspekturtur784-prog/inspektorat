<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /** Tampilan Tabel Kelola Galeri di Admin */
    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        
        return view('admin.galeri.index', compact('galeris'));
    }

    /** Tampilan Form Tambah Galeri */
    public function create()
    {
        $existing = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->toArray();

        $defaults = ['Kegiatan', 'Sosialisasi', 'Rapat', 'Inspeksi', 'Edukasi'];
        $kategoriSaran = array_unique(array_merge($defaults, $existing));

        return view('admin.galeri.create', compact('kategoriSaran'));
    }

    /** Simpan Data Galeri Baru */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('galeri', 'public');
        }

        Galeri::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPath,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan');
    }

    /** Tampilan Form Edit Galeri */
    public function edit(Galeri $galeri)
    {
        $existing = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->toArray();

        $defaults = ['Kegiatan', 'Sosialisasi', 'Rapat', 'Inspeksi', 'Edukasi'];
        $kategoriSaran = array_unique(array_merge($defaults, $existing));

        return view('admin.galeri.edit', compact('galeri', 'kategoriSaran'));
    }

    /** Update Data Galeri */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }
            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui');
    }

    /** Hapus Data Galeri beserta Berkas Fotonya */
    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil dihapus');
    }
}
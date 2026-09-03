<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuletinController extends Controller
{
    /**
     * Menampilkan semua buletin
     */
    public function index()
    {
        $buletins = Buletin::latest()->get();

        return view('admin.buletin.index', compact('buletins'));
    }

    /**
     * Menampilkan form tambah buletin
     */
    public function create()
    {
        return view('admin.buletin.create');
    }

    /**
     * Menyimpan buletin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'tanggal' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ];

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('buletin', 'public');
        }

        Buletin::create($data);

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail buletin
     */
    public function show(Buletin $buletin)
    {
        return view('admin.buletin.show', compact('buletin'));
    }

    /**
     * Menampilkan form edit
     */
    public function edit(Buletin $buletin)
    {
        return view('admin.buletin.edit', compact('buletin'));
    }

    /**
     * Memperbarui buletin
     */
    public function update(Request $request, Buletin $buletin)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'tanggal' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($buletin->foto) {
                Storage::disk('public')->delete($buletin->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')
                ->store('buletin', 'public');
        }

        $buletin->update($data);

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil diperbarui.');
    }

    /**
     * Menghapus buletin
     */
    public function destroy(Buletin $buletin)
    {
        // Hapus file foto
        if ($buletin->foto) {
            Storage::disk('public')->delete($buletin->foto);
        }

        $buletin->delete();

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil dihapus.');
    }
}
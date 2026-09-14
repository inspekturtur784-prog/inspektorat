<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubkategoriKmsController extends Controller
{
    public function create(Kategori $kategori)
    {
        return view('kms.subkategori.create', compact('kategori'));
    }

    public function store(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $data['kategori_id'] = $kategori->id;
        $data['slug'] = Str::slug($data['nama']) . '-' . uniqid();

        Subkategori::create($data);

        return redirect()->route('admin.kms.kategori.show', $kategori)->with('status', 'Subkategori berhasil ditambahkan.');
    }

    public function show(Subkategori $subkategori)
    {
        $subkategori->load([
            'kategori',
            'grupDokumens' => fn ($q) => $q->withCount('dokumens'),
            'dokumensLangsung',
        ]);

        return view('kms.subkategori.show', compact('subkategori'));
    }

    public function edit(Subkategori $subkategori)
    {
        return view('kms.subkategori.edit', compact('subkategori'));
    }

    public function update(Request $request, Subkategori $subkategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $subkategori->update($data);

        return redirect()->route('admin.kms.kategori.show', $subkategori->kategori_id)->with('status', 'Subkategori berhasil diperbarui.');
    }

    public function destroy(Subkategori $subkategori)
    {
        $kategoriId = $subkategori->kategori_id;
        $subkategori->delete();
        return redirect()->route('admin.kms.kategori.show', $kategoriId)->with('status', 'Subkategori berhasil dihapus.');
    }
}

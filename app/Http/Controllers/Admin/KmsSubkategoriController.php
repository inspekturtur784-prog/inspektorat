<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KmsSubkategoriController extends Controller
{
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.kms-pedoman.kms.subkategori-form', ['subkategori' => null, 'kategoris' => $kategoris]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        Subkategori::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Subkategori KMS berhasil ditambahkan.');
    }

    public function edit(Subkategori $subkategori)
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.kms-pedoman.kms.subkategori-form', compact('subkategori', 'kategoris'));
    }

    public function update(Request $request, Subkategori $subkategori)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        $subkategori->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Subkategori KMS berhasil diperbarui.');
    }

    public function destroy(Subkategori $subkategori)
    {
        $subkategori->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Subkategori KMS berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
        ]);
    }
}

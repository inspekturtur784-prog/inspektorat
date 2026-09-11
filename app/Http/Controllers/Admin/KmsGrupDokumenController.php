<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrupDokumen;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KmsGrupDokumenController extends Controller
{
    public function create()
    {
        $subkategoris = Subkategori::with('kategori')->orderBy('nama')->get();
        return view('admin.kms-pedoman.kms.grup-form', ['grup' => null, 'subkategoris' => $subkategoris]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        GrupDokumen::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Grup dokumen KMS berhasil ditambahkan.');
    }

    public function edit(GrupDokumen $grup)
    {
        $subkategoris = Subkategori::with('kategori')->orderBy('nama')->get();
        return view('admin.kms-pedoman.kms.grup-form', compact('grup', 'subkategoris'));
    }

    public function update(Request $request, GrupDokumen $grup)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        $grup->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Grup dokumen KMS berhasil diperbarui.');
    }

    public function destroy(GrupDokumen $grup)
    {
        $grup->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Grup dokumen KMS berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'subkategori_id' => 'required|exists:subkategoris,id',
            'nama' => 'required|string|max:255',
        ]);
    }
}

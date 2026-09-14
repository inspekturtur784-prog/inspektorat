<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subkategori;
use App\Models\GrupDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GrupDokumenController extends Controller
{
    public function create(Subkategori $subkategori)
    {
        return view('kms.grup.create', compact('subkategori'));
    }

    public function store(Request $request, Subkategori $subkategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $data['subkategori_id'] = $subkategori->id;
        $data['slug'] = Str::slug($data['nama']) . '-' . uniqid();

        GrupDokumen::create($data);

        return redirect()->route('admin.kms.subkategori.show', $subkategori)->with('status', 'Grup dokumen berhasil ditambahkan.');
    }

    public function show(GrupDokumen $grup)
    {
        $grup->load(['subkategori', 'dokumens']);
        return view('kms.grup.show', compact('grup'));
    }

    public function edit(GrupDokumen $grup)
    {
        return view('kms.grup.edit', compact('grup'));
    }

    public function update(Request $request, GrupDokumen $grup)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $grup->update($data);

        return redirect()->route('admin.kms.subkategori.show', $grup->subkategori_id)->with('status', 'Grup dokumen berhasil diperbarui.');
    }

    public function destroy(GrupDokumen $grup)
    {
        $subkategoriId = $grup->subkategori_id;
        $grup->delete();
        return redirect()->route('admin.kms.subkategori.show', $subkategoriId)->with('status', 'Grup dokumen berhasil dihapus.');
    }
}

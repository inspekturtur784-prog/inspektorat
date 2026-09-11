<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KmsKategoriController extends Controller
{
    public function create()
    {
        return view('admin.kms-pedoman.kms.kategori-form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        Kategori::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori KMS berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kms-pedoman.kms.kategori-form', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        $kategori->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori KMS berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori KMS berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
        ]);
    }
}

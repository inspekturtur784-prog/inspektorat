<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedomanKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PedomanKategoriController extends Controller
{
    public function create()
    {
        return view('admin.kms-pedoman.pedoman.kategori-form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        PedomanKategori::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori Pedoman berhasil ditambahkan.');
    }

    public function edit(PedomanKategori $kategori)
    {
        return view('admin.kms-pedoman.pedoman.kategori-form', compact('kategori'));
    }

    public function update(Request $request, PedomanKategori $kategori)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);

        $kategori->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori Pedoman berhasil diperbarui.');
    }

    public function destroy(PedomanKategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori Pedoman berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
        ]);
    }
}

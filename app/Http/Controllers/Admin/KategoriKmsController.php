<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriKmsController extends Controller
{
public function index()
{
    $kategoris = Kategori::orderBy('nama')->get();
    return view('kms.kategori.index', compact('kategoris'));
}
    public function create()
    {
        return view('kms.kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $data['slug'] = $this->uniqueSlug($data['nama']);

        Kategori::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        $kategori->load(['subkategoris' => function ($q) {
            $q->withCount(['grupDokumens', 'dokumensLangsung']);
        }]);

        return view('kms.kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('kms.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        if ($data['nama'] !== $kategori->nama) {
            $data['slug'] = $this->uniqueSlug($data['nama'], $kategori->id);
        }

        $kategori->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kmspedoman.index')->with('status', 'Kategori berhasil dihapus.');
    }

    private function uniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $i = 1;

        while (Kategori::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}

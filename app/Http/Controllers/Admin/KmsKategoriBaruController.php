<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KmsKategoriBaruController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama' => $data['nama'],
            'slug' => Str::slug($data['nama']) . '-' . uniqid(),
        ]);

        $namaSub = trim($data['subkategori'] ?? '') !== '' ? trim($data['subkategori']) : 'Umum';

        Subkategori::create([
            'kategori_id' => $kategori->id,
            'nama'        => $namaSub,
            'slug'        => Str::slug($namaSub) . '-' . uniqid(),
        ]);

        return redirect()->route('admin.kms.index')->with('status', 'Kategori dan subkategori berhasil ditambahkan.');
    }
}
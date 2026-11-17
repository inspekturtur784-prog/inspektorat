<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KmsSubkategoriAksiController extends SubkategoriKmsController
{
    public function store(Request $request, Kategori $kategori)
    {
        parent::store($request, $kategori);
        return redirect()->route('admin.kms.index')->with('status', 'Subkategori berhasil ditambahkan.');
    }
}
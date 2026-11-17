<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subkategori;
use Illuminate\Http\Request;

class KmsSubkategoriUbahController extends SubkategoriKmsController
{
    public function update(Request $request, Subkategori $subkategori)
    {
        parent::update($request, $subkategori);
        return redirect()->route('admin.kms.index')->with('status', 'Subkategori berhasil diperbarui.');
    }

    public function destroy(Subkategori $subkategori)
    {
        parent::destroy($subkategori);
        return redirect()->route('admin.kms.index')->with('status', 'Subkategori berhasil dihapus.');
    }
}
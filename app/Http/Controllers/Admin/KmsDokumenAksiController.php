<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class KmsDokumenAksiController extends DokumenController
{
    public function store(Request $request)
    {
        parent::store($request);
        return redirect()->route('admin.kms.index')->with('status', 'Input data berhasil.');
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        parent::update($request, $dokumen);
        return redirect()->route('admin.kms.index')->with('status', 'Data berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        parent::destroy($dokumen);
        return redirect()->route('admin.kms.index')->with('status', 'Data berhasil dihapus.');
    }
}
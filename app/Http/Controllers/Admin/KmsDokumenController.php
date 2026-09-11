<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\GrupDokumen;
use Illuminate\Http\Request;

class KmsDokumenController extends Controller
{
    public function create()
    {
        return view('admin.kms-pedoman.kms.dokumen-form', [
            'dokumen' => null,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'subkategoris' => Subkategori::orderBy('nama')->get(),
            'grups' => GrupDokumen::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data = $this->handleUpload($request, $data);

        Dokumen::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen KMS berhasil ditambahkan.');
    }

    public function edit(Dokumen $dokumen)
    {
        return view('admin.kms-pedoman.kms.dokumen-form', [
            'dokumen' => $dokumen,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'subkategoris' => Subkategori::orderBy('nama')->get(),
            'grups' => GrupDokumen::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $this->validated($request, false);
        $data = $this->handleUpload($request, $data);

        $dokumen->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen KMS berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        $dokumen->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen KMS berhasil dihapus.');
    }

    private function validated(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'subkategori_id' => 'nullable|exists:subkategoris,id',
            'grup_dokumen_id' => 'nullable|exists:grup_dokumens,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => ($isCreate ? 'required' : 'nullable') . '|file|mimes:pdf|max:20480',
        ]);
    }

    private function handleUpload(Request $request, array $data): array
    {
        unset($data['file']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
            $file->move(public_path('kms-pdf'), $name);

            $data['file_path'] = 'kms-pdf/' . $name;
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        return $data;
    }
}

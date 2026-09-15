<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subkategori;
use App\Models\GrupDokumen;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function create(Request $request, Subkategori $subkategori)
    {
        $grup = null;
        if ($request->filled('grup')) {
            $grup = GrupDokumen::find($request->query('grup'));
        }

        return view('kms.dokumen.create', compact('subkategori', 'grup'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subkategori_id'   => 'required|exists:subkategoris,id',
            'grup_dokumen_id'  => 'nullable|exists:grup_dokumens,id',
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'file'             => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);

        $subkategori = Subkategori::findOrFail($data['subkategori_id']);

        $upload = $this->handleUpload($request);

        Dokumen::create([
            'kategori_id'      => $subkategori->kategori_id,
            'subkategori_id'   => $subkategori->id,
            'grup_dokumen_id'  => $data['grup_dokumen_id'] ?: null,
            'judul'            => $data['judul'],
            'deskripsi'        => $data['deskripsi'] ?? null,
            'file_path'        => $upload['file_path'],
            'file_type'        => $upload['file_type'],
        ]);

        return redirect()->route('admin.kms.subkategori.show', $subkategori)->with('status', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Dokumen $dokumen)
    {
        return view('kms.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);

        if ($request->hasFile('file')) {
            $upload = $this->handleUpload($request);
            $data['file_path'] = $upload['file_path'];
            $data['file_type'] = $upload['file_type'];
        }

        $dokumen->update($data);

        return redirect()->route('admin.kms.subkategori.show', $dokumen->subkategori_id)->with('status', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        $subkategoriId = $dokumen->subkategori_id;
        $dokumen->delete();

        return redirect()->route('admin.kms.subkategori.show', $subkategoriId)->with('status', 'Dokumen berhasil dihapus.');
    }

    private function handleUpload(Request $request): array
    {
        $file = $request->file('file');
        $name = time() . '_' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move(public_path('kms-files'), $name);

        return [
            'file_path' => $name,
            'file_type' => $file->getClientOriginalExtension(),
        ];
    }
}
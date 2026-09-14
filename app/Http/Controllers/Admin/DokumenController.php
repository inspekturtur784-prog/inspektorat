<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subkategori;
use App\Models\GrupDokumen;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function create(Subkategori $subkategori, Request $request)
    {
        $grup = null;
        if ($request->filled('grup')) {
            $grup = GrupDokumen::where('id', $request->query('grup'))
                ->where('subkategori_id', $subkategori->id)
                ->first();
        }

        return view('kms.dokumen.create', compact('subkategori', 'grup'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);

        $data['file_type'] = $request->file('file')->getClientOriginalExtension();
        $data['file_path'] = $this->handleUpload($request);
        $data['dilihat'] = 0;

        // kategori_id diambil otomatis dari subkategori yang dipilih
        $subkategori = Subkategori::findOrFail($data['subkategori_id']);
        $data['kategori_id'] = $subkategori->kategori_id;

        Dokumen::create($data);

        return redirect()->route('admin.kms.subkategori.show', $subkategori)->with('status', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Dokumen $dokumen)
    {
        $dokumen->load('subkategori');
        return view('kms.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('file')) {
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['file_path'] = $this->handleUpload($request);
        }

        $subkategori = Subkategori::findOrFail($data['subkategori_id']);
        $data['kategori_id'] = $subkategori->kategori_id;

        $dokumen->update($data);

        return redirect()->route('admin.kms.subkategori.show', $subkategori)->with('status', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        $subkategoriId = $dokumen->subkategori_id;
        $dokumen->delete();
        return redirect()->route('admin.kms.subkategori.show', $subkategoriId)->with('status', 'Dokumen berhasil dihapus.');
    }

    private function validated(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'subkategori_id'  => 'required|exists:subkategoris,id',
            'grup_dokumen_id' => 'nullable|exists:grup_dokumens,id',
            'file'            => ($isCreate ? 'required' : 'nullable') . '|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);
    }

    private function handleUpload(Request $request): string
    {
        $file = $request->file('file');
        $name = time() . '_' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move(public_path('kms-files'), $name);
        return $name;
    }
}

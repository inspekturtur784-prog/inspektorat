<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedomanDokumen;
use App\Models\PedomanKategori;
use Illuminate\Http\Request;

class PedomanDokumenController extends Controller
{
    public function create()
    {
        return view('admin.kms-pedoman.pedoman.dokumen-form', [
            'dokumen' => null,
            'kategoris' => PedomanKategori::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data = $this->handleUpload($request, $data);

        PedomanDokumen::create($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen Pedoman berhasil ditambahkan.');
    }

    public function edit(PedomanDokumen $dokumen)
    {
        return view('admin.kms-pedoman.pedoman.dokumen-form', [
            'dokumen' => $dokumen,
            'kategoris' => PedomanKategori::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, PedomanDokumen $dokumen)
    {
        $data = $this->validated($request, false);
        $data = $this->handleUpload($request, $data);

        $dokumen->update($data);

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen Pedoman berhasil diperbarui.');
    }

    public function destroy(PedomanDokumen $dokumen)
    {
        $dokumen->delete();

        return redirect()->route('admin.kmspedoman.index')->with('status', 'Dokumen Pedoman berhasil dihapus.');
    }

    private function validated(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'pedoman_kategori_id' => 'required|exists:pedoman_kategoris,id',
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
            $file->move(public_path('pedoman-pdf'), $name);

            $data['file_path'] = 'pedoman-pdf/' . $name;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['ukuran_kb'] = intdiv($file->getSize(), 1024);
        }

        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiDokumen;
use Illuminate\Http\Request;

class InformasiDokumenController extends Controller
{
    public function index(Request $request)
    {
        $items = InformasiDokumen::kategori($request->query('kategori'))
            ->urut()
            ->paginate(15)
            ->withQueryString();

        return view('admin.informasi-dokumen.index', [
            'items' => $items,
            'kategoriList' => $this->daftarKategoriDipakai(),
            'kategoriAktif' => $request->query('kategori'),
        ]);
    }

    public function create()
    {
        return view('admin.informasi-dokumen.create', ['kategoriSaran' => InformasiDokumen::KATEGORI_SARAN]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'file'       => 'required|file|mimes:pdf|max:20480',
        ]);

        $data['file'] = $request->file('file')->store('informasi-dokumen', 'public');
        $data['urutan'] = (int) InformasiDokumen::where('kategori', $data['kategori'])->max('urutan') + 1;

        InformasiDokumen::create($data);

        return redirect()->route('admin.informasidokumen.index')->with('status', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(InformasiDokumen $informasiDokumen)
    {
        return view('admin.informasi-dokumen.edit', [
            'dokumen' => $informasiDokumen,
            'kategoriSaran' => InformasiDokumen::KATEGORI_SARAN,
        ]);
    }

    public function update(Request $request, InformasiDokumen $informasiDokumen)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'urutan'     => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'file'       => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('informasi-dokumen', 'public');
        }

        $informasiDokumen->update($data);

        return redirect()->route('admin.informasidokumen.index')->with('status', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(InformasiDokumen $informasiDokumen)
    {
        $informasiDokumen->delete();
        return redirect()->route('admin.informasidokumen.index')->with('status', 'Dokumen berhasil dihapus.');
    }

    private function daftarKategoriDipakai()
    {
        return InformasiDokumen::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
    }
}

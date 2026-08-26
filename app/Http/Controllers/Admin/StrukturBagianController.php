<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturBagian;
use Illuminate\Http\Request;

class StrukturBagianController extends Controller
{
    public function index()
    {
        $items = StrukturBagian::urut()->get();
        return view('admin.struktur.index', compact('items'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'         => 'required|string|max:150',
            'jabatan_desc' => 'nullable|string',
            'tugas'        => 'nullable|string',
            'bidang_key'   => 'nullable|string|max:100',
            'is_top'       => 'nullable|boolean',
            'urutan'       => 'nullable|integer',
        ]);

        $data['is_top'] = $request->boolean('is_top');

        StrukturBagian::create($data);

        return redirect()->route('admin.struktur.index')->with('status', 'Bagian struktur organisasi berhasil ditambahkan.');
    }

    public function edit(StrukturBagian $struktur)
    {
        return view('admin.struktur.edit', ['item' => $struktur]);
    }

    public function update(Request $request, StrukturBagian $struktur)
    {
        $data = $request->validate([
            'nama'         => 'required|string|max:150',
            'jabatan_desc' => 'nullable|string',
            'tugas'        => 'nullable|string',
            'bidang_key'   => 'nullable|string|max:100',
            'is_top'       => 'nullable|boolean',
            'urutan'       => 'nullable|integer',
        ]);

        $data['is_top'] = $request->boolean('is_top');

        $struktur->update($data);

        return redirect()->route('admin.struktur.index')->with('status', 'Bagian struktur organisasi berhasil diperbarui.');
    }

    public function destroy(StrukturBagian $struktur)
    {
        $struktur->delete();
        return redirect()->route('admin.struktur.index')->with('status', 'Bagian struktur organisasi berhasil dihapus.');
    }
}
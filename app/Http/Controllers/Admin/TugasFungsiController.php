<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TugasFungsi;
use Illuminate\Http\Request;

class TugasFungsiController extends Controller
{
    public function index()
    {
        $items = TugasFungsi::urut()->get();
        return view('admin.tugas-fungsi.index', compact('items'));
    }

    public function create()
    {
        return view('admin.tugas-fungsi.create', ['ikonList' => TugasFungsi::IKON]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'required|string|max:300',
            'icon'      => 'required|in:' . implode(',', array_keys(TugasFungsi::IKON)),
            'urutan'    => 'nullable|integer',
        ]);

        TugasFungsi::create($data);

        return redirect()->route('admin.tugasfungsi.index')->with('status', 'Kartu Fungsi berhasil ditambahkan.');
    }

    public function edit(TugasFungsi $tugasFungsi)
    {
        return view('admin.tugas-fungsi.edit', ['item' => $tugasFungsi, 'ikonList' => TugasFungsi::IKON]);
    }

    public function update(Request $request, TugasFungsi $tugasFungsi)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'required|string|max:300',
            'icon'      => 'required|in:' . implode(',', array_keys(TugasFungsi::IKON)),
            'urutan'    => 'nullable|integer',
        ]);

        $tugasFungsi->update($data);

        return redirect()->route('admin.tugasfungsi.index')->with('status', 'Kartu Fungsi berhasil diperbarui.');
    }

    public function destroy(TugasFungsi $tugasFungsi)
    {
        $tugasFungsi->delete();
        return redirect()->route('admin.tugasfungsi.index')->with('status', 'Kartu Fungsi berhasil dihapus.');
    }
}
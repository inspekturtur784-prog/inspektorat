<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TugasFungsi;
use App\Models\TugasPokok;
use Illuminate\Http\Request;

class TugasFungsiController extends Controller
{
    public function index()
    {
        $items = TugasFungsi::urut()->get();
        $tugasPokokItems = TugasPokok::urut()->get();
        $tugasPokok = optional(TugasPokok::urut()->first())->teks ?? '';

        return view('admin.tugas-fungsi.index', compact('items', 'tugasPokokItems', 'tugasPokok'));
    }

    /**
     * Simpan/perbarui teks Tugas Pokok.
     * Tugas Pokok ditampilkan sebagai satu textarea di form (bukan daftar
     * kartu seperti Fungsi), jadi cukup disimpan sebagai satu baris saja
     * di tabel tugas_pokok.
     */
    public function updateTugasPokok(Request $request)
    {
        $data = $request->validate([
            'tugas_pokok' => 'required|string',
        ]);

        $item = TugasPokok::urut()->first();

        if ($item) {
            $item->update(['teks' => $data['tugas_pokok']]);
        } else {
            TugasPokok::create(['teks' => $data['tugas_pokok'], 'urutan' => 0]);
        }

        return redirect()->route('admin.tugasfungsi.index')->with('status', 'Tugas Pokok berhasil disimpan.');
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
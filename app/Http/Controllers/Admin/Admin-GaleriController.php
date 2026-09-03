<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Services\ImageConverter;
use Illuminate\Http\Request;

/**
 * CRUD Galeri untuk sisi Admin.
 * NOTE: pasang middleware auth di route group-nya sebelum production
 * (lihat komentar di routes/web.php).
 */
class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $items = Galeri::kategori($request->query('kategori'))
            ->terbaru()
            ->paginate(15)
            ->withQueryString();

        return view('admin.galeri.index', [
            'items' => $items,
            'kategoriList' => $this->daftarKategoriDipakai(),
            'kategoriAktif' => $request->query('kategori'),
        ]);
    }

    public function create()
    {
        return view('admin.galeri.create', ['kategoriSaran' => Galeri::KATEGORI_SARAN]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100', // bebas, tidak dibatasi enum
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'required|image|max:5120', // maks 5MB, jenis apa saja (jpg/png/webp)
        ]);

        // Foto wajib & otomatis dikonversi ke .webp sebelum disimpan.
        $data['foto'] = ImageConverter::toWebp(
            $request->file('foto'),
            public_path('images/galeri')
        );

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')->with('status', 'Foto berhasil ditambahkan ke galeri (otomatis dikonversi ke WebP).');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', ['galeri' => $galeri, 'kategoriSaran' => Galeri::KATEGORI_SARAN]);
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = ImageConverter::toWebp(
                $request->file('foto'),
                public_path('images/galeri')
            );
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('status', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('status', 'Foto berhasil dihapus dari galeri.');
    }

    /** Kategori yang benar-benar sedang dipakai di data, buat tab filter. */
    private function daftarKategoriDipakai()
    {
        return Galeri::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
    }
}
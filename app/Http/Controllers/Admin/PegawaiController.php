<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Services\ImageConverter;
use Illuminate\Http\Request;

/**
 * CRUD Data Pegawai untuk sisi Admin.
 * NOTE: pasang middleware auth di route group-nya sebelum production
 * (lihat komentar di routes/web.php, sama seperti Admin\ArticleController).
 */
class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::urut()->paginate(15);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'nip'      => 'nullable|string|max:30',
            'jabatan'  => 'required|string|max:150',
            'golongan' => 'nullable|string|max:100',
            'bidang'   => 'nullable|string|max:150',
            'tugas'    => 'nullable|string',
            'fungsi'   => 'nullable|string',
            'urutan'   => 'nullable|integer',
            'photo'    => 'nullable|image|max:2048',
        ]);

        // Foto otomatis dikompresi & dikonversi ke WebP (sama seperti Galeri).
        if ($request->hasFile('photo')) {
            $data['photo'] = ImageConverter::toWebp(
                $request->file('photo'),
                public_path('images/pegawai')
            );
        }

        Pegawai::create($data);

        return redirect()->route('admin.pegawai.index')->with('status', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'nip'      => 'nullable|string|max:30',
            'jabatan'  => 'required|string|max:150',
            'golongan' => 'nullable|string|max:100',
            'bidang'   => 'nullable|string|max:150',
            'tugas'    => 'nullable|string',
            'fungsi'   => 'nullable|string',
            'urutan'   => 'nullable|integer',
            'photo'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageConverter::toWebp(
                $request->file('photo'),
                public_path('images/pegawai')
            );
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('status', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')->with('status', 'Data pegawai berhasil dihapus.');
    }
}
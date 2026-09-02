<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Services\ImageConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * CRUD Data Pegawai untuk sisi Admin.
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
            'foto'     => 'nullable|image|max:2048',
        ]);

        // Fleksibilitas penangkapan input foto/photo dari form
        $file = $request->file('photo') ?? $request->file('foto');

        if ($file) {
            $fileName = ImageConverter::toWebp(
                $file,
                public_path('images/pegawai')
            );
            // Simpan nama file ke kolom 'photo' dan 'foto' agar kompatibel dengan model
            $data['photo'] = $fileName;
            $data['foto']  = $fileName;
        }

        Pegawai::create($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
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
            'foto'     => 'nullable|image|max:2048',
        ]);

        $file = $request->file('photo') ?? $request->file('foto');

        if ($file) {
            // Hapus foto lama di folder public/images/pegawai jika ada
            $oldPhoto = $pegawai->photo ?? $pegawai->foto;
            if ($oldPhoto && File::exists(public_path('images/pegawai/' . $oldPhoto))) {
                File::delete(public_path('images/pegawai/' . $oldPhoto));
            }

            $fileName = ImageConverter::toWebp(
                $file,
                public_path('images/pegawai')
            );
            $data['photo'] = $fileName;
            $data['foto']  = $fileName;
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        // Hapus berkas fisik foto sebelum hapus data dari database
        $oldPhoto = $pegawai->photo ?? $pegawai->foto;
        if ($oldPhoto && File::exists(public_path('images/pegawai/' . $oldPhoto))) {
            File::delete(public_path('images/pegawai/' . $oldPhoto));
        }

        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
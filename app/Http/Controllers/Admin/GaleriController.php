<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /** Tampilan Tabel Kelola Galeri di Admin */
    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        
        return view('admin.galeri.index', compact('galeris'));
    }

    /** Tampilan Form Tambah Galeri */
    public function create()
    {
        $existing = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->toArray();

        $defaults = ['Kegiatan', 'Sosialisasi', 'Rapat', 'Inspeksi', 'Edukasi'];
        $kategoriSaran = array_unique(array_merge($defaults, $existing));

        return view('admin.galeri.create', compact('kategoriSaran'));
    }

    /** Simpan Data Galeri Baru */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->simpanFoto($request->file('foto'));
        }

        Galeri::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPath,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan');
    }

    /** Tampilan Form Edit Galeri */
    public function edit(Galeri $galeri)
    {
        $existing = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->toArray();

        $defaults = ['Kegiatan', 'Sosialisasi', 'Rapat', 'Inspeksi', 'Edukasi'];
        $kategoriSaran = array_unique(array_merge($defaults, $existing));

        return view('admin.galeri.edit', compact('galeri', 'kategoriSaran'));
    }

    /** Update Data Galeri */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'tanggal'   => 'required|date',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $data = [
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui');
    }

    /** Hapus Data Galeri beserta Berkas Fotonya */
    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil dihapus');
    }

    /**
     * Simpan foto galeri. Kalau PHP mendukung WebP, foto dikecilkan dan
     * dikonversi ke WebP. Kalau tidak bisa, disimpan apa adanya seperti biasa.
     */
    private function simpanFoto(\Illuminate\Http\UploadedFile $file): string
    {
        if (function_exists('imagewebp') && function_exists('imagecreatefromstring')) {
            try {
                $ukuran = @getimagesize($file->getRealPath());

                // Lewati konversi untuk gambar raksasa agar memori tidak habis
                if ($ukuran && ($ukuran[0] * $ukuran[1]) <= 40000000) {
                    $isi = @file_get_contents($file->getRealPath());
                    $gambar = $isi !== false ? @imagecreatefromstring($isi) : false;

                    if ($gambar !== false) {
                        imagepalettetotruecolor($gambar);

                        // Perbaiki rotasi foto dari HP (EXIF)
                        if (function_exists('exif_read_data') && ($ukuran[2] ?? 0) === IMAGETYPE_JPEG) {
                            $exif = @exif_read_data($file->getRealPath());
                            $orientasi = $exif['Orientation'] ?? 1;
                            $sudut = [3 => 180, 6 => -90, 8 => 90][$orientasi] ?? 0;
                            if ($sudut !== 0) {
                                $putar = imagerotate($gambar, $sudut, 0);
                                if ($putar !== false) {
                                    $gambar = $putar;
                                }
                            }
                        }

                        // Perkecil jika sisi terpanjang lebih dari 1920 px
                        $lebar = imagesx($gambar);
                        $tinggi = imagesy($gambar);
                        $maks = 1920;
                        if ($lebar > $maks || $tinggi > $maks) {
                            $skala = $maks / max($lebar, $tinggi);
                            $kecil = imagescale($gambar, (int) round($lebar * $skala), (int) round($tinggi * $skala));
                            if ($kecil !== false) {
                                $gambar = $kecil;
                            }
                        }

                        imagealphablending($gambar, false);
                        imagesavealpha($gambar, true);

                        ob_start();
                        $ok = imagewebp($gambar, null, 80);
                        $webp = ob_get_clean();

                        if ($ok && is_string($webp) && $webp !== '') {
                            $path = 'galeri/' . \Illuminate\Support\Str::uuid() . '.webp';
                            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $webp);
                            return $path;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // jatuh ke penyimpanan biasa di bawah
            }
        }

        return $file->store('galeri', 'public');
    }
}

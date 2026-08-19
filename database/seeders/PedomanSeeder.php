<?php

namespace Database\Seeders;

use App\Models\PedomanKategori;
use App\Models\PedomanDokumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PedomanSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = [
            'Reformasi Birokrasi',
            'Produk Hukum',
            'Pedoman Auditor',
            'Manajemen Risiko',
            'SPIP',
        ];

        foreach ($kategoriList as $nama) {
            PedomanKategori::firstOrCreate(
                ['slug' => Str::slug($nama)],
                ['nama' => $nama]
            );
        }

        // Masukin 2 dokumen contoh ke kategori "Manajemen Risiko"
        $kategoriMR = PedomanKategori::where('slug', 'manajemen-risiko')->first();

        PedomanDokumen::firstOrCreate(
            ['judul' => 'Perwali Nomor 39 Tahun 2017 - Penilaian Risiko'],
            [
                'pedoman_kategori_id' => $kategoriMR->id,
                'file_path' => 'dokumen/perwali-nomor-39-tahun-2017-penilaian-risiko.pdf',
                'file_type' => 'pdf',
                'ukuran_kb' => 2052,
            ]
        );

        PedomanDokumen::firstOrCreate(
            ['judul' => 'Mengenal Manajemen Risiko Pemda ES2 - Kota Mojokerto'],
            [
                'pedoman_kategori_id' => $kategoriMR->id,
                'file_path' => 'dokumen/bpkp-mengenal-mr-pemda-es2-kota-mojokerto.pdf',
                'file_type' => 'pdf',
                'ukuran_kb' => 5558,
            ]
        );
    }
}
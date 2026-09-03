<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\Dokumen;
use Illuminate\Database\Seeder;

class KmsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Diklat Fungsional Auditor' => [
                'Diklat Pembentukan' => ['Modul Audite Intern', 'Soal Tryout dan KJ Auditor Pertama', 'Materi AI', 'Materi KAI'],
                'Diklat Auditor Muda' => ['Modul Kepemimpinan'],
                'Auditor Madya' => ['Bahan Penugasan A. Madya', 'Buku Kerja A. Madya', 'Kebijakan Publik'],
            ],
            'Diklat Sertifikasi' => [
                'Sertifikasi JFA' => ['Panduan Sertifikasi JFA', 'Contoh Soal Sertifikasi'],
                'Sertifikasi P2UPD' => ['Modul P2UPD'],
            ],
            'Diklat Teknis Substansi' => [
                'Audit Kinerja' => ['Modul Audit Kinerja', 'Studi Kasus Audit Kinerja'],
                'Reviu Laporan Keuangan' => ['Panduan Reviu LK'],
            ],
            'Pengawasan Lainnya' => [
                'Pedoman Pengawasan' => ['SOP Pengawasan Internal', 'Juknis Pengawasan'],
            ],
        ];

        foreach ($data as $namaKategori => $subs) {
            $kategori = Kategori::firstOrCreate(
                ['slug' => \Str::slug($namaKategori)],
                ['nama' => $namaKategori]
            );

            foreach ($subs as $namaSub => $dokumenList) {
                $subkategori = Subkategori::firstOrCreate(
                    ['kategori_id' => $kategori->id, 'slug' => \Str::slug($namaSub)],
                    ['nama' => $namaSub]
                );

                foreach ($dokumenList as $judul) {
                    Dokumen::firstOrCreate(
                        ['judul' => $judul, 'subkategori_id' => $subkategori->id],
                        [
                            'kategori_id' => $kategori->id,
                            'file_path' => 'dummy.pdf',
                            'file_type' => 'pdf',
                        ]
                    );
                }
            }
        }
    }
}
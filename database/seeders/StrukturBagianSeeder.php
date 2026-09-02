<?php

namespace Database\Seeders;

use App\Models\StrukturBagian;
use Illuminate\Database\Seeder;

class StrukturBagianSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Inspektur', 'is_top' => true, 'bidang_key' => 'Inspektur', 'urutan' => 1,
                'jabatan_desc' => 'Pimpinan tertinggi Inspektorat, berkedudukan di bawah dan bertanggung jawab kepada Wali Kota melalui Sekretaris Daerah Kota.',
                'tugas' => 'Membantu Wali Kota membina dan mengawasi pelaksanaan Urusan Pemerintahan yang menjadi kewenangan Daerah dan tugas pembantuan oleh Perangkat Daerah.',
            ],
            [
                'nama' => 'Sekretariat', 'is_top' => false, 'bidang_key' => 'Sekretariat', 'urutan' => 2,
                'jabatan_desc' => 'Membawahi Subbagian Perencanaan dan Keuangan; Subbagian Umum dan Kepegawaian. Masing-masing dipimpin Kepala Sub Bagian yang bertanggung jawab kepada Sekretaris.',
                'tugas' => 'Menyelenggarakan penyusunan, perencanaan, dan pengelolaan urusan keuangan, kepegawaian, dan umum, serta mengoordinasikan secara teknis dan administratif pelaksanaan kegiatan dinas.',
            ],
            [
                'nama' => 'Kelompok Jabatan Fungsional', 'is_top' => false, 'bidang_key' => 'Kelompok Jabatan Fungsional', 'urutan' => 3,
                'jabatan_desc' => 'Auditor Ahli Utama, Auditor Ahli Madya, Pengawas Penyelenggaraan Urusan Pemerintahan Daerah (P2UPD) Ahli Madya, Perencana Ahli Madya.',
                'tugas' => 'Melaksanakan audit, reviu, evaluasi, dan pemantauan tingkat lanjut yang langsung berada di bawah koordinasi Inspektur.',
            ],
            [
                'nama' => 'Irban I', 'is_top' => false, 'bidang_key' => 'Irban I', 'urutan' => 4,
                'jabatan_desc' => 'Kelompok Jabatan Fungsional: Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.',
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban I.',
            ],
            [
                'nama' => 'Irban II', 'is_top' => false, 'bidang_key' => 'Irban II', 'urutan' => 5,
                'jabatan_desc' => 'Kelompok Jabatan Fungsional: Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.',
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban II.',
            ],
            [
                'nama' => 'Irban III', 'is_top' => false, 'bidang_key' => 'Irban III', 'urutan' => 6,
                'jabatan_desc' => 'Kelompok Jabatan Fungsional: Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.',
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban III.',
            ],
            [
                'nama' => 'Irban Khusus', 'is_top' => false, 'bidang_key' => 'Irban Khusus', 'urutan' => 7,
                'jabatan_desc' => 'Kelompok Jabatan Fungsional: Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.',
                'tugas' => 'Menangani penugasan pengawasan khusus, termasuk audit investigasi dan audit dengan tujuan tertentu.',
            ],
        ];

        foreach ($items as $item) {
            StrukturBagian::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}
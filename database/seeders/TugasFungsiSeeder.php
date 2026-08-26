<?php

namespace Database\Seeders;

use App\Models\TugasFungsi;
use Illuminate\Database\Seeder;

class TugasFungsiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['judul' => 'Perumusan Kebijakan', 'deskripsi' => 'Merumuskan kebijakan teknis bidang pengawasan dan fasilitasi pengawasan.', 'icon' => 'kebijakan', 'urutan' => 1],
            ['judul' => 'Pengawasan Internal', 'deskripsi' => 'Audit, reviu, evaluasi, dan pemantauan kinerja serta keuangan perangkat daerah.', 'icon' => 'pengawasan', 'urutan' => 2],
            ['judul' => 'Audit Khusus', 'deskripsi' => 'Audit dengan tujuan tertentu, audit investigasi, dan audit kinerja atas penugasan Wali Kota.', 'icon' => 'audit', 'urutan' => 3],
            ['judul' => 'Pelaporan Hasil', 'deskripsi' => 'Menyusun laporan hasil pengawasan secara berkala dan menyeluruh.', 'icon' => 'laporan', 'urutan' => 4],
            ['judul' => 'Administrasi Inspektorat', 'deskripsi' => 'Mengelola tata usaha, kepegawaian, dan administrasi internal Inspektorat.', 'icon' => 'administrasi', 'urutan' => 5],
            ['judul' => 'Fungsi Lainnya', 'deskripsi' => 'Melaksanakan fungsi lain yang diberikan Wali Kota terkait tugas pokok dan fungsinya.', 'icon' => 'lainnya', 'urutan' => 6],
        ];

        foreach ($items as $item) {
            TugasFungsi::updateOrCreate(['judul' => $item['judul']], $item);
        }
    }
}
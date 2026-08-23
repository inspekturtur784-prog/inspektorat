<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Agung Moeljono S., S.H., M.H', 'jabatan' => 'Inspektur',
                'golongan' => 'Pembina Utama Muda (IV/c)', 'bidang' => 'Inspektur', 'urutan' => 1,
                'tugas' => 'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas pengawasan di lingkungan Inspektorat.',
                'fungsi' => 'Menetapkan kebijakan teknis pengawasan serta melaporkan hasil pengawasan kepada Wali Kota.',
            ],
            [
                'nama' => 'Moch. Zaini, ST, MM', 'jabatan' => 'Sekretaris',
                'golongan' => 'Pembina (IV/a)', 'bidang' => 'Sekretariat', 'urutan' => 2,
                'tugas' => 'Menyelenggarakan penyusunan, perencanaan, dan pengelolaan urusan keuangan, kepegawaian, dan umum.',
                'fungsi' => 'Mengoordinasikan secara teknis dan administratif pelaksanaan kegiatan dinas.',
            ],
            [
                'nama' => 'Istibsyaroh, SH', 'jabatan' => 'Inspektur Pembantu I',
                'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban I', 'urutan' => 3,
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban I.',
                'fungsi' => 'Mengoordinasikan tim fungsional Irban I dalam pelaksanaan audit dan reviu.',
            ],
            [
                'nama' => 'Nur Roifah, SH., MM', 'jabatan' => 'Inspektur Pembantu II',
                'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban II', 'urutan' => 4,
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban II.',
                'fungsi' => 'Mengoordinasikan tim fungsional Irban II dalam pelaksanaan audit dan reviu.',
            ],
            [
                'nama' => 'Zakky Nilem Sanjifa, S.Kom, M.T.', 'jabatan' => 'Inspektur Pembantu III',
                'golongan' => 'Penata Tingkat I (III/d)', 'bidang' => 'Irban III', 'urutan' => 5,
                'tugas' => 'Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban III.',
                'fungsi' => 'Mengoordinasikan tim fungsional Irban III dalam pelaksanaan audit dan reviu.',
            ],
            [
                'nama' => 'Dra. Rina Purwanti, M.Si', 'jabatan' => 'Inspektur Pembantu Khusus',
                'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban Khusus', 'urutan' => 6,
                'tugas' => 'Menangani penugasan pengawasan khusus, termasuk audit investigasi dan audit dengan tujuan tertentu.',
                'fungsi' => 'Mengoordinasikan tim fungsional Irban Khusus dalam penanganan kasus pengaduan.',
            ],
            [
                'nama' => 'Bhinneka Kumalasari, S.KM', 'jabatan' => 'Kasubag Umum dan Kepegawaian',
                'golongan' => null, 'bidang' => 'Sekretariat', 'urutan' => 7,
                'tugas' => 'Mengelola administrasi umum, kepegawaian, dan kearsipan Inspektorat.',
                'fungsi' => 'Menyiapkan data kepegawaian dan mendukung operasional tata usaha kantor.',
            ],
            [
                'nama' => 'Rr. Intan Ari Budi Astuti, ST, MT', 'jabatan' => 'Perencana Ahli Muda',
                'golongan' => null, 'bidang' => 'Sekretariat', 'urutan' => 8,
                'tugas' => 'Menyusun Renstra, Renja, RKA, serta Perjanjian Kinerja dan Indikator Kinerja Utama.',
                'fungsi' => 'Mendukung perencanaan dan evaluasi program kerja Inspektorat.',
            ],
            [
                'nama' => 'Muh. Sugeng, SE, M.Si, Ak, C.A. CGCAE', 'jabatan' => 'Auditor Ahli Utama',
                'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 9,
                'tugas' => 'Melaksanakan audit, reviu, dan evaluasi tingkat lanjut atas penugasan Inspektur.',
                'fungsi' => 'Memberikan pertimbangan teknis dalam penyusunan kebijakan pengawasan.',
            ],
            [
                'nama' => 'Dra. Saidah Binuria Saing, M.Si', 'jabatan' => 'Auditor Ahli Madya',
                'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 10,
                'tugas' => 'Melaksanakan audit dan reviu atas kinerja dan keuangan perangkat daerah.',
                'fungsi' => 'Menyusun kertas kerja dan laporan hasil pemeriksaan.',
            ],
            [
                'nama' => 'Dra. Rr Purtika Darmawati, M.Si', 'jabatan' => 'Auditor Ahli Madya',
                'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 11,
                'tugas' => 'Melaksanakan audit dan reviu atas kinerja dan keuangan perangkat daerah.',
                'fungsi' => 'Menyusun kertas kerja dan laporan hasil pemeriksaan.',
            ],
            [
                'nama' => 'Endera Noerhajanto, SH, M.Si', 'jabatan' => 'Auditor Ahli Madya',
                'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 12,
                'tugas' => 'Melaksanakan audit dan reviu atas kinerja dan keuangan perangkat daerah.',
                'fungsi' => 'Menyusun kertas kerja dan laporan hasil pemeriksaan.',
            ],
        ];

        foreach ($items as $item) {
            Pegawai::updateOrCreate(
                ['nama' => $item['nama'], 'jabatan' => $item['jabatan']],
                $item
            );
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Pimpinan
            ['nama' => 'Agung Moeljono S., S.H., M.H', 'jabatan' => 'Inspektur', 'golongan' => 'Pembina Utama Muda (IV/c)', 'bidang' => 'Inspektur', 'urutan' => 1],
            ['nama' => 'Moch. Zaini, ST, MM', 'jabatan' => 'Sekretaris', 'golongan' => 'Pembina (IV/a)', 'bidang' => 'Sekretariat', 'urutan' => 2],

            // Inspektur Pembantu
            ['nama' => 'Istibsyaroh, SH', 'jabatan' => 'Inspektur Pembantu I', 'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban I', 'urutan' => 3],
            ['nama' => 'Nur Roifah, SH., MM', 'jabatan' => 'Inspektur Pembantu II', 'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban II', 'urutan' => 4],
            ['nama' => 'Zakky Nilem Sanjifa, S.Kom, M.T.', 'jabatan' => 'Inspektur Pembantu III', 'golongan' => 'Penata Tingkat I (III/d)', 'bidang' => 'Irban III', 'urutan' => 5],
            ['nama' => 'Dra. Rina Purwanti, M.Si', 'jabatan' => 'Inspektur Pembantu Khusus', 'golongan' => 'Pembina Tingkat I (IV/b)', 'bidang' => 'Irban Khusus', 'urutan' => 6],

            // Sekretariat & fungsional penunjang
            ['nama' => 'Bhinneka Kumalasari, S.KM', 'jabatan' => 'Kasubag Umum dan Kepegawaian', 'golongan' => null, 'bidang' => 'Sekretariat', 'urutan' => 7],
            ['nama' => 'Rr. Intan Ari Budi Astuti, ST, MT', 'jabatan' => 'Perencana Ahli Muda', 'golongan' => null, 'bidang' => 'Sekretariat', 'urutan' => 8],

            // Kelompok Jabatan Fungsional (Auditor)
            ['nama' => 'Muh. Sugeng, SE, M.Si, Ak, C.A. CGCAE', 'jabatan' => 'Auditor Ahli Utama', 'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 9],
            ['nama' => 'Dra. Saidah Binuria Saing, M.Si', 'jabatan' => 'Auditor Ahli Madya', 'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 10],
            ['nama' => 'Dra. Rr Purtika Darmawati, M.Si', 'jabatan' => 'Auditor Ahli Madya', 'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 11],
            ['nama' => 'Endera Noerhajanto, SH, M.Si', 'jabatan' => 'Auditor Ahli Madya', 'golongan' => null, 'bidang' => 'Kelompok Jabatan Fungsional', 'urutan' => 12],
        ];

        foreach ($items as $item) {
            Pegawai::create($item);
        }
    }
}
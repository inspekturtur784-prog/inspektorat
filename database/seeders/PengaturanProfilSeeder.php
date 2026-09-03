<?php

namespace Database\Seeders;

use App\Models\PengaturanProfil;
use Illuminate\Database\Seeder;

class PengaturanProfilSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'tentang_intro' => 'Inspektorat adalah unsur pengawas penyelenggaraan pemerintahan daerah, yang bekerja langsung di bawah dan bertanggung jawab kepada Wali Kota. Kami hadir untuk memastikan setiap kebijakan, program, dan penggunaan anggaran daerah berjalan sesuai aturan — demi Kota Mojokerto yang bersih, akuntabel, dan terpercaya.',
            'kedudukan' => 'Merupakan unsur pengawas penyelenggaraan Pemerintahan Daerah, dipimpin oleh Inspektur yang berkedudukan di bawah dan bertanggung jawab kepada Wali Kota melalui Sekretaris Daerah Kota.',
            'peran' => 'Menjadi mitra strategis seluruh perangkat daerah dalam mewujudkan tata kelola pemerintahan yang taat aturan dan berintegritas.',
            'tujuan' => 'Mewujudkan penyelenggaraan pemerintahan Kota Mojokerto yang bersih, akuntabel, dan bebas dari korupsi.',
            'fungsi_singkat' => 'Melaksanakan audit, reviu, evaluasi, pemantauan, dan bentuk pengawasan lain sesuai kebijakan Wali Kota.',

            'visi' => 'Terwujudnya pengawasan yang profesional untuk mendukung tata kelola pemerintahan Kota Mojokerto yang bersih, akuntabel, dan berintegritas.',
            'misi' => "Meningkatkan kualitas dan profesionalisme aparatur pengawasan internal pemerintah.\nMendorong penyelenggaraan pemerintahan daerah yang taat aturan dan bebas dari korupsi, kolusi, dan nepotisme.\nMemperkuat sistem pengendalian intern pada seluruh perangkat daerah.\nMembangun budaya integritas dan zona bebas gratifikasi di lingkungan pemerintah kota.",

            'tugas_pokok' => 'Membantu Wali Kota membina dan mengawasi pelaksanaan Urusan Pemerintahan yang menjadi kewenangan Daerah dan tugas pembantuan oleh Perangkat Daerah.',
        ];

        foreach ($defaults as $key => $value) {
            PengaturanProfil::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
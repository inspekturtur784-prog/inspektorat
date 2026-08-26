<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title'   => 'Inspektorat Gelar Rapat Konsolidasi Pengawasan Semester II',
                'excerpt' => 'Rapat membahas capaian pengawasan semester pertama serta rencana kerja pengawasan tahunan untuk semester berikutnya.',
                'category'=> 'Kegiatan',
                'published_at' => now(),
            ],
            [
                'title'   => 'Sosialisasi Zona Integritas dan Penolakan Gratifikasi',
                'excerpt' => 'Seluruh pegawai menandatangani komitmen bersama menolak segala bentuk gratifikasi dalam pelayanan publik.',
                'category'=> 'Pengumuman',
                'published_at' => now()->subDays(2),
            ],
            [
                'title'   => 'Evaluasi Tindak Lanjut Hasil Pemeriksaan OPD',
                'excerpt' => 'Tim monitoring dan evaluasi memaparkan progres tindak lanjut rekomendasi hasil pemeriksaan di lingkungan OPD.',
                'category'=> 'Berita',
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($items as $item) {
            Article::create($item);
        }
    }
}
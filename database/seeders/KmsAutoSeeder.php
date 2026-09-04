<?php

namespace Database\Seeders;

use App\Models\Subkategori;
use App\Models\GrupDokumen;
use App\Models\Dokumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class KmsAutoSeeder extends Seeder
{
    public function run(): void
    {
        $subkategoris = Subkategori::with('kategori')->get();

        foreach ($subkategoris as $sub) {
            $basePath = 'kms/' . $sub->kategori->slug . '/' . $sub->slug;

            if (!Storage::disk('public')->exists($basePath)) {
                $this->command->warn("Folder belum ada: {$basePath}");
                continue;
            }

            // 1. Scan file langsung di folder sub-kategori (tanpa grup)
            $files = Storage::disk('public')->files($basePath);
            foreach ($files as $filePath) {
                $this->simpanDokumen($filePath, $sub->kategori_id, $sub->id, null);
            }

            // 2. Scan folder-folder di dalam sub-kategori (jadi grup, kalau ada)
            $subfolders = Storage::disk('public')->directories($basePath);
            foreach ($subfolders as $folderPath) {
                $namaGrup = ucwords(str_replace('-', ' ', basename($folderPath)));

                $grup = GrupDokumen::firstOrCreate(
                    [
                        'subkategori_id' => $sub->id,
                        'slug' => basename($folderPath),
                    ],
                    ['nama' => $namaGrup]
                );

                $filesDalamGrup = Storage::disk('public')->files($folderPath);
                foreach ($filesDalamGrup as $filePath) {
                    $this->simpanDokumen($filePath, $sub->kategori_id, $sub->id, $grup->id);
                }
            }
        }
    }

    private function simpanDokumen($filePath, $kategoriId, $subkategoriId, $grupId)
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (!in_array($ext, ['pdf', 'mp4'])) {
            return;
        }

        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        $judul = ucwords(str_replace(['-', '_'], ' ', $filename));

        Dokumen::firstOrCreate(
            [
                'subkategori_id' => $subkategoriId,
                'grup_dokumen_id' => $grupId,
                'file_path' => $filePath,
            ],
            [
                'kategori_id' => $kategoriId,
                'judul' => $judul,
                'file_type' => $ext,
            ]
        );

        $this->command->info("Ditambahkan: {$judul}");
    }
}
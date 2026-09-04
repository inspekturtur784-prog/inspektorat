<?php

namespace Database\Seeders;

use App\Models\PedomanKategori;
use App\Models\PedomanDokumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PedomanAutoSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = PedomanKategori::all();

        foreach ($kategoris as $kategori) {
            $folder = 'dokumen/' . $kategori->slug;

            if (!Storage::disk('public')->exists($folder)) {
                $this->command->warn("Folder belum ada: {$folder}");
                continue;
            }

            $files = Storage::disk('public')->files($folder);

            foreach ($files as $filePath) {
                if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) !== 'pdf') {
                    continue;
                }

                $filename = pathinfo($filePath, PATHINFO_FILENAME);
                $judul = ucwords(str_replace('-', ' ', $filename));
                $ukuranKb = round(Storage::disk('public')->size($filePath) / 1024);

                PedomanDokumen::firstOrCreate(
                    [
                        'pedoman_kategori_id' => $kategori->id,
                        'file_path' => $filePath,
                    ],
                    [
                        'judul' => $judul,
                        'file_type' => 'pdf',
                        'ukuran_kb' => $ukuranKb,
                    ]
                );

                $this->command->info("Ditambahkan: {$judul}");
            }
        }
    }
}
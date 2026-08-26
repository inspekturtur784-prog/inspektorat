<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use RuntimeException;

/**
 * Mengonversi foto yang diupload menjadi format .webp sebelum disimpan.
 * Dipakai oleh Admin\GaleriController (dan bisa dipakai modul lain yang
 * butuh upload foto otomatis di-webp-kan).
 *
 * Butuh ekstensi GD aktif di PHP (biasanya sudah aktif secara default).
 * Kalau GD tidak tersedia, file disimpan apa adanya (tanpa konversi)
 * supaya upload tetap jalan, bukan gagal total.
 */
class ImageConverter
{
    /**
     * @param  UploadedFile  $file       File foto yang diupload.
     * @param  string        $destDir    Path absolut folder tujuan (public_path('images/galeri')).
     * @param  int           $quality    Kualitas WebP 0-100 (default 82, seimbang antara ukuran & kualitas).
     * @return string                    Nama file hasil (selalu berakhiran .webp jika konversi berhasil).
     */
    public static function toWebp(UploadedFile $file, string $destDir, int $quality = 82): string
    {
        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $baseName = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $baseName = preg_replace('/[^A-Za-z0-9_-]/', '-', $baseName);

        // Kalau GD atau fungsi imagewebp tidak tersedia, simpan file asli saja.
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            $original = $baseName . '.' . $file->getClientOriginalExtension();
            $file->move($destDir, $original);
            return $original;
        }

        $tmpPath = $file->getRealPath();
        $mime = $file->getMimeType();

        $image = match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($tmpPath),
            'image/png' => imagecreatefrompng($tmpPath),
            'image/webp' => imagecreatefromwebp($tmpPath),
            default => null,
        };

        if (! $image) {
            // Format tidak dikenali GD — simpan apa adanya sebagai fallback.
            $original = $baseName . '.' . $file->getClientOriginalExtension();
            $file->move($destDir, $original);
            return $original;
        }

        // Pertahankan transparansi untuk PNG.
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $filename = $baseName . '.webp';
        $fullPath = rtrim($destDir, '/') . '/' . $filename;

        if (! imagewebp($image, $fullPath, $quality)) {
            imagedestroy($image);
            throw new RuntimeException('Gagal mengonversi gambar ke WebP.');
        }

        imagedestroy($image);

        return $filename;
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel generik untuk semua dokumen di menu navbar "Informasi":
 * SOP, Informasi Berkala, Informasi Setiap Saat, IKM, Persepsi Korupsi, dll.
 *
 * Nama tabel/model sengaja "informasi_dokumens" / InformasiDokumen (BUKAN
 * "dokumens" / Dokumen) karena App\Models\Dokumen dan
 * App\Http\Controllers\Admin\DokumenController SUDAH DIPAKAI oleh fitur
 * KMS yang sudah jalan - supaya tidak bentrok/menimpa.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori');
            $table->unsignedInteger('urutan')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('file');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_dokumens');
    }
};

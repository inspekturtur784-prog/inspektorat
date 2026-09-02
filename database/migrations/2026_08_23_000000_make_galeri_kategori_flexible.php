<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Ubah kolom "kategori" dari enum kaku (harus migration tiap tambah kategori)
 * jadi string bebas — supaya kategori bisa disesuaikan DUDI kapan saja lewat
 * Admin, tanpa perlu ubah kode/migration lagi.
 *
 * Ditulis dengan cara "buat tabel baru, pindah data, buang yang lama" karena
 * SQLite tidak mendukung ALTER COLUMN enum secara langsung.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeris_new', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori'); // bebas, tidak dibatasi enum lagi
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->string('foto');
            $table->timestamps();
        });

        DB::statement('INSERT INTO galeris_new (id, judul, slug, kategori, tanggal, deskripsi, foto, created_at, updated_at)
            SELECT id, judul, slug, kategori, tanggal, deskripsi, foto, created_at, updated_at FROM galeris');

        Schema::drop('galeris');
        Schema::rename('galeris_new', 'galeris');
    }

    public function down(): void
    {
        // Tidak perlu rollback presisi untuk perubahan struktural ini.
    }
};
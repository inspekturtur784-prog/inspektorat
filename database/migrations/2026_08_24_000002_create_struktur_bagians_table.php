<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_bagians', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // mis. "Sekretariat", "Inspektur Pembantu I"
            $table->text('jabatan_desc')->nullable(); // teks "Jabatan: ..."
            $table->text('tugas')->nullable();        // teks "Tugas: ..."
            $table->string('bidang_key')->nullable();  // dicocokkan dengan kolom "bidang" di tabel pegawais
            $table->boolean('is_top')->default(false);  // true = ditampilkan sebagai puncak bagan (mis. Inspektur)
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_bagians');
    }
};
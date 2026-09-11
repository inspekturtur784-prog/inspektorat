<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('judul');           // mis. "Kedudukan", "Peran", "Tujuan", "Fungsi"
            $table->text('deskripsi');
            $table->string('icon')->nullable(); // key ikon, dipakai lewat partials.icon
            $table->unsignedInteger('urutan')->default(0); // buat atur posisi tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_highlights');
    }
};
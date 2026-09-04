<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kategori_id')->constrained()->onDelete('cascade');
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->string('file_path');      // lokasi file di storage
        $table->string('file_type')->nullable();  // pdf, docx, dll
        $table->integer('dilihat')->default(0);   // jumlah dilihat/download
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};

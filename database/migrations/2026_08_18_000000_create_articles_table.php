<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 300)->nullable(); // ringkasan singkat di kartu Home
            $table->longText('body')->nullable();       // isi lengkap artikel
            $table->string('cover_image')->nullable();  // nama file, disimpan di public/images/articles
            $table->string('category')->nullable();     // mis. Berita, Pengumuman, Kegiatan
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
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
         Schema::create('pedoman_dokumens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pedoman_kategori_id')->constrained()->onDelete('cascade');
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->string('file_path');
        $table->string('file_type')->default('pdf');
        $table->unsignedBigInteger('ukuran_kb')->nullable();
        $table->integer('downloads')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedoman_dokumens');
    }
};

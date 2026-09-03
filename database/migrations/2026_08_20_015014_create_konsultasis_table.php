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
    Schema::create('konsultasis', function (Blueprint $table) {
        $table->id();

        $table->string('nomor_tiket')->unique();

        $table->string('nama');
        $table->string('email');
        $table->string('no_wa');
        $table->string('instansi')->nullable();

        $table->string('kategori');

        $table->text('pertanyaan');

        $table->text('jawaban')->nullable();

        $table->enum('status', [
            'menunggu',
            'diproses',
            'selesai'
        ])->default('menunggu');

        $table->timestamps();
    });
}
};

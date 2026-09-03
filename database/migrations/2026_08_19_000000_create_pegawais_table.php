<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            $table->string('jabatan');          // mis. Inspektur, Sekretaris, Auditor Ahli Madya
            $table->string('golongan')->nullable(); // mis. IV/a, III/d
            $table->string('bidang')->nullable();   // mis. Irban I, Sekretariat
            $table->string('photo')->nullable();    // nama file, disimpan di public/images/pegawai
            $table->unsignedInteger('urutan')->default(0); // urutan tampil (mis. Inspektur paling atas)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesans', function (Blueprint $table) {
            $table->text('balasan')->nullable();
            $table->timestamp('dibalas_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pesans', function (Blueprint $table) {
            $table->dropColumn(['balasan', 'dibalas_pada']);
        });
    }
};
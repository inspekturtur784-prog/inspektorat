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
        Schema::table('dokumens', function (Blueprint $table) {
        $table->foreignId('subkategori_id')->nullable()->after('kategori_id')->constrained()->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('dokumens', function (Blueprint $table) {
        $table->dropForeign(['subkategori_id']);
        $table->dropColumn('subkategori_id');
    }); 
    }
};

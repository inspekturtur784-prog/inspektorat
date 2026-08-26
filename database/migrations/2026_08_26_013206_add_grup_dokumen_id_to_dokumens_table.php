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
        $table->foreignId('grup_dokumen_id')->nullable()->after('subkategori_id')->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('dokumens', function (Blueprint $table) {
        $table->dropForeign(['grup_dokumen_id']);
        $table->dropColumn('grup_dokumen_id');
    });
}
};

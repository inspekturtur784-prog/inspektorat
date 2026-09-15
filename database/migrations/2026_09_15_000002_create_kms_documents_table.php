<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kms_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kms_category_id')
                ->constrained('kms_categories')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('tag')->nullable();
            $table->string('file_path');
            $table->string('original_name');
            $table->string('file_type', 20)->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kms_documents');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livechat_threads', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('status', 20)->default('baru'); // baru | dijawab | ditutup
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('admin_last_read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('livechat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('livechat_threads')->cascadeOnDelete();
            $table->string('sender', 10); // user | admin
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livechat_messages');
        Schema::dropIfExists('livechat_threads');
    }
};
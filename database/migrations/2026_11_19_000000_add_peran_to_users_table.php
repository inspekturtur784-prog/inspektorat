<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'peran')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('peran', 20)->default('admin')->after('password');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'peran')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('peran');
            });
        }
    }
};
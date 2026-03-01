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
        if (!Schema::hasTable('posts') || Schema::hasColumn('posts', 'user_id')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            // Existing rows can make non-null column additions fail on PostgreSQL.
            $table->foreignId('user_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasColumn('posts', 'user_id')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};

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
        Schema::table('time_logs', function (Blueprint $table) {
            // user_id 外部キー制約を削除
            $table->dropForeign(['user_id']);
            // user_id 列を削除
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_logs', function (Blueprint $table) {
            // ロールバック時に user_id を復活
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }
};

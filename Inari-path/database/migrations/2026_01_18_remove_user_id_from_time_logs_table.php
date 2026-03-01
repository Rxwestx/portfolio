<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('time_logs') || !Schema::hasColumn('time_logs', 'user_id')) {
            return;
        }

        $hasForeignKey = DB::table('information_schema.table_constraints')
            ->where('table_schema', 'public')
            ->where('table_name', 'time_logs')
            ->where('constraint_type', 'FOREIGN KEY')
            ->where('constraint_name', 'time_logs_user_id_foreign')
            ->exists();

        Schema::table('time_logs', function (Blueprint $table) use ($hasForeignKey) {
            // user_id 列を削除
            if ($hasForeignKey) {
                $table->dropForeign('time_logs_user_id_foreign');
            }

            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('time_logs') || Schema::hasColumn('time_logs', 'user_id')) {
            return;
        }

        Schema::table('time_logs', function (Blueprint $table) {
            // ロールバック時に user_id を復活
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }
};

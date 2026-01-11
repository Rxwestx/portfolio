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
        Schema::create('characters', function (Blueprint $table) {
            // id（主キー）
            $table->id();

            // users テーブルとの紐づけ
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // user_id にユニーク制約を追加（1ユーザーにつき1キャラクター）
            $table->unique('user_id');

            // キャラクターレベル
            $table->integer('level')->default(0);

            // 経験値
            $table->integer('exp')->default(0);

            // ランク
            $table->integer('rank')->default(0);

            // ランクメッセージ
            $table->text('rank_message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }

};

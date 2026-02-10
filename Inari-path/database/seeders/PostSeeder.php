<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Post::create([
            'title' => 'テスト',
            'body' => 'シーダーのテストを実行します。',
            'user_id' => 1, // 1はデフォルトで登録��みのユーザーID
        ]);
    }
}

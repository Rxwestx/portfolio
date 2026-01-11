<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    // 1ユーザー=1キャラクターの関係を定義
    protected $fillable = [
        'user_id',
        'level',
        'exp',
        'rank',
        'rank_message',
    ];
    // users に紐づく（1対1の関係）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

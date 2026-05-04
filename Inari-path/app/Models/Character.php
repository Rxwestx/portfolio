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
        'exp',
        'rank',
        'rank_name',
        'rank_message',
        'last_rank_down_at',
        'is_penalized',
    ];

    protected $casts = [
        'last_rank_down_at' => 'datetime',
        'is_penalized' => 'boolean',
    ];
    // users に紐づく（1対1の関係）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * ランクを1段階下げる
     * @return bool 下げたかどうか
     */
    public function decreaseRank()
    {
        // 現在のランクが0より大きい場合のみ下げる
    if ($this->rank > 0) {
        $this->rank = $this->rank - 1;

        // ランクメッセージも更新
        $rankMessages = [
            0 => '弱った狐',
            1 => '一尾',
            // ... 省略
        ];
        $this->rank_message = $rankMessages[$this->rank];

        $this->save();
        return true; // 下げた
    }
        return false; // 既に最低ランク
        }
    public static function getRankNames()
    {
        return [
            0 => '弱った狐',
            1 => '一尾',
            2 => '二尾',
            3 => '三尾',
            4 => '四尾',
            5 => '五尾',
            6 => '六尾',
            7 => '七尾',
            8 => '八尾',
            9 => '九尾',
            10 => '伝説の妖狐',
        ];
    }
    /**levelからランク名を取得 */
    public static function getRankNameFromLevel($level)
    {
        $rankNames = self::getRankNames();
        return $rankNames[$level] ?? '弱った狐';
    }
}

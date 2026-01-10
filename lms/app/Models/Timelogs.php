<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLogs extends Model
{
    use HasFactory;
    // time_logs テーブルを指定
    protected $table = 'time_logs';

    protected $fillable =  [
        'user_id',
        'goal_id',
        'logged_at',
        'duration_minutes'
    ];

    protected $casts = [
        'logged_at' => 'datetime:Y-m-d',
    ];

    protected function logged_at():Attribute
    {
        return  Attribute::make(
            get: fn($value) => $value ?? now(),
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
        /**
     * ダッシュボード（学習記録一覧）
     */
    public function dashboard()
    {
        // 全ユーザーの記録を表示（または自分の記録のみ）
        $timelogs = TimeLogs::where('user_id', Auth::id())
            ->orderBy('logged_at', 'desc')
            ->paginate(10);

        return view('timelogs.dashboard', compact('timelogs'));
    }


}





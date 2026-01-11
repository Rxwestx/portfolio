<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\TimeLogs;
use App\Models\Character;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TimeLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timelogs = TimeLogs::where('user_id', Auth::id())
            ->orderBy('logged_at', 'desc')
            ->paginate(10);
        return view('timelogs.index', compact('timelogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hasGoal = Goal::where('user_id', Auth::id())->exists();

        // 目標がまだなら、初期設定（目標設定）へ
        if (!$hasGoal) {
            return redirect()->route('goals.create');
        }

        // 目標がある人は、通常どおり新規投稿画面
        return view('timelogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'study_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();
        $loggedAt = Carbon::parse($request->study_date)->startOfDay();

        // 直近の自分の Goal に紐付け。無ければ目標作成へ誘導。
        $goalId = Goal::where('user_id', $userId)->latest('id')->value('id');
        if (!$goalId) {
            return redirect()->route('goals.create')
                ->with('error', 'まず目標を作成してください。');
        }

        TimeLogs::create([
            'user_id' => $userId,
            'goal_id' => $goalId,
            'logged_at' => $loggedAt,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return redirect()->route('timelogs.index')
            ->with('success', '学習記録を保存しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeLogs $timelogs)
    {
        //  dd($timelogs);
        return view('timelogs.show', compact('timelogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeLogs $timelogs)
    {
        return view('timelogs.edit', compact('timelogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeLogs $timelogs)
    {
        $validated = $request->validate([
            'study_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $timelogs->update([
            'logged_at' => Carbon::parse($validated['study_date'])->startOfDay(),
            'duration_minutes' => $validated['duration_minutes'],
        ]);

        return redirect()->route('timelogs.show', $timelogs)
            ->with('success', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeLogs $timelogs)
    {
        $timelogs->delete();
        return redirect()->route('timelogs.index')
            ->with('success', '削除しました');
    }
    /**
     * キャラクター詳細（/dashboard）
     */
    public function dashboard()
    {
        $timelogs = TimeLogs::where('user_id', Auth::id())
            ->orderBy('logged_at', 'desc')
            ->paginate(10);

        // DBより、トータル時間を取得し集計
        $totalMinutes = TimeLogs::where('user_id', Auth::id())
            ->sum('duration_minutes');

        // ダッシュボード用に分を時間に変換（小数1桁で丸め）
        $totalHours = round($totalMinutes / 60, 1);

        // 目標総時間取得
        $targetHours = Goal::where('user_id', Auth::id())
            ->latest('id')
            ->value('target_hours');
        // 時間を分に変換
        $targetMinutes = $targetHours ? $targetHours * 60 : 0;
        // 達成率の計算 目標が 0 なら、達成率も 0% とし、小数をパーセントに変換
        $percent = $targetMinutes > 0
            ? min(100, floor(($totalMinutes / $targetMinutes) * 100))
            : 0;
        // ランクの計算（例: 10%ごとにランクアップ、最大ランク10）
        $rank = min(10, intdiv($percent, 10));

        $rankMessages = [
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
        $rankMessage = $rankMessages[$rank];

        // ========== キャラクター操作 ==========
        // 1. 現在のユーザーがキャラクターを持っているか確認
        // 持っていなければ初期状態で作成、持っていれば取得
        $character = Character::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'level' => 1,
                'exp' => 0,
                'rank' => 0,
                'rank_message' => '弱った狐',
            ]
        );
        // 2. 計算した達成率に基づいてキャラクターのランクとメッセージを更新
        $character->rank = $rank;
        $character->rank_message = $rankMessage;

        // 総学習時間をEXPとして記録
        $character->exp = $totalMinutes;
        $character->save();

        // ビューへデータを渡す（学習記録、時間情報、達成率・ランク、キャラクター情報をダッシュボードに送信）
        return view('timelogs.dashboard', compact(
            'timelogs',
            'totalMinutes',
            'totalHours',
            'targetMinutes',
            'targetHours',
            'percent',
            'rank',
            'rankMessage',
            'character'
        ));
    }

 }

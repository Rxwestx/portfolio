<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\TimeLogs;
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

        // DBより、トータル時間計算を取得
        $totalTime = TimeLogs::where('user_id', Auth::id())
            ->sum('duration_minutes');
        // キャラクター情報（今後実装）
        // $character = Character::where('user_id', Auth::id())->first();

        // ビューにデータを渡す
    return view('timelogs.dashboard', compact('timelogs', 'totalTime'));
    }

 }

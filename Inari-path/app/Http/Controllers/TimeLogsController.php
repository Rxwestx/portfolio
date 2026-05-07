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
    /** * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $timeLogs = TimeLogs::whereHas('goal', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderByDesc('logged_at')->paginate(10);

        return view('timelogs.index', compact('timeLogs'));
    }

        // 学習記録一覧ではなくダッシュボード表示へ統一
        // return $this->dashboard();

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
            'goal_id' => $goalId,
            'logged_at' => $loggedAt,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return redirect()->route('timelogs.index')
            ->with('message', '学習記録を保存しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeLogs $timeLog)
    {
        //  dd($timeLog);
        return view('timelogs.show', compact('timeLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeLogs $timeLog)
    {
        return view('timelogs.edit', compact('timeLog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeLogs $timeLog)
    {
        $validated = $request->validate([
            'study_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $timeLog->update([
            'logged_at' => Carbon::parse($validated['study_date'])->startOfDay(),
            'duration_minutes' => $validated['duration_minutes'],
        ]);

        return redirect()->route('timelogs.show', $timeLog)
            ->with('message', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeLogs $timeLog)
    {
        $timeLog->delete();
        return redirect()->route('timelogs.index')
            ->with('message', '削除しました');
    }
    /**
     * キャラクター詳細（/dashboard）
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // ========== ランクダウンチェック処理(共通メソッドを利用)==========
        $daysSinceLastLog = $this->getDaysSinceLastLog($userId);

        $character = Character::firstOrCreate(
            ['user_id' => $userId],
            [
                'exp' => 0,
                'rank' => 0,
                'rank_name' => '弱った狐',
                'rank_message' => '弱った狐',
                'is_penalized' => false,
            ]
        );

        if ($daysSinceLastLog >= 3 && !$character->is_penalized) {
            // ランクダウン処理　oldRankNameを取得作る
            $oldRankName = $character->rank_name;
            $newRankName = Character::getRankNameFromLevel(max(0, $character->rank - 1));
            $character->is_penalized = true;
            $character->last_rank_down_at = now();
            $character->save();

            session([
                'show_rank_down_alert' => true,
                'old_rank_name' => $oldRankName,
                'days_since_last_log' => $daysSinceLastLog,
                'new_rank_name' => $newRankName,
            ]);
        }

        // ========== 学習記録一覧取得 ==========
        $timeLogs = TimeLogs::whereHas('goal', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->orderBy('logged_at', 'desc')
            ->limit(10)
            ->get();

         //DBより、目標を取得
        $goal = Goal::where('user_id', Auth::id())
            ->latest('id')
            ->value('goal');

        // DBより、トータル時間を取得し集計
        $totalMinutes = TimeLogs::whereHas('goal', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->sum('duration_minutes');


        // ダッシュボード用に分を時間に変換（小数1桁で丸め）
        $totalHours = round($totalMinutes / 60, 1);

        // 目標総時間取得
        $targetHours = Goal::where('user_id', Auth::id())
            ->latest('id')
            ->value('target_hours');
        // 時間を分に変換
        $targetMinutes = $targetHours ? $targetHours * 60 : 0;
        $rankMessages = [
            0 => 'まだ何も始まっていない。
                    けれど、この場所に立ったという事実が、すでに最初の一歩だ。',
            1 => '歩き出した狐。
                    小さな一歩が、大きな変化を生むことを知っている。',
            2 => '学びを覚えた狐。
                    知識の風が、小狐の周りを吹き抜ける。',
            3 => '習慣を手にした狐。
                    継続の力が、彼の将来へ大きく影響するだろう。',
            4 => '自信を持ち始めた狐。
                    挑戦を恐れず、前へ進む勇気が芽生える。',
            5 => '分岐点たった狐。
                    学びが「やること」から「生き方」へ変わり始めた。',
            6 => '考える狐。
                    深い思索が、狐の知恵を広げる。',
            7 => '自立した狐は、七尾の力を得た。
                    自分の道を切り開き、他者にも光をもたらす。',
            8 => '覚悟を宿す狐。
                    簡単ではない道を選び、それでも進み続ける。',
            9 => '妖狐の境界に達した狐。
                    限界を超え、新たな高みへと挑む。',
            10 => '覚醒せし妖狐。
                    学びの旅は終わらない。新たな伝説が、今ここに始まる。',
        ];

        // 累計学習時間から本来の達成率を計算する(ランクは最大10なので、ここは 100% で止める)
        $basePercent = $targetMinutes > 0 ? min(100, floor(($totalMinutes / $targetMinutes) * 100)) : 0;

        // ペナルティ中だけ、表示用達成率を1ランク分下げる
        $displayPercent = $character->is_penalized ? max(0, $basePercent - 10) : $basePercent;

        // 画面表示と保存値は、ペナルティ反映後のランクに揃える
        $displayRank = min(10, intdiv($displayPercent, 10));
        $percent = $displayPercent;
        $rank = $displayRank;

        // ランク名とメッセージも表示ランクに揃える
        $rankName = Character::getRankNameFromLevel($displayRank);
        $rankMessage = $rankMessages[$displayRank];

        $character->rank = $displayRank;
        $character->rank_name = $rankName;
        $character->rank_message = $rankMessage;
        // 総学習時間をEXPとして記録
        $character->exp = $totalMinutes;
        $character->save();

        // 週間集計用のデータ作成
        $weeklyData = [];

        // week_offset を取る
        $weekOffset = (int) request('week_offset', 0);
        $monthOffset = (int) request('month_offset', 0);
        $yearOffset = (int) request('year_offset', 0);

        $chartData = $this->buildChartData($weekOffset, $monthOffset, $yearOffset);
        $weeklyData = $chartData['weeklyData'];
        $monthlyData = $chartData['monthlyData'];
        $yearlyData = $chartData['yearlyData'];

        return view('timelogs.dashboard', compact(
            'timeLogs',
            'goal',
            'totalMinutes',
            'totalHours',
            'targetMinutes',
            'targetHours',
            'percent',
            'rank',
            'rankName',
            'rankMessage',
            'character',
            'weeklyData',
            'weekOffset',
            'monthlyData',
            'monthOffset',
            'yearlyData',
            'yearOffset'
        ));
    }
        public function chartData(Request $request)
    {
        $weekOffset = (int) $request->query('week_offset', 0);
        $monthOffset = (int) $request->query('month_offset', 0);
        $yearOffset = (int) $request->query('year_offset', 0);

        $chartData = $this->buildChartData($weekOffset, $monthOffset, $yearOffset);

        return response()->json([
            'weeklyData' => $chartData['weeklyData'],
            'monthlyData' => $chartData['monthlyData'],
            'yearlyData' => $chartData['yearlyData'],
            'weekOffset' => $weekOffset,
            'monthOffset' => $monthOffset,
            'yearOffset' => $yearOffset,
        ]);
    }
    // 最新の学習記録からの経過日数を計算する共通メソッド
    private function getDaysSinceLastLog(int $userId): int
    {
        $latestLog = TimeLogs::whereHas('goal', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->latest('logged_at')
            ->first();
        // 最新記録からの経過日数を計算
        if (!$latestLog) {
            return 999;
        }

        return (int) $latestLog->logged_at->diffInDays(now());
    }

    private function buildChartData(int $weekOffset, int $monthOffset, int $yearOffset): array
    {
        $userId = Auth::id();
        $weeklyData = [];
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY)->addWeeks($weekOffset);

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dateKey = $currentDate->format('Y-m-d');

            $minutes = TimeLogs::whereHas('goal', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereDate('logged_at', $dateKey)->sum('duration_minutes');

            $weeklyData[$dateKey] = $minutes ?? 0;
        }

        $monthlyData = [];
        $startOfMonth = now()->startOfMonth()->addMonths($monthOffset);
        $daysInMonth = $startOfMonth->daysInMonth;
        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDate = $startOfMonth->copy()->addDays($i);
            $date = $currentDate->format('Y-m-d');
            $minutes = TimeLogs::whereHas('goal', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereDate('logged_at', $date)->sum('duration_minutes');

            $monthlyData[$date] = $minutes ?? 0;
        }

        $yearlyData = [];
        $startOfYear = now()->startOfYear()->addYears($yearOffset);
        for ($i = 0; $i < 12; $i++) {
            $currentMonth = $startOfYear->copy()->addMonths($i);
            $month = $currentMonth->format('Y-m');

            $minutes = TimeLogs::whereHas('goal', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereRaw("to_char(logged_at, 'YYYY-MM') = ?", [$month])->sum('duration_minutes');
            $yearlyData[$month] = $minutes ?? 0;
        }

        return [
            'weeklyData' => $weeklyData,
            'monthlyData' => $monthlyData,
            'yearlyData' => $yearlyData,
        ];
    }
}

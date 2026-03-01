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
        $userId = Auth::id();
            // ========== ランクダウンチェック処理 ==========

    // 最新の学習記録を取得
    $latestLog = TimeLogs::whereHas('goal', function ($query) {
        $query->where('user_id', Auth::id());
    })
    ->latest('logged_at')
    ->first();

    // 最新記録からの経過日数を計算
    if ($latestLog) {
        $daysSinceLastLog = (int)$latestLog->logged_at->diffInDays(now());
    } else {
        $daysSinceLastLog = 999;
    }

    // 3日以上経過 & 未通知の場合
    $notificationKey = 'rank_down_notified_' . Auth::id();

    if ($daysSinceLastLog >= 3 && !session($notificationKey)) {
        $tempCharacter = Character::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'exp' => 0,
                'rank' => 0,
                'rank_name' => '弱った狐',
                'rank_message' => '',
            ]
        );

        if ($tempCharacter->rank > 0) {
            $oldRank = $tempCharacter->rank;
            $tempCharacter->rank = $tempCharacter->rank - 1;

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

            $tempCharacter->rank_message = $rankMessages[$tempCharacter->rank];
            $tempCharacter->save();

            session([
                'show_rank_down_alert' => true,
                'old_rank' => $oldRank,
                'new_rank' => $tempCharacter->rank,
                'days_inactive' => $daysSinceLastLog,
                $notificationKey => true
            ]);
        }
    }

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
        // ========== ランクダウンチェック処理==========

    // 1. このユーザーの最新の学習記録を1件だけ取得
    $latestLog = TimeLogs::whereHas('goal', function ($query) {
        $query->where('user_id', Auth::id());
    })
    ->latest('logged_at')
    ->first();

    // 2. 最新の学習記録から今日まで何日経ったか計算
    if ($latestLog) {
        $daysSinceLastLog = (int)$latestLog->logged_at->diffInDays(now());
    } else {
        $daysSinceLastLog = 999;
    }

    // 3. 3日以上経過していて、まだ通知していない場合
    $notificationKey = 'rank_down_notified_' . Auth::id();

    if ($daysSinceLastLog >= 3 && !session($notificationKey)) {
        // キャラクターを取得
        $tempCharacter = Character::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'exp' => 0,
                'rank' => 0,
                'rank_name' => '弱った狐',
                'rank_message' => '弱った狐',
            ]
        );

        // ランクダウン実行
        if ($tempCharacter->rank > 0) {
            $oldRank = $tempCharacter->rank;
            // 元のランク名を保存
            $oldRankName = $tempCharacter->rank_name;

            // ランクを1つ下げる
            $tempCharacter->rank = $tempCharacter->rank - 1;

            // 新しいランク名を設定
            $tempCharacter->rank_name = Character::getRankNameFromLevel($tempCharacter->rank);

            // rank_messageは既存のものを使うか、必要に応じて更新
            $tempCharacter->save();

            // ポップアップ表示用データをセッションにランク名を保存
            session([
                'show_rank_down_alert' => true,
                'old_rank_name' => $oldRankName,
                'new_rank_name' => $tempCharacter->rank_name,
                'days_inactive' => $daysSinceLastLog,
                $notificationKey => true
            ]);
        }
    }

    // ========== ランクダウンチェック処理 ==========
    $timeLogs = TimeLogs::whereHas('goal', function ($query) {
        $query->where('user_id', Auth::id());
    })
        ->orderBy('logged_at', 'desc')
        ->limit(10)
        ->get();

    // 1. このユーザーの最新の学習記録を1件だけ取得
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
        // 達成率の計算 目標が 0 なら、達成率も 0% とし、小数をパーセントに変換
        $percent = $targetMinutes > 0
            ? min(100, floor(($totalMinutes / $targetMinutes) * 100))
            : 0;
        // ランクの計算（例: 10%ごとにランクアップ、最大ランク10）
        $rank = min(10, intdiv($percent, 10));

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
        $rankMessage = $rankMessages[$rank];
        $rankName = Character::getRankNameFromLevel($rank);

        // ========== キャラクター操作 ==========
        // 1. 現在のユーザーがキャラクターを持っているか確認
        // 持っていなければ初期状態で作成、持っていれば取得
        $character = Character::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'exp' => 0,
                'rank' => 0,
                'rank_name' => '弱った狐',
                'rank_message' => '弱った狐',
            ]
        );
        // 2. 計算した達成率に基づいてキャラクターのランクとメッセージを更新
        $character->rank = $rank;
        $character->rank_name = $rankName;
        $character->rank_message = $rankMessage;

        // 総学習時間をEXPとして記録
        $character->exp = $totalMinutes;
        $character->save();

        // 週間集計用のデータ作成
        $weeklyData = [];

        // week_offset を取る
        $weekOffset = (int) request('week_offset', 0);
        // 月曜0：00を週の始まりとする
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY)->addWeeks($weekOffset);

        //  7日分をループして、1日ごとに集計する
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dateKey = $currentDate->format('Y-m-d');

            $minutes = TimeLogs::whereHas('goal', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereDate('logged_at', $dateKey)
            ->sum('duration_minutes');

            $weeklyData[$dateKey] = $minutes ?? 0;
        }

        // 月間集計用のデータ作成
        $monthlyData = [];
        // month_offset を取る
        $monthOffset = (int) request('month_offset', 0);
        $startOfMonth = now()->startOfMonth()->addMonths($monthOffset);
        //毎月1日0:00を月の始まりとし、月末日数可変
        $daysInMonth = $startOfMonth->daysInMonth;
        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDate = $startOfMonth->copy()->addDays($i);
            $date = $currentDate->format('Y-m-d');
            $minutes = TimeLogs::whereHas('goal', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->whereDate('logged_at', $date)
                ->sum('duration_minutes');

            $monthlyData[$date] = $minutes ?? 0;
        }

        // 年別集計（過去12ヶ月）
        $yearlyData = [];
        // yar_offset を取る
        $yearOffset = (int) request('year_offset', 0);
        $startOfYear = now()->startOfYear()->addYears($yearOffset);
        // 毎年1月1日0:00を年の始まりとし、過去12ヶ月分をループ
        for ($i = 0; $i < 12; $i++) {
            $currentMonth = $startOfYear->copy()->addMonths($i);
            $month = $currentMonth->format('Y-m');

            $minutes = TimeLogs::whereHas('goal', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->whereRaw("to_char(logged_at, 'YYYY-MM') = ?", [$month])
                ->sum('duration_minutes');
            $yearlyData[$month] = $minutes ?? 0;
        }

        // ビューへデータを渡す（学習記録、時間情報、達成率・ランク、キャラクター情報をダッシュボードに送信）
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
            "weekOffset",
            'monthlyData',
            'monthOffset',
            'yearlyData',
            'yearOffset'
        ));
    }

}

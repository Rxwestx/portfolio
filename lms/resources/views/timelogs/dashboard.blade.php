<x-app-layout>
    {{-- ランクダウン通知モーダル --}}
    @if (session('show_rank_down_alert'))
        <x-rank-down-modal
            :oldRankName="session('old_rank_name')"
            :newRankName="session('new_rank_name')"
            :daysInactive="session('days_inactive')"
        />
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>
    <!-- ========== キャラクター詳細セクション ========== -->
    <section class="character-section mt-24 px-4 text-gray-600">
        <h2 class="text-2xl font-bold text-center flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/clock.svg') }}" alt="icon" width="32" height="32" />
            <span>キャラクター詳細と達成状況</span>
        </h2>

        <div class="bg-blade-neon rounded-lg shadow mt-8 p-8">
            <!-- キャラクター画像（ランク値に応じて自動選択） -->
            <div class="mb-4 text-center">
                <!-- コメント: $rank の値（0～10）から自動的に画像ファイルを選ぶ -->
                <!-- 例: $rank = 7 の場合、rank_7.png が表示される -->
                <img src="{{ asset('img/characters/rank_' . $rank . '.png') }}" alt="ランク{{ $rank }}キャラクター"
                    class="w-64 h-64 mx-auto rounded-lg shadow-lg object-cover">
            </div>

            <!-- キャラクター情報テーブル -->
            <table class="text-center border-collapse mx-auto">
                <tr class="border-b">
                    <td class="py-2 px-2 font-light">目標：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $goal ?? '未設定' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light">ランク名：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $rankName }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light">目標時間：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $targetHours }}時間</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light">総学習時間：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $totalHours }}時間</td>
                </tr>
                {{-- <tr class="border-b">
                    <td class="py-2 px-2 font-light">レベル：</td>
                    <td class="py-2 px-2 font-normal text-blade-dark">{{ $character->level }}</td>
                </tr> --}}
                <tr class="border-b">
                    <td class="py-2 px-2 font-light">ランクメッセージ：</td>
                    <td class="py-2 px-2 font-normal text-blade-dark">{{ $character->rank_message }}</td>
                </tr>
            </table>
        </div>
    </section>

    <!-- ========== 週別と月間別グラフ表示 ========== -->
    <section class="text-center border-collapse  mt-8 px-4 mx-auto text-gray-600">
        <h2 class="text-2xl font-bold mb-4 flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/stats-bars.svg') }}" alt="icon" width="32" height="32" />
            <span>グラフ</span>
        </h2>

        <div class="bg-blade-neon rounded-lg shadow p-4">
            <!-- グラフコンポーネントを呼び出し -->
            <x-chart-tabs :weeklyData="$weeklyData" :monthlyData="$monthlyData" :yearlyData="$yearlyData" />
        </div>
    </section>

    <!-- ========== 学習記録一覧 ========== -->
    <section class="records-section text-center border-collapse mt-8 px-4 mx-auto text-gray-600">
        <h2 class="text-2xl font-bold mb-4 text-center flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/quill.svg') }}" alt="icon" width="32" height="32" />
            <span>最近の学習記録</span>
        </h2>
        <div class="bg-blade-neon rounded-lg shadow overflow-hidden">
            <table class="text-center mx-auto">
                <thead class="bg-gray-300 border-b font-bold">
                    <tr>
                        <th class="py-3 px-4">日付</th>
                        <th class="py-3 px-4">学習時間</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timeLogs as $timeLog)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $timeLog->logged_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-4">{{ $timeLog->duration_minutes }} 分</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">
                                学習記録がありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>

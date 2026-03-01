<x-app-layout>
    {{-- ランクダウン通知モーダル --}}
    {{-- @if (session('show_rank_down_alert'))
        <x-rank-down-modal :oldRankName="session('old_rank_name')" :newRankName="session('new_rank_name')" :daysInactive="session('days_inactive')" />
        @php
            // 表示したら、セッションから削除して再表示を防ぐ
            session()->forget(['show_rank_down_alert', 'old_rank_name', 'new_rank_name', 'days_inactive']);
        @endphp
    @endif --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>
    <!-- ========== キャラクター詳細セクション ========== -->
    <section class="character-section mt-8 px-4 text-gray-600 w-full max-w-xl mx-auto">
        <h2 class="font-bold text-center flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/clock.svg') }}" alt="icon" width="32" height="32" />
            <span class="text-lg sm435:text-2xl">キャラクター詳細と達成状況</span>
        </h2>

        <div class="bg-blade-neon rounded-3xl shadow mt-8 p-4 sm:p-6 md:p-8">
            <!-- キャラクター画像（ランク値に応じて自動選択） -->
            <div class="mb-4 text-center">
                <!-- コメント: $rank の値（0～10）から自動的に画像ファイルを選ぶ -->
                <!-- 例: $rank = 7 の場合、rank_7.png が表示される -->
                <img src="{{ asset('img/characters/rank_' . $rank . '.png') }}" alt="ランク{{ $rank }}キャラクター"
                    class="w-48 h-48 sm:w-64 sm:h-64 md:w-80 md:h-80 mx-auto rounded-3xl shadow-lg object-cover">
            </div>

            <!-- キャラクター情報（モバイル）長文のレイアウト崩れ対策済み -->
            <dl class="sm:hidden space-y-3 text-left">
                <div class="border-b pb-3">
                    <dt class="text-sm font-light text-gray-600">目標:</dt>
                    <dd class="text-base font-normal text-blade-dark">{{ $goal ?? '未設定' }}</dd>
                </div>
                <div class="border-b pb-3">
                    <dt class="text-sm font-light text-gray-600">ランク名:</dt>
                    <dd class="text-base font-normal text-blade-dark">{{ $rankName }}</dd>
                </div>
                <div class="border-b pb-3">
                    <dt class="text-sm font-light text-gray-600">目標時間:</dt>
                    <dd class="text-base font-normal text-blade-dark">{{ $targetHours }}時間</dd>
                </div>
                <div class="border-b pb-3">
                    <dt class="text-sm font-light text-gray-600">総学習時間:</dt>
                    <dd class="text-base font-normal text-blade-dark">{{ $totalHours }}時間</dd>
                </div>
                <div class="border-b pb-3">
                    <dt class="text-sm font-light text-gray-600">ランクメッセージ:</dt>
                    <dd class="text-base font-normal text-blade-dark break-words">{{ $character->rank_message }}</dd>
                </div>
            </dl>

            <!-- キャラクター情報テーブル（タブレット以上） -->
            <table class="hidden sm:table w-full border-collapse mx-auto text-left">
                <tr class="border-b">
                    <td class="py-2 px-2 font-light w-1/3">目標：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $goal ?? '未設定' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light w-1/3">ランク名：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $rankName }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light w-1/3">目標時間：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $targetHours }}時間</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light w-1/3">総学習時間：</td>
                    <td class="py-2 px-2 text-base font-normal text-blade-dark">{{ $totalHours }}時間</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-2 font-light w-1/3 align-top">ランクメッセージ：</td>
                    <td class="py-2 px-2 font-normal text-blade-dark break-words">{{ $character->rank_message }}</td>
                </tr>
            </table>
        </div>
    </section>

    <!-- ========== 週別と月間別グラフ表示 ========== -->
    <section class="text-center border-collapse mt-8 px-4 mx-auto text-gray-600 w-full max-w-xl">
        <h2 class="font-bold mb-4 flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/stats-bars.svg') }}" alt="icon" width="32" height="32" />
            <span class="text-lg sm435:text-2xl">グラフ</span>
        </h2>

        <div class="bg-blade-neon rounded-3xl shadow p-4 sm:p-6 md:p-8 w-full">
            <!-- グラフコンポーネントを呼び出し -->
            <x-chart-tabs :weeklyData="$weeklyData" :monthlyData="$monthlyData" :yearlyData="$yearlyData" :weekOffset="$weekOffset" :monthOffset="$monthOffset" :yearOffset="$yearOffset" />
        </div>
    </section>

    <!-- ========== 学習記録一覧 ========== -->
    <section class="records-section text-center border-collapse mt-8 px-4 mx-auto text-gray-600 w-full max-w-xl">
        <h2 class="font-bold mb-4 text-center flex items-center justify-center gap-2">
            <img src="{{ asset('img/icons/quill.svg') }}" alt="icon" width="32" height="32" />
            <span class="text-lg sm435:text-2xl">最近の学習記録</span>
        </h2>
        <div class="bg-blade-neon rounded-3xl shadow overflow-hidden p-4 sm:p-6 md:p-8">
            <table class="text-center mx-auto">
                <thead class="bg-gray-300 border-b font-bold">
                    <tr>
                        <th class="py-3 px-4 rounded-tl-3xl">日付</th>
                        <th class="py-3 px-4 rounded-tr-3xl">学習時間</th>
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

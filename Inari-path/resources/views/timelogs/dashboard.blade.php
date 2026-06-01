<x-app-layout>
    {{-- ランクダウン通知モーダル --}}
    @if (session('show_rank_down_alert'))
        <x-rank-down-modal :oldRankName="session('old_rank_name')" :newRankName="session('new_rank_name')" :daysSinceLastLog="session('days_since_last_log')" />
        @php
            // 表示したら、セッションから削除して再表示を防ぐ
            session()->forget(['show_rank_down_alert', 'old_rank_name', 'new_rank_name', 'days_since_last_log']);
        @endphp
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>
    @php
        $progressPercent = $targetHours > 0 ? min(100, round(($totalHours / $targetHours) * 100)) : 0;
    @endphp
    <!-- ========== キャラクター詳細セクション ========== -->
    <section class="character-section inari-section inari-dashboard-section text-gray-600">
        <h2 class="inari-section-heading">
            <img src="{{ asset('img/icons/clock.svg') }}" alt="icon" width="32" height="32" class="inari-heading-icon" />
            <span>キャラクター詳細と達成状況</span>
        </h2>

        <div class="inari-card inari-dashboard-hero border-blade-neon/40 bg-white/90">
            <!-- キャラクター画像（ランク値に応じて自動選択） -->
            <div class="inari-dashboard-character text-center">
                <!-- コメント: $rank の値（0～10）から自動的に画像ファイルを選ぶ -->
                <!-- 例: $rank = 7 の場合、rank_7.png が表示される -->
                <img src="{{ asset('img/characters/rank_' . $rank . '.png') }}" alt="ランク{{ $rank }}キャラクター"
                    class="inari-character-image">
            </div>

            <!-- キャラクター情報 -->
            <div class="inari-dashboard-status">
                <dl class="inari-dashboard-stats text-left">
                    <div class="inari-dashboard-rank">
                        <dt>ランク名:</dt>
                        <dd>{{ $rankName }}</dd>
                    </div>
                    <div>
                        <dt>目標:</dt>
                        <dd>{{ $goal ?? '未設定' }}</dd>
                    </div>
                    <div>
                        <dt>目標時間:</dt>
                        <dd>{{ $targetHours }}時間</dd>
                    </div>
                    <div>
                        <dt>総学習時間:</dt>
                        <dd>{{ $totalHours }}時間</dd>
                    </div>
                    <div class="inari-dashboard-message">
                        <dt>ランクメッセージ:</dt>
                        <dd>{{ $character->rank_message }}</dd>
                    </div>
                </dl>

                <div class="inari-progress-block">
                    <div class="inari-progress-label">
                        <span>達成率:</span>
                        <span>{{ $progressPercent }}%</span>
                    </div>
                    <div class="inari-progress" aria-hidden="true">
                        <div style="width: {{ $progressPercent }}%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- ========== 週別と月間別グラフ表示 ========== -->
        <section class="inari-section mx-auto text-gray-600">
            <h2 class="inari-section-heading">
                <img src="{{ asset('img/icons/stats-bars.svg') }}" alt="icon" width="32" height="32" class="inari-heading-icon" />
                <span>グラフ</span>
            </h2>

            <div class="inari-card border-blade-neon/40 bg-white/90">
                <!-- グラフコンポーネントを呼び出し -->
                <x-chart-tabs :weeklyData="$weeklyData" :monthlyData="$monthlyData" :yearlyData="$yearlyData" :weekOffset="$weekOffset" :monthOffset="$monthOffset" :yearOffset="$yearOffset" />
            </div>
        </section>

        <!-- ========== 学習記録一覧 ========== -->
        <section class="records-section inari-section mx-auto text-gray-600">
            <h2 class="inari-section-heading">
                <img src="{{ asset('img/icons/quill.svg') }}" alt="icon" width="32" height="32" class="inari-heading-icon" />
                <span>最近の学習記録</span>
            </h2>
            <div class="inari-card overflow-hidden border-blade-neon/40 bg-white/90 !p-0">
                <table class="w-full text-left text-sm sm:text-base">
                    <thead class="bg-blade-soft text-xs font-semibold uppercase text-gray-600 sm:text-sm">
                        <tr>
                            <th class="px-4 py-3 sm:px-5">日付</th>
                            <th class="px-4 py-3 text-right sm:px-5">学習時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeLogs as $timeLog)
                            <tr class="border-b border-blade-neon/30 last:border-b-0">
                                <td class="px-4 py-3 sm:px-5">{{ $timeLog->logged_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900 sm:px-5">{{ $timeLog->duration_minutes }} 分</td>
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

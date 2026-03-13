<!-- グラフとタブの切り替えコンポーネント -->
<script type="application/json" id="weeklyData">
    {!! json_encode($weeklyData ?? []) !!}
</script>
<script type="application/json" id="monthlyData">
    {!! json_encode($monthlyData ?? []) !!}
</script>
<script type="application/json" id="yearlyData">
    {!! json_encode($yearlyData ?? []) !!}
</script>

<!-- タブ切り替えコンポーネント -->
<div x-data="chartTabs" class="mb-8 w-full" data-week-offset="{{ $weekOffset ?? 0 }}"
    data-month-offset="{{ $monthOffset ?? 0 }}" data-year-offset="{{ $yearOffset ?? 0 }}">
    <!-- タブボタン -->
    <div class="mb-2 flex items-center gap-3">
        <button type="button" @click="setTab('weekly')" :disabled="isLoading"
            :class="activeTab === 'weekly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="rounded px-4 py-2 font-semibold transition">
            Week
        </button>
        <button type="button" @click="setTab('monthly')" :disabled="isLoading"
            :class="activeTab === 'monthly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="rounded px-4 py-2 font-semibold transition">
            Month
        </button>
        <button type="button" @click="setTab('yearly')" :disabled="isLoading"
            :class="activeTab === 'yearly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="rounded px-4 py-2 font-semibold transition">
            Year
        </button>
    </div>

    <div class="my-5 flex w-full flex-wrap items-center justify-center gap-2 text-sm sm:text-base">
        <!-- 年月表示 -->
        <button type="button" :disabled="isLoading"
            @click="activeTab === 'weekly' ? changeWeekOffset(-1) : activeTab === 'monthly' ? changeMonthOffset(-1) : activeTab === 'yearly' ? changeYearOffset(-1) : null">
            &lt;
        </button>
        <div class="px-1 text-center font-semibold text-gray-600" x-text="getPeriodLabel()"></div>
        <button type="button" :disabled="isLoading"
            @click="activeTab === 'weekly' ? changeWeekOffset(1) : activeTab === 'monthly' ? changeMonthOffset(1) : activeTab === 'yearly' ? changeYearOffset(1) : null">
            &gt;
        </button>
    </div>

    <!-- グラフコンテナ -->
    <div id="chart" class="relative mt-6 w-full rounded-lg bg-blade-pale p-3 shadow sm:p-6">
        {{-- レイアウトを動かさないため、読み込み中は重ね表示 --}}
        <div x-show="isLoading" x-cloak
            class="absolute inset-0 z-10 grid place-items-center rounded-lg bg-white/60 text-sm text-gray-700 backdrop-blur-[1px]">
            読み込み中...
        </div>

        {{-- fetch失敗時は同じ位置にエラーと再試行導線を重ねて表示する --}}
        <div x-show="!isLoading && error" x-cloak
            class="absolute inset-0 z-10 grid place-items-center rounded-lg bg-white/70 text-sm text-red-500">
            <div class="flex flex-wrap items-center justify-center gap-3 px-4 text-center">
                <span x-text="error"></span>
                <button type="button" @click="fetchChartData()"
                    class="rounded bg-red-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-600">
                    再試行
                </button>
            </div>
        </div>

        {{-- 記録が未作成、または表示期間の値が全て0なら空メッセージを出す --}}
        <div x-show="!error && isCurrentDataEmpty()" class="py-4 text-center text-sm text-gray-500">
            データがありません
        </div>

        {{-- グラフ枠は残し、エラー時だけ非表示にする --}}
        <div class="h-64 w-full overflow-x-auto pb-2" x-show="!error"
            {{-- 週タブはスマホのみ横スクロール、sm以上は隠す --}}
            :class="activeTab === 'weekly' ? 'sm:overflow-x-hidden' : ''">
            <div class="flex min-w-full w-max items-end justify-center gap-3"
                :class="activeTab === 'weekly' ? '' : 'min-w-max'">
                <template x-for="(value, date) in getCurrentData()" :key="date">
                    <div class="w-12 shrink-0 flex flex-col items-center sm:w-10">
                        <div class="flex h-40 w-full items-end">
                            <!-- バーグラフ -->
                            <div class="mx-auto w-6 rounded-t bg-blade-main"
                                :style="`height: ${getBarHeight(value, Math.max(0,...Object.values(getCurrentData())))}%`">
                            </div>
                        </div>
                        <div class="mt-2 flex min-h-11 flex-col items-center justify-center text-center leading-tight sm:h-10">
                            <!-- 日付・分ラベル 折り返し禁止 -->
                            <p class="whitespace-nowrap text-sm text-gray-600" x-text="formatDateLabel(date)"></p>
                            <p class="whitespace-nowrap text-sm font-normal text-gray-600" x-text="formatMinutes(value)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

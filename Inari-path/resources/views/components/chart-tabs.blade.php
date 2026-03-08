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
        {{-- 読み込み中 --}}
        <div x-show="isLoading" x-cloak class="text-sm text-gray-500 my-2">
            読み込み中...</div>
        {{-- エラー --}}
        <div x-show="error" x-cloak class="my-2 flex items-center gap-3 text-sm text-red-500">
            <span x-text="error"></span>
            <button type="button" @click="fetchChartData()"
                class="rounded bg-red-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-600">
                再試行
            </button>
    </div>
    <!-- タブボタン -->
    <div class="flex gap-3 mb-2 items-center">
        <button type="button" @click = "setTab('weekly')"
            :class="activeTab === 'weekly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
            Week
        </button>
        <button type="button" @click = "setTab('monthly')"
            :class="activeTab === 'monthly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
            Month
        </button>
        <button type="button" @click = "setTab('yearly')"
            :class="activeTab === 'yearly' ? 'bg-blade-dark text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
            Year
        </button>
    </div>
    <div class="w-full flex flex-wrap items-center justify-center gap-2 text-sm sm:text-base my-5">
        <!-- 年月表示 -->
        <button type="button" @click="activeTab === 'weekly' ? changeWeekOffset(-1) : activeTab === 'monthly' ? changeMonthOffset(-1) : activeTab === 'yearly' ? changeYearOffset(-1) : null">
            &lt;
        </button>
        <div class="text-gray-600 font-semibold text-center px-1" x-text="getPeriodLabel()"></div>
        <button type="button" @click="activeTab === 'weekly' ? changeWeekOffset(1) : activeTab === 'monthly' ? changeMonthOffset(1) : activeTab === 'yearly' ? changeYearOffset(1) : null">
            &gt;
        </button>
    </div>

    <!-- グラフコンテナ -->
    <div id="chart" x-show="!isLoading" class="bg-blade-pale rounded-lg shadow p-3 sm:p-6 w-full mt-6">
        <div x-show="!error && Object.keys(getCurrentData()).length === 0" class="py-10 text-sm text-gray-500">
            データがありません
        </div>
        <div class="h-64 w-full overflow-x-auto pb-2"
            x-show="!error && Object.keys(getCurrentData()).length > 0"
        {{-- 週タブはスマホのみ横スクロール、sm以上は隠す --}}
            :class="activeTab === 'weekly' ? 'sm:overflow-x-hidden' : ''">
            <div class="flex items-end gap-3 justify-center w-max min-w-full"
                :class="activeTab === 'weekly' ? '' : 'min-w-max'">
                <template x-for="(value, date) in getCurrentData()" :key="date">
                    <div class="flex flex-col items-center w-12 sm:w-10 shrink-0">
                        <div class="w-full h-40 flex items-end">
                            <!-- バーグラフ -->
                            <div class="w-6 mx-auto bg-blade-main rounded-t"
                                :style="`height: ${getBarHeight(value, Math.max(0,...Object.values(getCurrentData())))}%`">
                            </div>
                        </div>
                        <div class="mt-2 min-h-11 sm:h-10 flex flex-col items-center justify-center text-center leading-tight">
                            <!-- 日付・分ラベル 折り返し禁止 -->
                            <p class="text-sm text-gray-600 whitespace-nowrap" x-text="formatDateLabel(date)"></p>
                            <p class="text-sm text-gray-600 font-normal whitespace-nowrap" x-text="formatMinutes(value)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

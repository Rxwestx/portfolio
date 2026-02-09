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
    data-month-offset="{{ $monthOffset ?? 0 }}">
    <!-- タブボタン -->
    <div class="flex gap-3 mb-4 items-center">
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
        <div class="ml-auto flex items-center gap-2">
            <!-- 年月表示 -->
            <button type="button"
                @click="activeTab === 'weekly' ? changeWeekOffset(-1) : changeMonthOffset(-1)">&lt;</button>
            <div class="ml-auto text-gray-600 font-semibold text-center" x-text="getPeriodLabel()"></div>
            <button type="button"
                @click="activeTab === 'weekly' ? changeWeekOffset(1) : changeMonthOffset(1)">&gt;</button>
        </div>
    </div>

    <!-- グラフコンテナ -->
    <div id="chart" class="bg-blade-pale rounded-lg shadow p-6 w-full">
        <div class="h-64 overflow-x-auto w-full">
            <div class="flex items-end gap-2 justify-center w-full min-w-[640px]">
                <template x-for="(value, date) in getCurrentData()" :key="date">
                    <div class="flex flex-col items-center w-10">
                        <div class="w-full h-40 flex items-end">
                            <!-- バーグラフ -->
                            <div class="w-6 mx-auto bg-blade-main rounded-t"
                                :style="`height: ${getBarHeight(value, Math.max(0,...Object.values(getCurrentData())))}%`">
                            </div>
                        </div>
                        <div class="mt-2 h-10 flex flex-col items-center justify-center">
                            <!-- ラベル -->
                            <p class="text-xs text-gray-600" x-text="formatDateLabel(date)"></p>
                            <p class="text-xs text-gray-600 font-normal" x-text="formatMinutes(value)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

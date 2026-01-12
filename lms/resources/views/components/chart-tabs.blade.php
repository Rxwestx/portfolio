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
<div x-data="chartTabs" class="mb-8">
    <!-- タブボタン -->
    <div class="flex gap-2 mb-4">
        <button @click="setTab('weekly')"
            :class="activeTab === 'weekly' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
             週間
        </button>
        <button @click="setTab('monthly')"
            :class="activeTab === 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
             月間
        </button>
        <button @click="setTab('yearly')"
            :class="activeTab === 'yearly' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'"
            class="px-4 py-2 rounded font-semibold transition">
             年別
        </button>
     </div>

    <!-- グラフコンテナ -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="h-64 overflow-x-auto">
            <div class="flex items-end gap-2 justify-center">
                <template x-for="(value, date) in getCurrentData()" :key="date">
                    <div class="flex flex-col items-center flex-1 ">
                        <div class="w-full h-40 flex items-end">
                        <!-- バーグラフ -->
                            <div class="w-full bg-gradient-to-t from-blue-500 to-blue-400 rounded-t"
                                :style="`height: ${getBarHeight(value, Math.max(0,...Object.values(getCurrentData())))}%`">
                            </div>
                        </div>
                        <div class="mt-2 h-10 flex flex-col items-center justify-end">
                        <!-- ラベル -->
                        <p class="text-xs mt-2 text-gray-600" x-text="date"></p>
                        <p class="text-xs font-semibold" x-text="`${value}分`"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

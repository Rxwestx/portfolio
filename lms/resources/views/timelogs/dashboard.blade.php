<x-app-layout>
    <!-- ========== キャラクター詳細セクション ========== -->
    <section class="character-section mb-8 px-4">
        <h2 class="text-2xl font-bold">🎯キャラクター詳細と達成状況</h2>

        <div class="bg-white rounded-lg shadow p-6">
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
                    <td class="py-2 px-4 font-semibold">ランク名：</td>
                    <td class="py-2 px-4 text-lg font-bold ">{{ $rankMessage }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">目標時間：</td>
                    <td class="py-2 px-4 text-lg font-bold text-blue-600">{{ $targetHours }}時間</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">総学習時間：</td>
                    <td class="py-2 px-4 text-lg font-bold text-green-600">{{ $totalHours }}時間</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">レベル：</td>
                    <td class="py-2 px-4">{{ $character->level }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">ランクメッセージ：</td>
                    <td class="py-2 px-4">{{ $character->rank_message }}</td>
                </tr>
            </table>
        </div>
    </section>

    <!-- ========== 週別と月間別グラフ表示 ========== -->
    <section class="text-center border-collapse mx-auto">
        <h2 class="text-2xl font-bold mb-4">📊 グラフ</h2>

        <div class="bg-white rounded-lg shadow p-6">
            <!-- グラフコンポーネントを呼び出し -->
            <x-chart-tabs :weeklyData="$weeklyData" :monthlyData="$monthlyData" :yearlyData="$yearlyData" />
        </div>
    </section>

    {{-- <!-- ========== 学習記録一覧 ========== -->
    <section class="records-section px-4 text-center border-collapse mx-auto">
        <h2 class="text-2xl font-bold mb-4">📚 最近の学習記録</h2>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="text-center mx-auto">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="py-3 px-4">日付</th>
                        <th class="py-3 px-4">学習時間</th>
                        <th class="py-3 px-4">編集</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timelogs as $timelog)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $timelog->logged_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-4">{{ $timelog->duration_minutes }} 分</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('timelogs.edit', $timelog) }}"
                                    class="text-blue-500 hover:underline text-sm">編集</a>
                                <form method="post" action="{{ route('timelogs.destroy', $timelog) }}" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button class="text-red-500 hover:underline text-sm ml-2">削除</button>
                                </form>
                            </td>
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

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $timelogs->links() }}
        </div>
    </section> --}}
</x-app-layout>

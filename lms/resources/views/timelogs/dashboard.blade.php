<x-app-layout>
    <!-- ========== キャラクター詳細セクション ========== -->
    <div class="character-section mb-8">
        <h2 class="text-2xl font-bold mb-4">📊 キャラクター詳細</h2>

        <div class="bg-white rounded-lg shadow p-6">
            <!-- キャラクター画像（ランク値に応じて自動選択） -->
            <div class="mb-4 text-center">
                <!-- コメント: $rank の値（0～10）から自動的に画像ファイルを選ぶ -->
                <!-- 例: $rank = 7 の場合、rank_7.png が表示される -->
                <img src="{{ asset('img/characters/rank_' . $rank . '.png') }}"
                     alt="ランク{{ $rank }}キャラクター"
                     class="w-64 h-64 mx-auto rounded-lg shadow-lg object-cover">
            </div>

            <!-- キャラクター情報テーブル -->
            <table class="w-full text-left border-collapse">
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">ランク値</td>
                    <td class="py-2 px-4">{{ $rank }} / 10</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">ランク名</td>
                    <td class="py-2 px-4 text-lg font-bold text-blue-600">{{ $rankMessage }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">レベル</td>
                    <td class="py-2 px-4">{{ $character->level }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">EXP</td>
                    <td class="py-2 px-4">{{ $character->exp }} 分</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-semibold">ランクメッセージ</td>
                    <td class="py-2 px-4">{{ $character->rank_message }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ========== 達成率セクション ========== -->
    <div class="achievement-section mb-8">
        <h2 class="text-2xl font-bold mb-4">🎯 達成状況</h2>

        <div class="bg-white rounded-lg shadow p-6">
            <!-- 数値表示 -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded">
                    <p class="font-semibold text-sm">総学習時間</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalHours }}</p>
                    <p class="text-xs text-gray-500">時間</p>
                </div>
                <div class="bg-green-50 p-4 rounded">
                    <p class="font-semibold text-sm">目標時間</p>
                    <p class="text-2xl font-bold text-green-600">{{ $targetHours }} </p>
                    <p class="text-xs text-gray-500">時間</p>
                </div>
                <div class="bg-purple-50 p-4 rounded">
                    <p class="font-semibold text-sm">達成率</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $percent }}%</p>
                    <p class="text-xs text-black-500">まで達成</p>
                </div>
            </div>

                <!-- 進捗バー -->
            <div class="mb-4">
                <p class="text-sm font-semibold mb-2">進捗バー</p>
                <div class="w-full bg-gray-200 h-6 rounded-full overflow-hidden">
                    <!-- コメント: width を達成率（percent）% に設定して、進捗を視覚化 -->
                    <!-- 例: 75% なら、バーが画面の75%を埋める -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-full transition-all duration-500"
                         style="width: {{ $percent }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percent }}% / 100%</p>
            </div>
        </div>
    </div>

        <!-- ========== 学習記録一覧 ========== -->
    <div class="records-section">
        <h2 class="text-2xl font-bold mb-4">📚 最近の学習記録</h2>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
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
                                <a href="{{ route('timelogs.edit', $timelog) }}" class="text-blue-500 hover:underline text-sm">編集</a>
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
    </div>
</x-app-layout>

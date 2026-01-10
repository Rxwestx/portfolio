<x-app-layout>
    <!-- 1. キャラクター詳細 -->
    <div class="character-section">
        <h2>キャラクター詳細</h2>
        {{-- <p>レベル: {{ $character->level }}</p>
        <img src="{{ $character->image }}" /> --}}
    </div>

    <!-- 2. トータル時間 -->
    <div class="total-time-section">
        <h2>総累計時間</h2>
        <p>{{ $totalTime }} 時間</p>
    </div>

    <!-- 3. グラフ -->
    <div class="graph-section">
        <h3>月別グラフ</h3>
        <canvas id="monthlyChart"></canvas>

        <h3>週別グラフ</h3>
        <canvas id="weeklyChart"></canvas>
    </div>

    <!-- 4. 記録一覧（編集・削除機能付き） -->
    <div class="records-section">
        <h2>学習記録</h2>
        <table>
            <tr>
                <th>日付</th>
                <th>時間</th>
                <th>操作</th>
            </tr>
            @foreach ($timelogs as $timelog)
                <tr>
                    <td>{{ $timelog->logged_at->format('Y-m-d') }}</td>
                    <td>{{ $timelog->duration_minutes }} 分</td>
                    <td>
                        <a href="{{ route('timelogs.edit', $timelog) }}">編集</a>
                        <form method="post" action="{{ route('timelogs.destroy', $timelog) }}">
                            @csrf
                            @method('delete')
                            <button>削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>

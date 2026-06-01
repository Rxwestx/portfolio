<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            学習記録一覧
        </h2>
    </x-slot>
    <div class="inari-list-page">
        <x-message :message="session('message')" />
        @forelse ($timeLogs as $timeLog)
            <div class="inari-card inari-list-card border-blade-neon/40 bg-white/90">
                <h2 class="text-base font-semibold text-gray-900 sm:text-lg">
                    学習日：
                    <a href="{{ route('timelogs.show', $timeLog->id) }}" class="text-blade-main hover:underline">
                        {{ $timeLog->logged_at->format('Y年m月d日') }}
                    </a>
                </h2>
                <hr class="my-3 w-full border-blade-neon/30 sm:my-4">
                <p class="font-medium text-gray-700">
                    学習時間：{{ $timeLog->duration_minutes }} 分
                </p>
                <div class="mt-3 text-sm text-gray-500">
                    <p>
                        記録日時：{{ $timeLog->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="inari-card border-blade-neon/40 bg-white/90 text-center text-gray-600">
                記録がありません
            </div>
        @endforelse
        <div class="mt-4 mb-4">
            {{ $timeLogs->links() }}
        </div>
    </div>
</x-app-layout>

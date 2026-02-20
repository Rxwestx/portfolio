<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight">
            学習記録一覧
        </h2>
    </x-slot>
    <div class="mt-16 max-w-md w-full mx-auto px-4">
        <x-message :message="session('message')" />
        @foreach ($timeLogs as $timeLog)
            <div class="mt-4 p-8 bg-blade-neon w-full rounded-2xl shadow-md ">
                <h2 class="p-4 font-xl text-gray-600 whitespace-nowrap">
                    学習日：
                    <a href="{{ route('timelogs.show', $timeLog->id) }}" class="text-blade-dark">
                        {{ $timeLog->logged_at->format('Y年m月d日') }}
                    </a>
                </h2>
                <hr class="w-full">
                <p class="mt-4 p-4 text-gray-600">
                    学習時間：{{ $timeLog->duration_minutes }} 分
                </p>
                <div class="p-4 text-sm test-xl text-gray-600">
                    <p>
                        記録日時：{{ $timeLog->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>
            </div>
        @endforeach
        <div class="mb-4">
            {{ $timeLogs->links() }}
        </div>
    </div>
</x-app-layout>

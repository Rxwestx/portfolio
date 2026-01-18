<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            学習記録一覧
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        <x-message :message="session('message')" />
        @foreach ($timeLogs as $timeLog)
            <div class="mt-4 p-8 bg-white w-full rounded-2xl">
                <h1 class="p-4 text-lg font-semibold">
                    学習日：
                    <a href="{{ route('timelogs.show', $timeLog->id) }}" class="text-blue-600">
                        {{ $timeLog->logged_at->format('Y年m月d日') }}
                    </a>
                </h1>
                <hr class="w-full">
                <p class="mt-4 p-4">
                    学習時間：{{ $timeLog->duration_minutes }} 分
                </p>
                <div class="p-4 text-sm font-semibold">
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

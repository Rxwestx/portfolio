<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            学習記録詳細
        </h2>
    </x-slot>
    <div class="inari-list-page">
        {{-- フラッシュメッセージ表示 --}}
        <x-message :message="session('message')" />
            <div class="inari-card border-blade-neon/40 bg-white/90">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">
                        学習日：{{ $timeLog->logged_at->format('Y-m-d') }}
                    </h1>
                </div>

                <hr class="my-4 w-full border-blade-neon/30">
                <p class="whitespace-pre-line font-medium text-gray-700">
                    学習時間：{{ $timeLog->duration_minutes }} 分
                </p>
                <div class="mt-3 flex text-sm font-medium text-gray-500">
                    <p>記録日時：{{ $timeLog->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('timelogs.edit', $timeLog->id) }}" class="sm:flex-none">
                        <x-primary-button class="w-full sm:w-auto">
                            編集
                        </x-primary-button>
                    </a>
                    <form method="post" action="{{ route('timelogs.destroy', $timeLog->id) }}" class="sm:flex-none">
                        @csrf
                        @method('delete')
                        <x-tertiary-button class="w-full !border-red-200 !text-red-600 hover:!text-white sm:w-auto">
                            削除
                        </x-tertiary-button>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>

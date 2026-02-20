<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight">
            学習記録詳細
        </h2>
    </x-slot>
    <div class="max-w-md mx-auto px-6">
        {{-- フラッシュメッセージ表示 --}}
        <x-message :message="session('message')" />
            <div class="bg-blade-neon w-full rounded-2xl">
                <div class="mt-16 p-4">
                    <h1 class="text-lg font-semibold text-gray-600 ">
                        学習日：@if ($timeLog->logged_at)
                            {{ $timeLog->logged_at->format('Y-m-d') }}
                        @else
                            記録がありません
                        @endif
                    </h1>
                </div>

                <hr class="w-full">
                <p class="p-4 whitespace-pre-line font-medium text-gray-600">
                    学習時間：{{ $timeLog->duration_minutes }} 分
                </p>
                <div class="p-4 text-sm font-medium text-gray-600 flex ">
                    <p>記録日時：{{ $timeLog->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="text-right flex justify-end p-4">
                    <a href="{{ route('timelogs.edit', $timeLog->id) }}" class="flex-1">
                        <x-primary-button>
                            編集
                        </x-primary-button>
                    </a>
                    <form method="post" action="{{ route('timelogs.destroy', $timeLog->id) }}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-tertiary-button class="!px-4 !py-2 !text-xs ml-2">
                            削除
                        </x-tertiary-button>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>

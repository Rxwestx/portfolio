<x-app-layout>
    <x-slot name="header">
        <<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            学習記録詳細
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-white w-full rounded-2xl">
            <div class="mt-4 p-4">
                <h1 class="text-lg font-semibold">
                    学習日：@if ($timelogs->logged_at )
                        {{ $timelogs->logged_at->format('Y-m-d') }}
                    @else
                        記録がありません
                    @endif
                </h1>
                <div class="text-right flex">
                    <a href="{{ route('timelogs.edit', $timelogs->id) }}" class="flex-1">
                        <x-primary-button>
                            編集
                        </x-primary-button>
                    </a>
                    <form method="post" action="{{ route('timelogs.destroy', $timelogs->id) }}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-primary-button class="bg-red-700 ml-2">
                            削除
                        </x-primary-button>
                    </form>
                </div>
                <hr class="w-full">
                <p class="mt-4 whitespace-pre-line">
                    学習時間：{{ $timelogs->duration_minutes }} 分
                </p>
                <div class="text-sm font-semibold flex flex-row-rerverse">
                    <p>記録日時：{{ $timelogs->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight">
            学習記録編集
        </h2>
    </x-slot>
    <div class="max-w-md mx-auto px-6">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif

        <form method="post" action="{{ route('timelogs.update', $timeLog) }}"
            class="mt-16 mx-auto max-w-md bg-blade-neon rounded-3xl px-6 py-8 shadow-md">
            @csrf
            @method('put')
            <div class="mt-8 flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <label for="study_date" class="font-semibold text-gray-700 whitespace-nowrap">学習日：</label>
                    <div>
                        <input type="date" name="study_date"
                            class="w-40 py-2 px-3 border-2 border-gray-300 bg-blade-neon rounded-md focus:border-blade-dark focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:outline-none"
                            id="study_date" value="{{ old('study_date', $timeLog->logged_at->format('Y-m-d')) }}">
                        <x-input-error :messages="$errors->get('study_date')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label for="duration_minutes" class="font-semibold text-gray-700 whitespace-nowrap">学習時間：</label>
                    <div>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="duration_minutes"
                            class="w-32 py-2 px-3 border-2 border-gray-300 rounded-md focus:border-blade-dark focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:outline-none bg-blade-neon text-gray-600"
                            id="duration_minutes" min="1" autocomplete="off"
                            value="{{ old('duration_minutes', $timeLog->duration_minutes) }}">
                        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <x-primary-button class="mt-4 px-4">
                    更新する
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

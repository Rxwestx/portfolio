<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            学習記録編集
        </h2>
    </x-slot>
    <div class="inari-form-page">
        @if (session('message'))
            <div class="mb-4 border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-600">
                {{ session('message') }}
            </div>
        @endif

        <form method="post" action="{{ route('timelogs.update', $timeLog) }}"
            class="inari-card inari-form-card mx-auto border-blade-neon/40 bg-white/90">
            @csrf
            @method('put')
            <div class="flex flex-col gap-5">
                <div>
                    <label for="study_date" class="mb-2 block text-sm font-semibold text-gray-700">学習日：</label>
                    <div>
                        <input type="date" name="study_date"
                            class="w-full rounded-[5px] border border-blade-neon bg-white px-3 py-2 text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30"
                            id="study_date" value="{{ old('study_date', $timeLog->logged_at->format('Y-m-d')) }}">
                        <x-input-error :messages="$errors->get('study_date')" class="mt-2" />
                    </div>
                </div>
                <div>
                    <label for="duration_minutes" class="mb-2 block text-sm font-semibold text-gray-700">学習時間：</label>
                    <div>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="duration_minutes"
                            class="w-full rounded-[5px] border border-blade-neon bg-white px-3 py-2 text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30"
                            id="duration_minutes" min="1" autocomplete="off"
                            value="{{ old('duration_minutes', $timeLog->duration_minutes) }}">
                        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mt-5 flex justify-center">
                <x-primary-button class="w-full sm:w-auto">
                    更新する
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

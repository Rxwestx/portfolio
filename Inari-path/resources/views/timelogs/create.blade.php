<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            記録入力
        </h2>
    </x-slot>
    <div class="inari-form-page">
        @if (session('message'))
            <div class="mb-4 border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-600">
                {{ session('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('timelogs.store') }}" class="inari-card inari-form-card border-blade-neon/40 bg-white/90">
            @csrf
            <div class="flex flex-col gap-5">
                <p class="text-center font-medium text-gray-700">記録時間の入力してね</p>
                <div class="w-full">
                    <label for="study_date" class="mb-2 block text-sm font-semibold text-gray-700" >学習日:</label>
                    <x-input-error :messages="$errors->get('study_date')" class="mt-2" />
                    <input type="date" name="study_date" class="w-full rounded-[5px] border border-blade-neon bg-white px-3 py-2 text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30"
                        id="study_date" value="{{ old('study_date', now()->format('Y-m-d')) }}">
                </div>

                <div class="w-full">
                    <label for="duration_minutes" class="mb-2 block text-sm font-semibold text-gray-700">学習時間(分):</label>
                    <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="duration_minutes" class="w-full rounded-[5px] border border-blade-neon bg-white px-3 py-2 text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30"
                        id="duration_minutes" min="1" value="{{ old('duration_minutes') }}">
                </div>
                <x-primary-button class="mt-1 w-full sm:w-auto sm:self-center">
                    報告する
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

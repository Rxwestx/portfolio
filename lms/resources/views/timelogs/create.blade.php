<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記録入力
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if (session('message'))
            <div class="test-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('timelogs.store') }}" Class="mt-16 text-center bg-blade-neon rounded-2xl px-6 py-8 shadow-md">
            @csrf
            <div class="mt-4 flex flex-col items-center gap-6">
                <p>記録時間の入力してね</p>
                <div class="w-full mt-8">
                    <label for="study_date" class="font-semibold text-gray-700" >学習日:</label>
                    <x-input-error :messages="$errors->get('study_date')" class="mt-2" />
                    <input type="date" name="study_date" class="w-auto py-2 border border-gray-300 rounded-md bg-blade-neon focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:border-blade-dark focus:outline-none"
                        id="study_date" value="{{ old('study_date', now()->format('Y-m-d')) }}">
                </div>

                <div class="w-full mt-4">
                    <label for="duration_minutes" class="font-semibold mt-4 text-gray-700">学習時間(分):</label>
                    <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="duration_minutes" class="w-24 py-2 border border-gray-300 rounded-md bg-blade-neon focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:border-blade-dark focus:outline-none"
                        id="duration_minutes" min="1" value="{{ old('duration_minutes') }}">
                </div>
                <x-tertiary-button class="mt-8 w-40 h-8">
                    報告する
                </x-tertiary-button>
        </form>
    </div>
</x-app-layout>

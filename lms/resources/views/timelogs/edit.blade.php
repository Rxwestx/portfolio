<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            学習記録編集
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif

        <form method="post" action="{{ route('timelogs.update', $timelogs) }}">
            @csrf
            @method('put')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="study_date" class="font-semibold mt-4">学習日</label>
                    <x-input-error :messages="$errors->get('study_date')" class="mt-2" />
                    <input type="date" name="study_date" class="w-auto py-2 border border-gray-300 rounded-md"
                        id="study_date" value="{{ old('study_date', $timelogs->logged_at->format('Y-m-d')) }}">
                </div>

                <div class="w-full flex flex-col">
                    <label for="duration_minutes" class="font-semibold mt-4">学習時間（分）</label>
                    <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                    <input type="number" name="duration_minutes" class="w-auto py-2 border border-gray-300 rounded-md"
                        id="duration_minutes" min="1"
                        value="{{ old('duration_minutes', $timelogs->duration_minutes) }}">
                </div>
            </div>
            <x-primary-button class="mt-4">
                更新する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>

@props(['action'])


<section class="inari-form-page justify-center">
    <h1 class="inari-section-heading">目標設定</h1>
    <p class="mt-3 text-center text-xs leading-relaxed text-gray-500">
        ◆ここで入力した目標は、変更することが出来ません◆<br>
        よく、考えてから入力してね
    </p>
    <form method="POST" action="{{ $action }}" class="inari-card mt-5 space-y-5 border-blade-neon/40 bg-white/90">
        @csrf
        {{-- 目標 goal --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-gray-700">あなたの目標は？</label>
            <input type="text" name="goal" value="{{ old('goal') }}"
                class="h-10 w-full rounded-[5px] border border-blade-neon bg-white px-3 text-sm text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30">
            @error('goal')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

        {{-- 期限 goal_deadline --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-gray-700">
                いつまでに目標を達成したいか入力して
            </label>
            <div class="flex justify-center">
                <input type="date" name="goal_deadline" value="{{ old('goal_deadline') }}"
                    class="h-10 w-full rounded-[5px] border border-blade-neon bg-white px-3 text-sm text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30">
            </div>
            @error('goal_deadline')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

        {{-- トータル時間 target_hours --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-gray-700">
                目標達成までのトータル時間の入力して
            </label>

            <div class="flex items-center gap-2">
                <input type="text" inputmode="numeric" pattern="[0-9]*" name="target_hours"
                    value="{{ old('target_hours') }}"
                    class="h-10 w-full rounded-[5px] border border-blade-neon bg-white px-3 text-sm text-gray-700 focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30">
                <span class="shrink-0 text-base text-gray-700">時間</span>
            </div>
            @error('target_hours')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-center pt-1">
            <button type="submit"
                class="h-10 w-full rounded-[5px] bg-blade-main text-sm font-semibold text-white transition-transform hover:bg-blade-main/90 focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2 active:scale-95 sm:w-24">
                登録
            </button>
        </div>
    </form>
</section>

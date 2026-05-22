@props(['action'])


<section class="inari-form-page justify-center">
    <h1 class="inari-section-heading">目標設定</h1>
    <p class="mt-4 text-center text-xs text-gray-600 leading-relaxed">
        ◆ここで入力した目標は、変更することが出来ません◆<br>
        よく、考えてから入力してね
    </p>
    <form method="POST" action="{{ $action }}" class="inari-card mt-6 space-y-5">
        @csrf
        {{-- 目標 goal --}}
        <div>
            <label class="block text-center text-xs text-gray-600 mb-2">あなたの目標は？</label>
            <input type="text" name="goal" value="{{ old('goal') }}"
                class="w-full h-9 rounded-[5px] border border-gray-300 px-3 text-sm bg-blade-neon focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:border-blade-dark focus:outline-none">
            @error('goal')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

        {{-- 期限 goal_deadline --}}
        <div>
            <label class="block text-center text-xs text-gray-700 mb-2">
                いつまでに目標を達成したいか入力して
            </label>
            <div class="flex justify-center">
                <input type="date" name="goal_deadline" value="{{ old('goal_deadline') }}"
                    class="h-9 rounded-[5px] border border-gray-300 px-3 text-sm bg-blade-neon focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:border-blade-dark focus:outline-none">
            </div>
            @error('goal_deadline')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

        {{-- トータル時間 target_hours --}}
        <div>
            <label class="block text-center text-xs text-gray-700 mb-2">
                目標達成までのトータル時間の入力して
            </label>

            <div class="flex items-center justify-center gap-2">
                <input type="text" inputmode="numeric" pattern="[0-9]*" name="target_hours"
                    value="{{ old('target_hours') }}"
                    class="w-24 h-8 rounded-[5px] border border-gray-300 px-4 text-sm bg-blade-neon items-center focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:border-blade-dark focus:outline-none">
                <span class="text-lg text-gray-700 text-center">時間</span>
            </div>
            @error('target_hours')
                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>
        <div class="pt-2 flex justify-center">
            <button type="submit"
                class="w-24 h-10 rounded-[5px] bg-blade-main text-gray-700 text-sm hover:bg-blade-dark hover:text-white active:scale-95 transition-transform focus:outline-none focus:ring-2 focus:ring-blade-dark focus:ring-offset-2">
                登録
            </button>
        </div>
    </form>
</section>

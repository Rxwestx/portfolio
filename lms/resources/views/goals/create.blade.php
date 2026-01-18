<x-app-layout>
@if (session('success'))
    <div class="mb-4 text-center text-sm text-white-100">
        {{ session('success') }}
    </div>
@endif
{{-- 目標設定フォーム呼び出し --}}
<x-goal-settingform :action="route('goals.store')" />
</x-app-layout>

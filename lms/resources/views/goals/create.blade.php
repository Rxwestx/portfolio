<x-app-layout>
@if (session('success'))
    <div class="mb-4 text-center text-sm text-white-100">
        {{ session('success') }}
    </div>
@endif
<x-goal-settingform :action="route('goals.store')" />
</x-app-layout>

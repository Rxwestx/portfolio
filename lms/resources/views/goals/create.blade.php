@if (session('success'))
    <div class="mb-4 text-center text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif
<x-goal-settingform :action="route('goals.store')" />

{{-- <form action="{{ route('goals.store') }}" method="POST" class="max-w-md mx-auto mt-6">
@csrf
<div class="mb-4">
    <label for="goal" class="block">目標内容</label>
    <textarea name="goal" id="goal" class="w-full border rounded p-2" required>{{ old('goal') }}</textarea>
</div>
<div class="mb-4">
    <label for="goal_deadline" class="block">目標期限</label>
    <input type="date" name="goal_deadline" id="goal_deadline" class="w-full border rounded p-2"
        value="{{ old('goal_deadline') }}" required>
</div>
<x-input-time name="target_hours" />
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
</form> --}}

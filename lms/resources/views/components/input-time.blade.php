<div class="mb-4">
    <label for="target_hours" class="block">目標学習時間（時間）</label>
    <input type="number" name="target_hours" id="target_hours" class="w-full border rounded p-2" value="{{ old('target_hours') }}" min="1" required>
</div>

{{-- <x-input-time /> で、呼び出し--}}

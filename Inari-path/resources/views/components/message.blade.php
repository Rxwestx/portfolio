<div>
    @props(['message'])
    @if ($message)
        <div class="mb-4 border border-blade-neon bg-blade-soft px-4 py-3 text-sm font-medium text-blade-main">
            {{ $message }}
        </div>
    @endif
</div>

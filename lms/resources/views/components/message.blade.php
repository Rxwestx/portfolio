<div>
    @props(['message'])
    @if ($message)
        <div class="p-4 m-2 rounded bg-blade-pale text-blade-dark border border-blade-dark">
            {{ $message }}
        </div>
    @endif
</div>

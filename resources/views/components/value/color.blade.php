<div class="pr-2 flex items-center">
    @props([
    'value' => '',
    'label' => '',
    'force' => false,
    ])
    @if ($value !== "")
        <div style="background-color: {{ $value }}" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 text-white text-xl">
        </div>
        @if ($force) {{ $label }} : @endif<span class="pl-2">{{ $value }}</span>@if ($force) <br/> @endif
    @endif
</div>

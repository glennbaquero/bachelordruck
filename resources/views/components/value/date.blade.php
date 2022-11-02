@props([
'value' => '',
'label' => '',
'force' => false,
])

@if ($value !== "")
    <span class="text-sm leading-5 font-medium">
        @if ($force) {{ $label }} : @endif {{ $value ? \Support\Helpers\Date::format($value):'' }} @if ($force) <br/> @endif
    </span>
@endif


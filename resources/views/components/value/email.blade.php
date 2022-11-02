@props([
'value' => '',
'label' => '',
'force' => false,
])

@if ($value !== "")
    <span class="text-sm leading-5 font-medium">
        @if ($force) {{ $label }} : @endif <a href="mailto:{{$value}}" class="text-blue-500">{{ $value }}</a>@if ($force) <br/> @endif
    </span>
@endif

@props([
'value' => '',
'label' => '',
'force' => false,
'enum' => ''
])

@if ($value !== "")
    @if ($force) {{ $label }} : @endif
    <span class="text-sm leading-5 font-medium">
        {{ $enum::from($value->value ?? $value)->label() }}
    </span>
    @if ($force) <br/> @endif
@endif


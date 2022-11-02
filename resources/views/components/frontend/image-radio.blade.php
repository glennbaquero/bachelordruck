@props([
'image' => '',
'backgroundColor' => '',
'width',
'height',
'id' => '',
'name' => '',
'label' => '',
'value' => '',
'checked' => false,
'center' => false,
'hoverBrightness' => 1.2,
])

<div class="image-radio">
    <input
        id="{{ $id }}"
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        class="focus:ring-0 focus:ring-offset-0 -ml-[4px]"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->wire('model') }}
        {{ $attributes->whereStartsWith('@click') }}
        {{ $attributes->whereStartsWith('x-model') }}
    />
    @if($image)
        <label class="image-radio-label" for="{{ $id }}" style="{{ "background-image: url($image); width: $width; height: $height;" }}"></label>
    @endif
    @if($backgroundColor)
        <label class="image-radio-label" for="{{ $id }}" style="{{ "background: $backgroundColor; width: $width; height: $height;" }}"></label>
    @endif
    <label @class(['block cursor-pointer', 'text-center' => $center, 'whitespace-pre-line' ]) for="{{ $id }}">{{ $label }}</label>
</div>

@pushOnce('styles')
<style>
    .image-radio input, .image-radio input:focus {
        height: 0;
        width: 0;
        border: none;
        color: transparent;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .image-radio-label, .image-radio input:active + .image-radio-label {
        opacity: .9;
    }

    .image-radio input:checked + .image-radio-label {
        -webkit-filter: none;
        -moz-filter: none;
        filter: none;
        border-color: var(--color-brand-primary);
        border-width: 2px;
    }

    .image-radio input:checked ~ label {
        color: var(--color-brand-primary);
    }

    .image-radio-label {
        cursor: pointer;
        background-size: contain;
        background-repeat: no-repeat;
        display: inline-block;
    }

    .image-radio-label:hover {
        -webkit-filter: brightness({{ $hoverBrightness }}) grayscale(.5) opacity(.9);
        -moz-filter: brightness({{ $hoverBrightness }}) grayscale(.5) opacity(.9);
        filter: brightness({{ $hoverBrightness }}) grayscale(.5) opacity(.9);
    }
</style>
@endPushOnce

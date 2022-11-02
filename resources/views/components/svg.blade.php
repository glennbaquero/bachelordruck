<svg
    xmlns="http://www.w3.org/2000/svg"
    width="{{ $width }}"
    height="{{ $height }}"
    viewBox="0 0 {{ $viewBox }}"
    id="{{ $id }}"
    {{ $attributes->merge(['class' => " $class"]) }}
    @if ($style)
        style="{{ $style }}"
    @endif
    @if ($stroke)
        stroke="{{ $stroke }}"
    @endif
    @if ($strokeWidth)
        stroke-width="{{ $strokeWidth }}"
    @endif
    @if ($fill)
        fill="{{ $fill }}"
    @endif
    @if ($strokeLinecap)
        stroke-linecap="{{ $strokeLinecap }}"
    @endif
    @if ($strokeLinejoin)
        stroke-linejoin="{{ $strokeLinejoin }}"
    @endif
>
    @includeIf("icons.$icon->value")
</svg>

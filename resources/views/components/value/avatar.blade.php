@props([
'url' => '',
'short' => false,
'tooltip' => '',
'color' => '',
'value' => '',
])
@if ($url !== '')
    @if ($short)
        <div x-data="{}" class="flex -space-x-2">
            <img x-tooltip="'{{ $tooltip ?: '' }}'" class="inline-block h-12 w-12 rounded-full ring-2" src="{{ $url }}" alt="" style="box-shadow: 0 0 0 2px {{$color !== '' ? $color: 'white' }}">
        </div>
    @else
        <div class="flex -space-x-2">
            <img class="inline-block h-12 w-12 rounded-full ring-2" src="{{ $url }}" alt="" style="box-shadow: 0 0 0 2px {{$color !== '' ? $color: 'white' }}">
        </div>
    @endif
@else
    @if ($short)
        <div x-data="{}" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 text-white text-xl" style="background-color: {{$color !== '' ? $color: '#CCCCCC' }}">
            <span x-tooltip="'{{ $tooltip ?: '' }}'">{{ $value }}</span>
        </div>
    @else
        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 text-white text-xl" style="background-color: {{$color !== '' ? $color: '#CCCCCC' }}">
            {{ $value }}
        </div>
    @endif
@endif

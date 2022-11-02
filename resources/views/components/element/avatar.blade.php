@props([
'name' => '',
'abbrev' => '',
'color' => '',
'imgUrl' => '',
'short' => false,
])

@if ($imgUrl !== '')
    @if ($short)
        <div x-data="{}" class="cursor-pointer flex h-10 w-10 rounded-full">
            <div class="hidden">
                <div x-ref="tooltipContent" class="py-2">
                    <x-element.avatar name="{{ $name }}" abbrev="{{ $abbrev }}" color="{{ $color }}"
                                      img-url="{{ $imgUrl }}"
                                      :short="false"></x-element.avatar>
                </div>
            </div>

            <img x-tooltip.html="$refs.tooltipContent" class="inline-block h-10 w-10 rounded-full ring-2"
                 src="{{ $imgUrl }}"
                 alt="" style="box-shadow: 0 0 0 2px {{$color !== '' ? $color : '#ffffff' }}">
        </div>
    @else
        <div class="flex items-center">
            <img class="inline-block h-10 w-10 rounded-full ring-2" src="{{ $imgUrl }}" alt=""
                 style="box-shadow: 0 0 0 2px {{$color !== '' ? $color: '#ffffff' }}">
            <div class="ml-2">{{$name }}</div>
        </div>
    @endif
@else
    @if ($short)
        <div
            class="cursor-pointer text-white text-l flex items-center justify-center flex-shrink-0 h-10 w-10 rounded-full"
            style="background-color: {{$color !== '' ? $color : '#cccccc' }}"
            x-data="{}"
            x-tooltip.html="$refs.tooltipContent">
            <div class="hidden">
                <div x-ref="tooltipContent" class="py-2">
                    <x-element.avatar
                        name="{{ $name }}"
                        abbrev="{{ $abbrev }}"
                        color="{{ $color }}"
                        :short="false">
                    </x-element.avatar>
                </div>
            </div>
            {{ $abbrev }}
        </div>
    @else
        <div class="flex items-center">
            <div
                class="text-white text-l flex flex-shrink-0 items-center justify-center h-10 w-10 rounded-full"
                style="background-color: {{$color !== '' ? $color : '#cccccc' }};">
                {{ $abbrev }}
            </div>
            <div class="ml-2">{{ $name }}</div>
        </div>
    @endif
@endif

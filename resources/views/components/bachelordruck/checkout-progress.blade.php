@props([
'steps' => 4,
'current' => 1,
'urls' => [],
])

<div
    class="flex items-center justify-center gap-2 sm:gap-4 lg:gap-12 my-5">
    @for($step = 1; $step <= $steps; $step++)
        @if($current >= $step)
            <a href="{{ $urls[$step-1] }}">
                <x-bachelordruck.step-done class="w-8 h-8 sm:w-10 sm:h-10 lg:w-14 lg:h-14"></x-bachelordruck.step-done>
            </a>
        @else
            <div class="rounded-full border-2 border-gray-100  w-8 h-8 sm:w-10 sm:h-10 lg:w-14 lg:h-14"></div>
        @endif

        @if($step < $steps)
            <x-bachelordruck.step-arrow-right class="h-4 lg:h-8"></x-bachelordruck.step-arrow-right>
        @endif
    @endfor
</div>

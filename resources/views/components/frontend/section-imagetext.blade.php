 @props(['imgurl','title', 'imagealignment'])

<section {{ $attributes->merge(['class' => 'py-12 px-4']) }}>
    <div class="xl:container xl:mx-auto grid md:grid-cols-2 gap-4 md:gap-0">
        @if (($imagealignment ?? '') === \Domain\Pages\Enums\ImageAlignmentEnum::RIGHT->value)
            <div class="pr-16">
                <h1 class="text-3xl">{{ $title }}</h1>
                <div class="w-1/4 mt-6 pb-8 @if ($title->isNotEmpty()) border-t border-solid border-black @endif"></div>
                {{ $slot }}
            </div>
            <div>
                <div class="bg-white p-6">
                    <img src="{{ $imgurl }}" class="w-full" alt="">
                </div>
            </div>
        @else
            <div class="pr-16">
                <div class="bg-white p-6">
                    <img src="{{ $imgurl }}" class="w-full" alt="">
                </div>
            </div>
            <div>
                <h1 class="text-3xl">{{ $title }}</h1>
                <div class="w-1/4 mt-6 pb-8 @if ($title->isNotEmpty()) border-t border-solid border-black @endif"></div>
                {{ $slot }}
            </div>
        @endif
    </div>
</section>

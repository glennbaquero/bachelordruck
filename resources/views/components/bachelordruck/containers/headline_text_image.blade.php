<?php /** @var Domain\Containers\Models\Container $container */ ?>

@props(['container', 'summarize' => false])

<section {{ $attributes->class([
        'flex flex-col md:flex-row justify-between side-padding py-10 gap-10',
        'flex-col-reverse md:flex-row-reverse' => $container->image_alignment === 'left',
    ]) }}>

    <div class="flex-1">
        {!! $container->media->first()->toHtml() !!}
{{--        <img src="{{ $container->media->first()?->getUrl() }}" alt="" class="h-full">--}}
    </div>
    <div class="flex-1">
        <div class="h-full bg-brand-secondary md:p-8 p-6 sm:p-6">
            @if (!empty($container->title))
                <p class="mx-auto font-bold text-2xl text-center uppercase font-josefin_sans">{{$container->title}}</p>
            @endif

            @if($summarize)
                <article
                    x-data="{ isCollapsed: false, maxLength: 200, originalContent: '', content: '' }"
                    x-init="originalContent = '{{ $container->content }}'; content = originalContent.slice(0, maxLength)"
                    class="mt-6 prose text-center mx-auto font-josefin_sans">

                    <span x-html="isCollapsed ? originalContent : content"></span>
                    <button
                        @click="isCollapsed = !isCollapsed"
                        x-show="originalContent.length > maxLength"
                        x-text="isCollapsed ? 'Show less' : 'Show more'"
                    ></button>
                </article>
            @else
                <article class="mt-6 prose text-center mx-auto font-josefin_sans">
                    {!! $container->content !!}
                </article>
            @endif
        </div>
    </div>
</section>

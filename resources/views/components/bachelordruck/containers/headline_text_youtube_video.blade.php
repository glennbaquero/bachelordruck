<?php /** @var Domain\Containers\Models\Container $container */ ?>

@props(['container'])

<section {{ $attributes->class(['margin-top flex flex-col justify-center py-12 side-padding']) }}>
    <h3 class="flex justify-center title pb-4">{{ $container->title }}</h3>

    <x-youtube-video-embed youtube-id="{{ $container->getYoutubeId() }}"></x-youtube-video-embed>

    <div class="flex justify-center mt-10 text-center">
        <article class="prose-brand">
            {!! $container->content !!}
        </article>
    </div>
</section>

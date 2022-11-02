<?php /** @var Domain\Containers\Models\Container $container */ ?>

@props(['container'])

<section {{ $attributes->class(['margin-top flex flex-col justify-center py-12 side-padding']) }}>
    <x-youtube-video-embed youtube-id="{{ $container->getYoutubeId() }}"></x-youtube-video-embed>
</section>

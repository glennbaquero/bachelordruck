<?php /** @var Domain\Containers\Models\Container $container */ ?>

@props(['container'])

<section {{ $attributes->class(['margin-top flex flex-col justify-center py-12 px-6 side-padding']) }}>
    <img src="{{ $container->media->first()->getUrl() }}" class="w-full" alt="">
</section>

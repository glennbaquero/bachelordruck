<?php /** @var Domain\Containers\Models\Container $container */ ?>

@props(['container'])

<section {{ $attributes->class(['margin-top flex flex-col justify-center py-12 side-padding sm:space-x-12']) }}>
    @if (!empty($container->title))
        <h3 class="flex title pb-4">{{ $container->title }}</h3>
    @endif
    <div class="flex mt-10">
        <article class="prose prose-sm sm:prose-xl w-full sm:max-w-prose md:max-w-[70%]">
            {!! $container->content !!}
        </article>
    </div>
</section>

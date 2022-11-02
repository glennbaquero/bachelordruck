@props(['title'])

<section {{ $attributes }}>
    <div class="py-12 px-4 lg:w-1/2 mx-auto text-center">
        <h1 class="text-3xl">{{ $title }}</h1>
        <div class="w-1/4 mt-6 mx-auto border-t border-solid border-black pb-8"></div>
        {{ $slot }}
    </div>
</section>

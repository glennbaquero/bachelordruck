<x-frontend.section-textcenter
    class="{{ $index%2 === 0 ?  'bg-gray-300' : 'bg-gray-100'}}">
    <x-slot name="title">
        {{ $container->title }}
    </x-slot>
    {!! $container->content !!}
</x-frontend.section-textcenter>

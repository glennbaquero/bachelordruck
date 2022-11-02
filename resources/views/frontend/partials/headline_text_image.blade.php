<x-frontend.section-imagetext
    class="{{ $index%2 === 0 ?  'bg-gray-300' : 'bg-gray-100'}}"
    imgurl="{{ $container->getFirstMediaUrl('images') }}"
    imagealignment="{{ $container->image_alignment }}"
>
    <x-slot name="title">
        {{ $container->title }}
    </x-slot>
    {!! $container->content !!}
</x-frontend.section-imagetext>

@props([
'images',
'title' => '',
'imageSizeClass' => 'gallery-150',
'galleryId' => 'gallery_images',
'conversionName' => '',
'fullscreen' => false,
])
<div
    @if($fullscreen)
    x-data="{}"
    x-init="images = new Viewer(document.getElementById('{{ $galleryId }}'), {
                title: false,
             });"
    @endif
    class="xl:container xl:mx-auto px-4 pb-8">
    <div class="bg-white">
        @if(!empty($title))
            <h1 class="page-title uppercase text-center header-margin-top">{{ $title }}</h1>
        @endif
        <div
            class="flex justify-center gap-1 flex-wrap mt-6">
            @foreach($images as $image)
                <div
                    @click="images.show()"
                    @class([
                        'flex-shrink-0',
                        'cursor-pointer' => $fullscreen
                    ])>
                    {{ $image->img()->attributes(['class' => "$imageSizeClass object-center object-cover group-hover:opacity-75", 'alt' => '']) }}
                </div>
            @endforeach
        </div>

        @if($fullscreen)
            <div
                id="{{ $galleryId }}"
                class="hidden flex justify-center gap-1 flex-wrap">
                @foreach($images as $image)
                    <div
                        class="flex-shrink-0 cursor-pointer">
                        <img src="{{$image->getUrl()}}"
                             class="{{ $imageSizeClass }} object-center object-cover group-hover:opacity-75" alt="">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

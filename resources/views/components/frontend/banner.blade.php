@props(['banner' => ''])
<div x-data="{
        images: [],
        activeImage: 0,
        loop() {
            setInterval(() => {
                if (this.activeImage === this.images.length - 1) {
                    this.activeImage = 0
                    return
                }

                this.activeImage = this.activeImage + 1
            }, 2000)
        },
    }"
    x-init="function () {
        let images = document.getElementsByClassName('carousel')
        this.images = images
        this.loop()

    }"
     class="w-full h-100 relative"
>
    @if ($banner->getMedia('image')->count() === 1)
        <div>{{ $banner->getMedia('image')->first()->img()->attributes(['class' => 'w-full h-100 object-cover']) }}</div>
    @else
        @foreach ($banner->getMedia('image') as $index => $image)
            <div
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-1000"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                x-show="activeImage === {{ $index }}"
                x-cloak
                class="absolute inset-x-0 top-0"
            >
                {{ $image->img()->attributes(['class' => 'carousel w-full h-100 object-cover', 'data-name' => $image->name]  ) }}
            </div>
        @endforeach
    @endif
</div>

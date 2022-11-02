<div
    class="xl:gap-10 lg:gap-10 md:gap-0 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 p-5 pl-5 sm:grid-cols-1 xl:grid-cols-3 xs:grid-cols-1 ">
    <div class="col-span-1">
        <p class="font-bold text-title my-2">Transparente Folie vorne*</p>
        <div class="gap-5 flex flex-wrap">
            @foreach($productCoverFoils as $coverFoil)
                <div class="col-span-1 my-2">
                    <x-frontend.image-radio
                        wire:model.defer="productConfiguration.product_cover_foil_id"
                        id="{{ 'cover-foil' . $loop->index }}"
                        name="cover-foil"
                        :label="$coverFoil->title"
                        image="{{ $coverFoil->getFirstMediaUrl('image') }}"
                        width="120px"
                        height="120px"
                        :value="$coverFoil->id"
                        center
                        hover-brightness="0.95"
                    >
                    </x-frontend.image-radio>
                </div>
            @endforeach
        </div>
        <p class="font-bold text-title mt-5 my-2">Format*</p>
        <div class="gap-5 flex flex-wrap">
            @foreach($product->activeProductFormats as $productFormat)
                <div class="col-span-1 my-2">
                    <x-frontend.radio
                        wire:model.defer="productConfiguration.product_format_id"
                        id="{{ 'product-format' . $loop->index }}"
                        name="product-format"
                        :label="$productFormat->title"
                        :value="$productFormat->id"
                    ></x-frontend.radio>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-span-2">
        <p class="font-bold text-title my-2">270g Karton hinten Farbe*</p>
        <div
            class="flex flex-wrap gap-x-3">
            @foreach($productBackCovers as $backCover)
                <div class="col-span-1 text-center cursor-pointer">
                    <x-frontend.image-radio
                        wire:model.defer="productConfiguration.product_back_cover_id"
                        id="{{ 'back-cover' . $loop->index }}"
                        name="back-cover"
                        :label="$backCover->title"
                        :background-color="$backCover->color"
                        width="120px"
                        height="120px"
                        :value="$backCover->id"
                        center
                    >
                    </x-frontend.image-radio>
                </div>
            @endforeach

            <!-- Book Spine Perfect Binding -->
            @if($product->has_book_spine_label)
                @include('livewire.bachelordruck.products.partials.book-spine-perfect-binding')
            @endif
        </div>
    </div>
</div>

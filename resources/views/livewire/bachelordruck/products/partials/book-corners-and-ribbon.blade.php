<div
    class="xl:gap-10 lg:gap-10 md:gap-0 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 p-5 pl-5 sm:grid-cols-1 xl:grid-cols-3 xs:grid-cols-1">
    <div
        class="col-span-1 xl:col-span-2 lg:col-span-2 md:col-span-2 sm:col-span-1 xs:col-span-1">
        <p class="font-bold text-title mb-2">Extras*</p>
        <div class="gap-5 flex flex-wrap">
            @if($product->has_book_corners)
                <div class="col-span-1 lg:mb-0 my-2">
                    <x-frontend.checkbox
                        id="book_corners"
                        name="book_corners"
                        :label="$product->bookCornersLabel"
                        value="1"
                        x-model="hasBookCorners"
                        @click="$wire.priceShouldUpdate()"
                    >
                    </x-frontend.checkbox>
                </div>
            @endif

            @if($product->has_ribbon)
                <div class="col-span-1 lg:mb-0 my-2">
                    <x-frontend.checkbox
                        id="ribbon"
                        name="ribbon"
                        :label="$product->ribbonLabel"
                        value="1"
                        x-model="hasRibbon"
                        @click="$wire.priceShouldUpdate()"
                    >
                    </x-frontend.checkbox>
                </div>
            @endif
        </div>
    </div>
    <div class="col-span-1">
        <div x-show="hasBookCorners" x-transition>
            <p class="font-bold text-title mb-2">Farbe Buchecken*</p>
            <div class="gap-5 flex flex-wrap">
                @foreach($productBookCornerColors as $bookCornerColor)
                    <div class="col-span-1 lg:mb-0 my-2">
                        <x-frontend.radio
                            wire:model.defer="productConfiguration.product_book_corner_color_id"
                            id="{{ 'book-corner-color' . $loop->index }}"
                            name="book-corner-color"
                            :label="$bookCornerColor->title"
                            :value="$bookCornerColor->id"
                        ></x-frontend.radio>
                    </div>
                @endforeach
            </div>
        </div>

        <div x-show="hasRibbon" x-transition>
            <p class="font-bold text-title mb-2 mt-2">Farbe Leseband*</p>
            <div class="gap-5 flex flex-wrap">
                @foreach($productRibbonColors as $ribbonColor)
                    <div class="col-span-1 lg:mb-0 my-2">
                        <x-frontend.radio
                            wire:model.defer="productConfiguration.product_ribbon_color_id"
                            id="{{ 'ribbon-color' . $loop->index }}"
                            name="ribbon-color"
                            :label="$ribbonColor->title"
                            :value="$ribbonColor->id"
                        ></x-frontend.radio>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

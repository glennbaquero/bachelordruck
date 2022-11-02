<div
    class="xl:gap-10 lg:gap-10 md:gap-0 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 p-5 pl-5 sm:grid-cols-1 xl:grid-cols-3 xs:grid-cols-1">
    <div
        class="col-span-1 xl:col-span-2 lg:col-span-2 md:col-span-2 sm:col-span-1 xs:col-span-1">
        <p class="font-bold text-title my-2">Buchrückenbeschriftung*</p>
        <div
            class="gap-5 flex flex-wrap">
            <x-frontend.image-radio
                id="with-spine-label"
                name="book-spine-label"
                :label="$product->withBookSpineLabel"
                image="{{ asset('images/books/beschriftung.png') }}"
                width="258px"
                height="92px"
                value="1"
                x-model="hasSpineLabel"
                @click="$wire.priceShouldUpdate()"
            >
            </x-frontend.image-radio>

            <x-frontend.image-radio
                id="without-spine-label"
                name="book-spine-label"
                label="Ohne Buchrückenbeschriftung"
                image="{{ asset('images/books/ohne_beschriftung.png') }}"
                width="258px"
                height="92px"
                value="0"
                x-model="hasSpineLabel"
                @click="$wire.priceShouldUpdate()"
            >
            </x-frontend.image-radio>
        </div>
    </div>
    <div x-show="displaySpineLabelOptions" x-transition class="col-span-1">
        <p class="font-bold text-title my-2">Farbe Buchrückenbeschriftung*</p>
        <div class="gap-5 flex flex-wrap">
            @foreach($product->activeProductBookSpineColors as $bookSpineColor)
                <div class="col-span-1 my-2">
                    <x-frontend.radio
                        wire:model.defer="productConfiguration.product_book_spine_color_id"
                        id="{{ 'book-spline-color' . $loop->index }}"
                        name="book-spline-color"
                        :label="$bookSpineColor->title"
                        :value="$bookSpineColor->id"
                    ></x-frontend.radio>
                </div>
            @endforeach
        </div>
        <p class="font-bold text-normal my-2 mt-2">Text für Buchrückenbeschriftung*</p>
        <textarea wire:model.defer="productConfiguration.book_spine_label" class="w-full" maxlength="60"></textarea>
        <p class="text-xs text-right">60 verbleibende Zeichen</p>
        @error('productConfiguration.book_spine_label') <div class="-mt-0.5"><small class="-mt-2"><span class="text-red-500">{{ $message }}</span></small></div> @enderror
    </div>
</div>

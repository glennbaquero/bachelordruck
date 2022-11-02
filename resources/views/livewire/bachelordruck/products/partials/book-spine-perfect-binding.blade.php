<div class="col-span-6 grid grid-cols-6">
    <div class="col-span-6">
        <p class="font-bold text-title my-2">Buchrückenbeschriftung*</p>
    </div>
    <div class="col-span-6">
        <div class="gap-5 flex flex-wrap">
            <div
                class="col-span-1 lg:mb-0 xl:mb-0 md:mb-0 sm:mb-2 xs:mb-2 my-2">
                <x-frontend.radio
                    id="with-spine-label"
                    name="book-spine-label"
                    :label="$product->withBookSpineLabel"
                    value="1"
                    x-model="hasSpineLabel"
                    @click="$wire.priceShouldUpdate()"
                ></x-frontend.radio>
            </div>
            <div
                class="col-span-1 lg:mb-0 xl:mb-0 md:mb-0 sm:mb-2 xs:mb-2 my-2">
                <x-frontend.radio
                    id="without-spine-label"
                    name="book-spine-label"
                    label="Ohne Buchrückenbeschriftung"
                    value="0"
                    x-model="hasSpineLabel"
                    @click="$wire.priceShouldUpdate()"
                ></x-frontend.radio>
            </div>
        </div>
    </div>
    <div x-show="displaySpineLabelOptions" x-transition  class="col-span-6 my-2">
        <p class="font-bold text-title my-2">Text für Buchrückenbeschriftung</p>
        <textarea wire:model.defer="productConfiguration.book_spine_label" class="w-full" maxlength="60"></textarea>
        <p class="text-xs text-right">60 verbleibende Zeichen</p>
        @error('productConfiguration.book_spine_label') <div class="-mt-0.5"><small class="-mt-2"><span class="text-red-500">{{ $message }}</span></small></div> @enderror
    </div>
</div>

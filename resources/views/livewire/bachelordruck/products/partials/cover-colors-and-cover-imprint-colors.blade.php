<div
    class="xl:gap-10 lg:gap-10 md:gap-0 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 p-5 pl-5 sm:grid-cols-1 xl:grid-cols-3 xs:grid-cols-1">
    <div class="col-span-1 xl:col-span-2 lg:col-span-2 md:col-span-2 sm:col-span-1 xs:col-span-1">
        <p class="font-bold text-title my-2">Farbe Hardcover*</p>
        <div
            class="gap-5 flex flex-wrap flex-shrink-0">
            @foreach($product->activeProductCoverColors as $coverColor)
                <div class="col-span-1 flex flex-col gap-2">
                    <x-frontend.image-radio
{{--                        wire:model.defer="productConfiguration.product_cover_color_id"--}}
                        id="{{ 'cover-color' . $loop->index }}"
                        name="cover-color"
                        :label="$coverColor->title"
                        image="{{ $coverColor->getFirstMediaUrl('image') }}"
                        width="110px"
                        height="135px"
                        :value="$coverColor->id"
                        x-model="productCoverColorId"
                        @click="$dispatch('lightboxinit')"
                        center
                    >
                    </x-frontend.image-radio>
                </div>
            @endforeach
        </div>
    </div>

    @if($product->has_cover_imprint_color)
        <div class="col-span-1">
            <p class="font-bold text-title my-2">Farbe Prägedruck*</p>
            <div class="gap-5 flex flex-wrap">
                @foreach($productCoverImprintColors as $imprintColor)
                    <div class="col-span-1 flex flex-col gap-2">
                        <x-frontend.radio
                            wire:model.defer="productConfiguration.product_cover_imprint_color_id"
                            id="{{ 'imprint-color' . $loop->index }}"
                            name="imprint-color"
                            :label="$imprintColor->title"
                            :value="$imprintColor->id"
                        ></x-frontend.radio>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>



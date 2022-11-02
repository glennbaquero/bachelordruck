<div
    class="xl:gap-10 lg:gap-10 md:gap-0 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 p-5 pl-5 sm:grid-cols-1 xl:grid-cols-3 xs:grid-cols-1">
    <div class="col-span-1 xl:col-span-2 lg:col-span-2 md:col-span-2 sm:col-span-1 xs:col-span-1">
        <p class="font-bold text-title my-2">Papierstärke*</p>
        <div class="gap-5 flex flex-wrap">
            @foreach($product->activeProductPaperThicknesses as $paperThickness)
                <div class="col-span-1 my-2">
                    <x-frontend.radio
                        wire:model.defer="productConfiguration.product_paper_thickness_id"
                        wire:click="priceShouldUpdate()"
                        id="{{ 'paper-thickness' . $loop->index }}"
                        name="paper-thickness"
                        :label="$paperThickness->title"
                        :value="$paperThickness->id"
                    ></x-frontend.radio>
                </div>
            @endforeach
        </div>
        <p class="font-bold text-title my-2 mt-2">Seitenanzahl Gesamt*</p>
        <input
            wire:model.lazy="productConfiguration.total_number_of_pages"
            wire:change="priceShouldUpdate()"
            @keydown="(evt) => ['e', 'E', '+', '-'].includes(evt.key) && evt.preventDefault()"
            type="number" class="p-2 w-1/2">
        @error('productConfiguration.total_number_of_pages') <div class="-mt-0.5"><small class="-mt-2"><span class="text-red-500">{{ $message }}</span></small></div> @enderror
    </div>
    <div class="col-span-1">
        <p class="font-bold text-title my-2">Einseitiger / Doppelseitiger Druck*</p>
        <div class="gap-5 flex flex-wrap">
            <div class="col-span-1 my-2">
                <x-frontend.radio
                    x-model="doubleSidedPrinting"
                    id="single-side-printing"
                    name="double-sided-printing"
                    label="Einseitig"
                    value="0"
                >
                </x-frontend.radio>
            </div>
            <div class="col-span-1 my-2">
                <x-frontend.radio
                    x-model="doubleSidedPrinting"
                    id="double-side-printing"
                    name="double-sided-printing"
                    label="Doppelseitig"
                    value="1"
                >
                    <div class="help flex" style="right: 37%; z-index: auto; cursor: help">
                        <div class="ml-1 m-0 p-0 rounded-2xl help-icon transition-all">
                            <x-bachelordruck.info class="w-5 h-5"></x-bachelordruck.info>
                        </div>
                        <div
                            class="bg-black my-2 p-4 rounded tooltip w-max absolute opacity-0 z-10 w-96"
                            style=" right: 0%">
                            <small class="text-center text-white">Bitte achten Sie bei
                                doppelseitigem Druck auf die Anordnung der Seitenzahlen!</small>
                        </div>
                    </div>
                </x-frontend.radio>
            </div>
        </div>
        <div>
            <p class="font-bold text-title my-2 mt-2">Seitenzahl davon Farbig*</p>
            <input
                wire:model.lazy="productConfiguration.number_of_colored_pages"
                wire:change="priceShouldUpdate()"
                type="number"
                class="p-2 w-full"
                @keydown="(evt) => ['e', 'E', '+', '-'].includes(evt.key) && evt.preventDefault()"
            >
            @error('productConfiguration.number_of_colored_pages') <div class="-mt-0.5"><small class="-mt-2"><span class="text-red-500">{{ $message }}</span></small></div> @enderror
        </div>
    </div>
</div>

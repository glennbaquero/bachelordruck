<!-- Cost -->
<div class="corner gap-2 grid grid-cols-2 md:w-11/12 side-padding py-5 sm:w-full w-full xs:w-full">
    <div class="col-span-1 ">
        <div class="relative">
            <p class="font-bold text-price mt-0 sm:mt-10 ml-0 md:ml-4">
                <span class="relative">
                    {{ $this->costFormatted }} €
                     <x-spinner wire:loading wire:target="priceShouldUpdate"
                                class="w-3 h-3 -mt-7 -ml-2"></x-spinner>
                </span>
            </p>
        </div>
        <p class="ml-0 md:ml-4">inkl. 7 % MwSt zzgl <span class="text-brand-primary">Versandkosten</span></p>
    </div>

    <div class="col-span-1 ">
        <div class="w-full">
            <x-frontend.select
                label="Auflage*"
                label-class="text-title font-bold"
                option-class="text-xl font-bold"
                show-label
                :options="[
                    [ 'id' => 1, 'label' => '1',],
                    [ 'id' => 2, 'label' => '2',],
                    [ 'id' => 3, 'label' => '3',],
                    [ 'id' => 4, 'label' => '4',],
                    [ 'id' => 5, 'label' => '5',],
                ]"
                wire:model.defer="quantity"
            >
            </x-frontend.select>
            <button
                class="font-bold text-title bg-brand-primary font-bold inline-flex items-center justify-center mt-3 px-2 py-3 text-white w-full"
                wire:click="order"
            >
                <span>
                    Bestellen
                    <x-spinner wire:loading wire:target="order"
                               class="w-3 h-3 -mt-7 -ml-2"></x-spinner>
                </span>
            </button>
            @if($errors->any())
                <small class="text-red-500">Bitte Formular prüfen</small>
            @endif
        </div>
    </div>
</div>

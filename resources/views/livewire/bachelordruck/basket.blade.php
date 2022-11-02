<div
    wire:ignore.self
    x-cloak
    x-show="showBasket"
    x-transition:enter="duration-200 ease-out"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="duration-100 ease-in"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="bg-white fixed  lg:right-0 md:right-0 xl:mx-auto lg:mx-auto md:mx-auto sm:mx-auto xs:mx-auto mx-auto right-auto rounded shadow sm:right-auto xl:right-0 xs:right-auto xl:w-96 lg:w-96 md:w-96 sm:w-3/4 xs:w-auto w-3/4 overflow-auto {{ count($basketPositions) ? 'xl:h-auto lg:h-auto md:h-auto sm:h-96 xs:h-96 h-96' : '' }}">
    <div class="grid grid-cols-4 gap-2 px-5 pt-5">
        <div class="xl:hidden lg:hidden md:hidden sm:visible xs:visible visible col-start-4 cursor-pointer">
            <button x-on:click="toggleMobileBasket" type="button"
                    class="float-right inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        @forelse($basketPositions as $basketPosition)
            <div class="col-span-1">
                {!! $basketPosition->product->getFirstMedia('image')->toHtml() !!}
            </div>
            <div class="col-span-2">
                <p class="mt-1.5 xl:text-sm lg:text-sm md:text-sm sm:text-lg xs:text-lg text-lg"> {{ $basketPosition->product->title }}</p>
                <p class="mt-1.5 xl:text-sm lg:text-sm md:text-sm sm:text-lg xs:text-lg text-lg">QTY:
                    <b>{{ $basketPosition->qty }}</b></p>
                <p class="mt-1.5 xl:text-sm lg:text-sm md:text-sm sm:text-lg xs:text-lg text-lg">PRICE:
                    <b>{{ $basketPosition->priceFormatted }}</b></p>
            </div>
            <div class="col-span-1">
                <p class="cursor-pointer text-right font-bold" wire:click="removeItem({{$basketPosition->id}})">x</p>
            </div>

            <div class="col-span-4 border-black border-t-2 "></div>
        @empty
            <div class="col-span-4 text-center ">
                <p class="font-bold text-2xl">KEIN EINZELSTÜCK GEFUNDEN</p>
            </div>
        @endforelse

        @if(count($basketPositions))
            <div class="col-span-4 text-right ">
                <p>TOTAL: <b>{{ $basketPositions->totalCostFormatted() }}</b></p>
            </div>

        @endif

    </div>

    @if(count($basketPositions))
        <div class="flex w-full justify-end px-5 py-2">
            <button onclick="location.href='{{ route('order.basket-items', ['language' => request()->get('language', 'de')]) }}'" class="bg-brand-primary text-white py-1 px-6 text-base"
                    type="button">
                Warenkorb
            </button>
        </div>
    @endif
</div>

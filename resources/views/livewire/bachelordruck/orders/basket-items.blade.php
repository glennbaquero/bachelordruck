<div>
    <section class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full">Warenkorb</h1>

        <x-bachelordruck.checkout-progress current="1" :urls="\Domain\Orders\Helpers\OrderCheckoutHelpers::checkoutUrls()"></x-bachelordruck.checkout-progress>

        {{-- START LOOP--}}
        @forelse($basketPosition as $item)
            <div class="side-margin">
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-32 mb-6">
                    <div class="flex items-center justify-center mx-auto border h-5/6 w-80 shrink-0">
                        {!! $item->product->getFirstMedia('image')->img()->attributes(['class' => 'mx-auto']) !!}
                    </div>

                    <div class="flex flex-col w-full">
                        <div class="flex w-full">
                            <div class="">
                                <p class="text-title">{{  $item->product->title }}</p>
                                <p class="mt-7 whitespace-pre-line">{{  $item->product_details1 }}</p>
                            </div>
                            <div class="self-end flex justify-end flex-grow flex-shrink-0">
                                <div class="text-5xl text-right text-title">{{ $item->totalCostFormatted }} €</div>
                            </div>
                        </div>

                        <div
                            class="flex justify-between border-t my-2">
                            <div class="flex flex-col md:flex-row gap-x-4 shrink-0 mt-2">
                                <a class="cursor-pointer text-brand-primary text-regular"
                                   wire:click="removeItem({{$item->id}})">Artikel
                                    löschen</a>

                                <div class="hidden md:block text-xl">|</div>

                                <a href="{{ route('product.configure', [
                                    'language' => $language,
                                    'product' => $item->product->slug,
                                    'basketId' => $item->id,
                                ]) }}" class="cursor-pointer text-brand-primary text-regular">Artikel ändern</a>

                                <div class="hidden md:block text-xl">|</div>

                                 <a href="{{ route('page.home', [
                                    'language' => $language,
                                    'basket_id' => $item->id,
                                ]) }}#featured" class="cursor-pointer text-brand-primary text-regular">zusätzliche
                                    Variante hinzufügen</a>
                            </div>
                            <div class="mt-2">
                                <p class="text-right">
                                    inkl. 7 % MwSt zzgl. <span class="text-brand-primary">Versandkosten</span></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        @empty
            <div class="flex flex-col items-center justify-center">
                <p class="font-bold text-2xl text-center mt-20 mb-10">KEIN EINZELSTÜCK GEFUNDEN</p>

                <x-bachelordruck.button onclick="location.href='{{ url('/') }}'" class="bg-gray-100 text-brand-primary mb-40">
                    Weitere Produkte hinzufügen
                </x-bachelordruck.button>
            </div>

        @endforelse


        {{--END--}}
        @if($basketPosition->count())
            <div class="side-margin border-t border-brand-primary my-6"></div>
            <div class="side-padding flex flex-col items-end w-full">
                <p class="text-title">Netto {{ $basketPosition->totalCostFormatted() }} €</p>
                <p class="text-title mt-4">Brutto <span class="ml-4 text-brand-primary text-5xl">{{ $basketPosition->grossFormatted() }} €</span>
                </p>

                <div class="flex gap-x-4 my-10">
                    <x-bachelordruck.button onclick="location.href='{{ url('/') }}'"
                                            class="bg-gray-100 text-brand-primary">
                        Weitere Produkte hinzufügen
                    </x-bachelordruck.button>

                    <x-bachelordruck.button
                        onclick="location.href='{{ route('order.contact-details', ['language' => $language]) }}'"
                        class="bg-brand-primary text-white">
                        Zur Kasse
                    </x-bachelordruck.button>
                </div>
            </div>
        @endif
    </section>
</div>

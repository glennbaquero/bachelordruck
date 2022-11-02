<div>
    @if($basketPosition->count())
        <x-bachelordruck.checkout-progress current="1"></x-bachelordruck.checkout-progress>
    @endif
    {{-- START LOOP--}}
    @forelse($basketPosition as $item)
        <div class="pl-10 pr-10 pt-4 pb-4">
            <div class="gap-32 xl:flex lg:flex md:flex-none sm:flex-none flex-wrap">
                <div class="border flex-none h-5/6 mx-auto w-80">
                    {!! $item->product->getFirstMedia('image')->img()->attributes(['class' => 'mx-auto']) !!}
                </div>

                <div class="xl:flex-1 lg:flex-1 md:flex-none sm:flex-none xs:flex-none flex-none  xl:w-64 lg:w-64 md:w-full sm:w-full xs:w-full xl:mt-0 lg:mt-0 sm:mt-5 xs:mt-5 mt-5">
                    <p class="text-title">{{  $item->product->title }}</p>
                    @if(!empty($item->configuration))
                        @foreach($item->configuration['details'] as $key => $detail)
                            <p class="{{ $key === 0 ? 'mt-7' : ''  }}">{{ $detail }} </p>
                        @endforeach
                    @endif
                </div>

                <div class="relative xl:mt-0 lg:mt-0 sm:mt-5 xs:mt-5 mt-5">
                    <span class="xl:absolute lg:static md:static sm:static xs:static static bottom-0 right-0 text-5xl text-right text-title">{{ $item->price }}€</span>
                </div>
            </div>
            <div class="border-t mt-2 ml-auto xl:w-75 lg:w-full md:w-full sm:w-full xs:w-full w-full xl:flex lg:flex md:flex-none sm:flex-none xs:flex-none flex-none grid xl:grid-cols-none lg:grid-cols-none md:grid-cols-2 sm:grid-cols-1 xs:grid-cols-1 grid-cols-1">
                <div class="mt-2 xl:w-40 lg:w-40 md:w-1/2 sm:w-full xs:w-full w-full">
                    <a class="cursor-pointer text-brand-primary text-regular" wire:click="removeItem({{$item->id}})">artikel löschen</a> <span class="xl:visible lg:visible md:invisible sm:invisible xs:invisible invisible">|</span>
                </div>
                <div class="mt-2 xl:w-40 lg:w-40 md:w-1/2 sm:w-full xs:w-full w-full">
                    <a class=" cursor-pointer text-brand-primary text-regular">artikel ändern</a> <span class="xl:visible lg:visible md:invisible sm:invisible xs:invisible invisible">|</span>
                </div>
                <div class="mt-2 xl:w-1/4 lg:w-1/4 md:w-full sm:w-full xs:w-full w-full">
                    <a class="xl:ml-2 lg:ml-2 md:ml-0 sm:ml-0 xs:ml-0 ml-0 cursor-pointer text-brand-primary text-regular">zusätzliche variante hinzufügen</a>
                </div>
                <div class="mt-2 xl:w-65 lg:w-65 md:w-full sm:w-full xs:w-full w-full">
                    <p class="xl:ml-2 lg:ml-2 md:ml-0 sm:ml-0 xs:ml-0 ml-0 text-regular xl:text-right lg:text-right md:text-left sm:text-left xs:text-left text-left"> inkl. 7 % MwSt zzgl. <span class="text-brand-primary">Versandkosten</span></p>
                </div>
            </div>
        </div>
    @empty
        <p class="font-bold text-2xl text-center mt-40 mb-40">KEIN EINZELSTÜCK GEFUNDEN</p>
    @endforelse
    {{--END--}}
    @if($basketPosition->count())
        <div class="pl-10 pr-10 pt-4 pb-4 grid grid-cols-2 ">
            <div class="col-span-2 text-right border-t border-brand-primary ">
                <p class="text-2xl text-title mt-10">Netto {{ $basketPosition->sum('price') }}€</p>
                <p class="text-2xl text-title mt-4">Bruto <span class="text-brand-primary text-5xl">{{ ($basketPosition->sum('price') * 0.07) + $basketPosition->sum('price') }}€</span></p>

                <div class="grid xl:grid-cols-5 lg:grid-cols-5 md:grid-cols-5 sm:grid-cols-1 xs:grid-cols-1 grid-cols-1 gap-5 float-right mt-12 mb-12">
                    <div class="xl:col-span-3 lg:col-span-3 md:col-span-3 sm:col-span-1 xs:col-span-1 col-span-1">
                        <button class=" p-4 bg-gray-100 text-title text-brand-primary text-2xl">Weitere Produkte hinzufügen</button>
                    </div>
                    <div class="xl:col-span-2 lg:col-span-2 md:col-span-2 sm:col-span-1 xs:col-span-1 col-span-1 ">
                        <button class="w-full text-center p-4 bg-brand-primary text-title text-white text-2xl">Zur Kasse</button>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>

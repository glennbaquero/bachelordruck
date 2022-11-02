<!-- Featured Section -->
@php
    use Domain\Products\Models\Product;
    $products = Product::query()
        ->sortedActive()
        ->with('media')
        ->get();
@endphp
<section class="bg-gray-100">
    <div class="relative pt-2 side-padding">
        <div class="font-josefin_sans pt-5 text-center">
            <h2 id="featured" class="mt-3 mx-auto page-title w-11/12 font-bold">FACHARBEIT DRUCKEN & BINDEN LASSEN</h2>
            <p class="mx-auto text-sm mt-4 custom__width-54__percent text-13pt">Lorem ipsum dolor sit amet consectetuer
                adipiscing
                elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis
                parturient montes, nasccetur ridiculus.</p>
        </div>

        @php
            $newVariantUrlSuffix = '';
            $basketId = request()->get('basket_id', '');
            if (!empty($basketId)) {
                $newVariantUrlSuffix = '/' . $basketId . '/zusatzliche_variante_hinzufugen';
            }
        @endphp

        <div
            class="gap gap-4 gap-y-10 grid lg:grid-cols-3 md:grid-cols-2 py-6 sm:gap-y-10 sm:grid-cols-none xl:grid-cols-4">
            @foreach($products as $product)
                <div class="col-span-1">
                    <div class="flex flex-col sm:flex-row h-full">
                        <div class="w-full sm:w-1/2 flex-grow-0 self-start">
                            {{ $product->getFirstMedia('image')->img() }}
                        </div>
                        <div class="flex flex-col w-full sm:w-1/2 flex-grow-0 font-josefin_sans">
                            <div class="flex-1">
                                <p class="font-bold lg:text-lg mb-1 md:text-lg sm:text-2xl text-12pt xl:text-2xl">
                                    {{ $product->title }}</p>
                                <p class="lg:text-sm md:text-sm sm:text-3xl xl:text-lg">{{ $product->tooltip }}</p>
                            </div>
                            <div class="w-full">
                                <p class="text-right font-bold">ab {{ $product->priceFormatted }} €</p>
                            </div>
                            <div class="w-full">
                                <a href="/de/facharbeit-drucken-und-binden-lassen/{{ $product->slug . $newVariantUrlSuffix}}" class="inline-block bg-sky-500 font-bold p-1 text-white text-center w-full">Auswählen</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

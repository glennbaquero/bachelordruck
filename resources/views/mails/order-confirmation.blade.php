@extends('layouts.email')

@section('body')
    <main class="container flex flex-col min-h-screen px-4 text-regular font-josefin_sans text-black mt-4">
        <section class="flex flex-col gap-4">
            <div class="page-title uppercase w-full mt-4">{{ $title }}</div>

            <div>
                <p class="page-title mb-2">Referenz</p>
                <p class="text-regular">{{ $order->session_id }}</p>
            </div>

            @if($order->payment === 'payment_in_advance')
            <hr>
            <div>
                <p class="page-title">Bankverbindung</p>
                <p class="text-regular"><span class="font-bold">Name der Bank</span>: bankname</p>
                <p class="text-regular"><span class="font-bold">Bankkonto</span>: bankaccountnumber</p>
                <p class="text-regular"><span class="font-bold">Name des Kontoinhabers</span>: accountholderrname</p>
            </div>
            @endif

            <hr>

            <div>
                <p class="page-title mb-2">Rechnungsadresse</p>
                <p class="text-regular">{{ $order->full_name }}, {{ $order->address }}</p>
            </div>

            <hr>

            <div>
                <p class="page-title mb-2">Lieferadresse</p>
                @if($order->is_recipient_different)
                    <p class="text-regular">{{ $order->recipient_full_name }}, {{ $order->recipient_address }}</p>
                @else
                    <p class="text-regular">{{ $order->full_name }}, {{ $order->address }}</p>
                @endif
            </div>

            <hr>

            <div>
                <p class="page-title mb-2">Lieferung</p>

                @foreach($order->orderPositions as $orderPosition)
                    <div class="flex gap-4">
                        <div class="flex-grow text-regular">
                            <p class="">
                                {{$orderPosition->product_details2}}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <p> {{ $orderPosition->total_cost_formatted }} €</p>
                        </div>
                    </div>

                    @if(! $loop->last)
                        <hr class="my-4">
                    @endif
                @endforeach
            </div>

            <hr class="mt-3 mb-3 border-brand-primary">

            <div class="flex w-full justify-end">
                <div class="flex flex-col items-end justify-end">
                    <p>Netto {{ $order->orderPositions->totalCostFormatted() }} €</p>
                    <p>Brutto <span class="font-bold text-3xl text-regular">{{ $order->orderPositions->grossFormatted() }} €</span></p>
                </div>
            </div>

            <hr class="mt-3 mb-3 border-brand-primary">

            <div class="flex w-full justify-center mb-2">
                <a href="{{ route('order.upload-center', ['language' => 'de', 'sessionId' => $order->session_id]) }}"
                   class="py-3 px-12 text-title text-xl bg-brand-primary text-white">
                    Weiter zum Datenupload
                </a>
            </div>
        </section>
    </main>
@endsection

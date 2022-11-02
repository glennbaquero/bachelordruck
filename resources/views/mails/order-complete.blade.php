<?php /** @var Domain\Orders\Models\OrderPosition $orderPosition */ ?>
@extends('layouts.email')

@section('body')
    <main class="container flex flex-col min-h-screen px-4 text-regular font-josefin_sans text-black mt-4">
        <section class="flex flex-col gap-4">
            <div class="page-title uppercase w-full mt-4">{{ $title }}</div>

            <div>
                <p class="page-title mb-2">Referenz</p>
                <p class="text-regular">{{ $order->session_id }}</p>
            </div>

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
                    <div class="flex space-x-4">
                        <div class="flex-grow text-regular">
                            <p class="">
                                {{$orderPosition->product_details2}}
                            </p>

                            <div class="ml-3 mt-3">
                                <p class="font-bold mb-2">Druckdatei: Facharbeit</p>

                                @if ($orderPosition->configuration['use_print_file_from_first_item'])
                                    <p class="italic mb-2">Bereits hochgeladene Datei von erster Auflage verwenden</p>
                                @endif


                                <ul class="list-disc ml-6 mb-2">
                                    @foreach($orderPosition->getMedia('thesis') as $media)
                                        <li class="text-regular">
                                            <small>
                                                {{ $media->file_name  }}
                                            </small>
                                        </li>
                                    @endforeach

                                </ul>

                                @if ($orderPosition->hasCoverImprint())
                                    <p class="font-bold mb-2">Druckdatei: Cover für Bindungt</p>

                                    <ul class="list-disc ml-6 mb-2">
                                        @foreach($orderPosition->getMedia('cover-imprint') as $media)
                                            <li class="text-regular">
                                                <small>
                                                    {{ $media->file_name  }}
                                                </small>
                                            </li>
                                        @endforeach

                                    </ul>
                                @endif

                                @if ($orderPosition->shallBurnToCd())
                                    <p class="font-bold mb-2">Daten-CD</p>

                                    @if ($orderPosition->shallUseCdFilesFromFirstItem())
                                        <p class="italic mb-2">Bereits hochgeladene Dateien von erster Auflage
                                            verwenden</p>
                                    @else
                                        @if ($orderPosition->shallIncludePrintFileInCdBurning())
                                            <p class="italic mb-2">Druckdatei Facharbeit mit auf CD brennen</p>
                                        @endif

                                        <ul class="list-disc ml-6">
                                            @foreach($orderPosition->getMedia('cd') as $media)
                                                <li class="text-regular">
                                                    <small>
                                                        {{ $media->file_name  }}
                                                    </small>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(! $loop->last)
                        <hr class="my-4">
                    @endif
                @endforeach
            </div>

            <hr class="mt-3 mb-3 border-brand-primary">

            <div class="flex w-full justify-center mb-2">
                <a href="{{ route('order.upload-center', ['language' => 'de', 'sessionId' => $order->session_id]) }}"
                   class="py-3 px-12 text-title text-xl bg-brand-primary text-white">
                    Dateien herunterladen
                </a>
            </div>
        </section>
    </main>
@endsection

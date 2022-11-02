<?php /** @var Domain\Orders\Models\OrderPosition $item */ ?>
<div x-data="{
    includePrintFiles: @entangle('includePrintFiles').defer,
    usePrintFileFromFirstItem: @entangle('usePrintFileFromFirstItem').defer,
    useCdFilesFromFirstItem: @entangle('useCdFilesFromFirstItem').defer,
}">
    <section class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full mb-3">Datenübergabe</h1>

        @foreach($items as $item)
            <div class="bg-gray-100 py-6">
                <div class="side-margin">
                    <div class="flex flex-col lg:flex-row gap-12 lg:gap-32">
                        <div class="flex items-center justify-center mx-auto border h-5/6 w-80 shrink-0">
                            {!! $item->product->getFirstMedia('image')->img()->attributes(['class' => 'mx-auto']) !!}
                        </div>

                        <div class="flex flex-col w-full">
                            <div class="flex w-full">
                                <div class="">
                                    <p class="text-title">{{  $item->product->title }}</p>
                                    <p class="mt-7 whitespace-pre-line">{{  $item->product_details1 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-margin py-6">
                <div class="flex flex-col lg:flex-row gap-x-12 lg:gap-32">
                    <div class="flex items-center justify-center mx-auto h-5/6 w-80 shrink-0">
                    </div>

                    <div class="flex flex-col gap-y-10 w-full">
                        <!-- Print/Thesis File -->
                        <div class="flex w-full">
                            <div>
                                <p class="text-title mb-2">Upload
                                    Druckdatei: Facharbeit</p>

                                @if ($loop->index > 0)
                                    @if (! $order->isCompleted())
                                        <div class="flex items-center gap-x-2 mb-4">
                                            <x-frontend.checkbox
                                                x-model="usePrintFileFromFirstItem[{{ $item->id }}]"
                                                id="use-print-file-from-first-item"
                                                name="use-print-file-from-first-item"
                                                label="Bereits hochgeladene Datei von erster Auflage verwenden"
                                                label-class="font-bold"
                                                value="1"
                                                @click="$wire.updateUsePrintFileFromFirstItem({{ $item->id }}, usePrintFileFromFirstItem[{{ $item->id }}])"
                                            ></x-frontend.checkbox>
                                            <x-spinner class="w-5 h-5" wire:loading
                                                       wire:target="updateUsePrintFileFromFirstItem"></x-spinner>
                                        </div>
                                    @elseif ($usePrintFileFromFirstItem[$item->id])
                                        <span class="font-extrabold text-brand-primary">✓</span> Bereits hochgeladene Datei von erster Auflage verwenden
                                    @endif
                                @endif

                                <div x-show="!usePrintFileFromFirstItem[{{ $item->id }}]">
                                    <x-file-upload
                                        :uploaded-files="$item->getMedia('thesis')->toArray()"
                                        :allow-upload="!$order->isCompleted()"
                                        max-files="1"
                                        :model-id="$item->id"
                                        model-class="{{ \Domain\Orders\Models\OrderPosition::class  }}"
                                        media-collection="thesis"
                                        button-class="py-3 px-4 text-xl bg-gray-100 text-brand-primary border-2 border-brand-primary border-dashed"
                                    >
                                    </x-file-upload>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Imprint File -->
                        @if ($item->hasCoverImprint())
                            <div x-show="!usePrintFileFromFirstItem[{{ $item->id }}]" class="flex w-full">
                                <div>
                                    <p class="text-title mb-2">Upload Druckdatei: Cover für Bindung</p>
                                    <p class="text-lg font-bold mb-4">Nur in Word Datei und in schwarz/weiß</p>
                                    <x-file-upload
                                        :uploaded-files="$item->getMedia('cover-imprint')->toArray()"
                                        :allow-upload="!$order->isCompleted()"
                                        max-files="1"
                                        :model-id="$item->id"
                                        model-class="{{ \Domain\Orders\Models\OrderPosition::class  }}"
                                        media-collection="cover-imprint"
                                        button-class="py-3 px-4 text-xl bg-gray-100 text-brand-primary border-2 border-brand-primary border-dashed"
                                        :file-types="['doc', 'docx']"
                                    >
                                    </x-file-upload>
                                </div>
                            </div>
                        @endif

                        @if ($item->shallBurnToCd())
                            <div class="flex w-full">
                                <div>
                                    <p class="text-title mb-2">Upload Daten-CD</p>

                                    @if ($loop->index > 0)
                                        @if(! $order->isCompleted())
                                            <div class="flex items-center gap-x-2 mb-4">
                                                <x-frontend.checkbox
                                                    x-model="useCdFilesFromFirstItem[{{ $item->id }}]"
                                                    id="use-cd-files-from-first-item"
                                                    name="use-cd-files-from-first-item"
                                                    label="Bereits hochgeladene Dateien von erster Auflage verwenden"
                                                    label-class="font-bold"
                                                    value="1"
                                                    @click="$wire.updateUseCdFilesFromFirstItem({{ $item->id }}, useCdFilesFromFirstItem[{{ $item->id }}])"
                                                ></x-frontend.checkbox>
                                                <x-spinner class="w-5 h-5" wire:loading
                                                           wire:target="updateUseCdFilesFromFirstItem"></x-spinner>
                                            </div>
                                        @elseif ($useCdFilesFromFirstItem[$item->id])
                                            <span class="font-extrabold text-brand-primary">✓</span> Bereits hochgeladene Dateien von erster Auflage verwenden
                                        @endif
                                    @endif

                                    <div x-show="!useCdFilesFromFirstItem[{{ $item->id }}]">
                                        @if(!$order->isCompleted())
                                            <div class="flex items-center gap-x-2 mb-4">
                                                <x-frontend.checkbox
                                                    x-model="includePrintFiles[{{ $item->id }}]"
                                                    id="include-print-pdf"
                                                    name="include-print-pdf"
                                                    label="Druckdatei Facharbeit mit auf CD brennen"
                                                    label-class="font-bold"
                                                    value="1"
                                                    @click="$wire.updateIncludePrintFiles({{ $item->id }}, includePrintFiles[{{ $item->id }}])"
                                                ></x-frontend.checkbox>
                                                <x-spinner class="w-5 h-5" wire:loading
                                                           wire:target="updateIncludePrintFiles"></x-spinner>
                                            </div>
                                        @elseif ($includePrintFiles[$item->id])
                                            <span class="font-extrabold text-brand-primary">✓</span> Druckdatei Facharbeit mit auf CD brennen
                                        @endif

                                        <x-file-upload
                                            :uploaded-files="$item->getMedia('cd')->toArray()"
                                            :allow-upload="!$order->isCompleted()"
                                            max-file-size="1GB"
                                            :model-id="$item->id"
                                            model-class="{{ \Domain\Orders\Models\OrderPosition::class  }}"
                                            media-collection="cd"
                                            button-class="py-3 px-4 text-xl bg-gray-100 text-brand-primary border-2 border-brand-primary border-dashed">
                                        </x-file-upload>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach

        <div class="bg-gray-100 py-6">
            <div class="side-margin flex items-center justify-center">
                @if(! $order->isCompleted())
                    <x-bachelordruck.button class="bg-brand-primary text-white" wire:click="complete">
                        Datenübergabe abschließen
                        <x-spinner wire:loading wire:target="complete"
                                   class="w-3 h-3"></x-spinner>
                    </x-bachelordruck.button>
                @else
                    <p class="text-title text-brand-primary">Datenübertragung abgeschlossen</p>
                @endif
            </div>

            <div class="side-margin flex items-center justify-center">
                @if ($errors->any())
                     <small><span class="text-red-500">{{ implode(', ', $errors->all()) }}</span></small>
                @endif
            </div>
        </div>
    </section>
</div>


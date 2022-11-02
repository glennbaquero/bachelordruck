@extends('layouts.page')

@section('title')
    {{ $gallery->title }}
@endsection

@section('content')

<div class="bg-white">
    <div class="pt-6 pb-16 sm:pb-24">
        <div class="mt-8 max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8 mb-12">
                <div class="mt-8 lg:mt-0 lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:row-span-3">
                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-2 lg:gap-8 mb-8">
                        {{ $gallery->getMedia('image')->first()->img()->attributes(['class' => 'lg:col-span-2 lg:row-span-2 rounded-lg w-full', 'alt' => '']) }}
                    </div>
                    @if (strlen($gallery->description) > 950)
                        <div class="mt-2">
                            <div class="mt-4 prose prose-sm text-gray-500">
                                {!! $gallery->description !!}
                            </div>
                        </div>
                    @endif
                </div>
                @if (strlen($gallery->description) <= 950)
                    <div class="lg:col-span-5">
                        <div class="mt-2">
                            <h2>{{ $gallery->title }}</h2>
                            <div class="mt-4 prose prose-sm text-gray-500">
                                {!! $gallery->description !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <x-frontend.lightbox>
                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8">
                    @foreach ($gallery->getMedia('images') as $image)
                        <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden">
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-96">
                                {{
                                    $image
                                    ->img()
                                    ->attributes([
                                        'class' => 'lightbox cursor-zoom-in w-full h-full object-center object-cover sm:w-full sm:h-full',
                                        'data-name' => $image->uuid,
                                        'data-description' => $image->getCustomProperty('description', '')
                                    ])
                                }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-frontend.lightbox>
            @if ($gallery->getMedia('pdf')->count() > 0)
                <x-frontend.zoom>
                    <div class="py-16 my-16 bg-gray-50 overflow-hidden lg:py-8">
                        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">

                            <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">Downloads</h3>
                            @foreach ($gallery->getMedia('pdf') as $pdf)
                                <dl class="mt-10 space-y-10">
                                    <dt>
                                        <a href="{{ $pdf->original_url }}" target="_blank" class="zoom flex flex-row items-center" data-name="{{ $pdf->name }}">
                                    <span
                                        class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </span>
                                            <p class="ml-4 text-lg leading-6 font-medium text-gray-900">{{ $pdf->name }}</p>
                                        </a>
                                    </dt>
                                </dl>
                            @endforeach
                        </div>
                    </div>
                </x-frontend.zoom>
            @endif
        </div>
    </div>

</div>
@endsection

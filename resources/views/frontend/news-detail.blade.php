@extends('layouts.page')
@section('title')
    {{ $news->title }}
@endsection
@section('content')
    <div class="p-12 w-full mx-auto">
        <x-frontend.section-textcenter>
            <x-slot name="title">
                {{ $news->title }}
            </x-slot>
        </x-frontend.section-textcenter>
        <div><img src="{{ $news->getFirstMediaUrl('image') }}" class="w-full" alt=""></div>
        <p class="text-center w-3/4 mx-auto p-4">
            {{ $news->description }}
        </p>
    </div>
    <div class="p-12 w-full mx-auto">
        <x-frontend.lightbox>
            <div class="flex flex-col items-center lg:p-12 lg:h-full lg:grid lg:grid-cols-4 lg:gap-4 lg:content-start lg:my-auto">
                @foreach ($news->getMedia('images') as $image)
                    {{ $image->img()->attributes(['class' => 'lightbox cursor-zoom-in lg:w-auto w-1/2 p-4 lg:p-0', 'data-name' => $image->name]) }}
                @endforeach
            </div>
        </x-frontend.lightbox>
    </div>


    @if ($news->getMedia('pdf')->count() > 0)
        <x-frontend.zoom>
            <div class="py-16 my-16 bg-gray-50 overflow-hidden lg:py-8">
                <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">

                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">Downloads</h3>
                    @foreach ($news->getMedia('pdf') as $pdf)
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
@endsection

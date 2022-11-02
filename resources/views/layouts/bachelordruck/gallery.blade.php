@extends('layouts.base')

@section('body')
    <main class="flex flex-col min-h-screen mx-auto text-regular font-josefin_sans">
        @if(config('cms.header'))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation"/>
        @endif

        @if(config('cms.banner'))
            <div class="relative">
                <x-dynamic-component component="{{  config('cms.banner')  }}" :banner="$banner"/>

                @if(config('cms.banner_overlay') && $banner)
                    <x-dynamic-component component="{{  config('cms.banner_overlay')  }}"/>
                @endif
            </div>
        @endif

        <section class="flex flex-col">
            @php
                $page->page->load('galleries.media');
                $bilderGalerie = $page->page->galleries->where('slug', 'bildergalerie')->first();
                $logos = $page->page->galleries->where('slug', 'logos')->first();
            @endphp

            <x-bachelordruck.gallery
                :images="$bilderGalerie->media"
                title="{{ __('Picture Gallery') }}"
                image-size-class="gallery-150"
                gallery-id="picture-gallery"
                fullscreen
            ></x-bachelordruck.gallery>

            @if ($logos->media)
                <div class="xl:container xl:mx-auto border border-brand-secondary mt-12"></div>
                <x-bachelordruck.gallery
                    :images="$logos->media"
                    image-size-class="gallery-200"
                    gallery-id="logos-gallery"
                ></x-bachelordruck.gallery>
            @endif
        </section>

        @if (isset($page))
            <x-containers-list :containers="$page->containers"></x-containers-list>
        @endif

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

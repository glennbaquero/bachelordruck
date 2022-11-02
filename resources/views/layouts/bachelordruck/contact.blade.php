@extends('layouts.base')

@section('body')


    <main class="flex flex-col min-h-screen mx-auto text-regular font-josefin_sans">
        @if(config('cms.header'))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation"/>
        @endif

        @yield('content')

        @if (isset($page))
            <div class="contact-page__container header-margin-top">
                <x-containers-list :containers="$page->containers"></x-containers-list>
            </div>
        @endif

        @php
            $galleries = $page->page->galleries ?? null;
        @endphp

        <div class="grid xl:grid-cols-5 lg:grid-cols-5 md:grid-cols-5 sm:grid-cols-3 grid-cols-2">
            @foreach($galleries as $gallery)
                @foreach($gallery->getMedia('images') as $image)
                    <div class="col-span-1">
                        {!! $image->toHtml() !!}
{{--                        <img src="{{ $image->getFullUrl() }}">--}}
                    </div>
                @endforeach
            @endforeach
        </div>
        <div style="height: 80vh;" class="side-padding my-10">
            <div id="map" class="w-full h-full"></div>
        </div>

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>

    @pushonce('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('bachelordruck.gmap_api_key') }}&callback=initMap&v=weekly"
            defer
        ></script>

        <script>
            let map;

            function initMap() {

                const myLatLng = { lat: 53.5924237, lng: 10.041771 };

                map = new google.maps.Map(document.getElementById("map"), {
                    center: myLatLng,
                    zoom: 18,
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map,
                });
            }

            window.initMap = initMap;
        </script>
    @endpushonce
@endsection

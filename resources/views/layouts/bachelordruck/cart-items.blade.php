@extends('layouts.base')

@section('body')
    <main class="flex flex-col min-h-screen mx-auto font-raleway">
        @if(config('cms.header'))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation"/>
        @endif

        @yield('content')

        <div class="grid grid-cols-3 mt-36 mx-auto w-5/6">
            <div class="col-span-2">
                <div class="grid grid-cols-3">
                    <div class="col-span-1">
                        <img src="{{ asset('images/books/Buchcover-konfigurator.png') }}">
                    </div>
                    <div class="col-span-2">
                        <p class="text-title font-bold">PRODUCT NAME</p>
                        <p class="">Qty: 1</p>
                        <p class="">Price: 1000</p>
                        <p class="text-title font-bold mt-2">Configuration:</p>
                        <ul class="list-inside list-disc">
                            <li>TEST</li>
                            <li>TEST</li>
                            <li>TEST</li>
                            <li>TEST</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                t
            </div>
        </div>

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

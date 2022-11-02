@extends('layouts.base')

@section('body')


    <main class="flex flex-col min-h-screen mx-auto text-regular font-josefin_sans">
        @if(config('cms.header'))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation"/>
        @endif

        @yield('content')

        @if (isset($page))
            <div class="lg:w-65 md:w-full mx-auto price_content--container sm:w-full w-full xl:w-65 xs:w-full">
                <x-containers-list :containers="$page->containers" :summarize="true"></x-containers-list>
            </div>
        @endif

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

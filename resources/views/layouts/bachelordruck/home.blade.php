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

        @if(config('cms.featured'))
            <x-dynamic-component component="{{  config('cms.featured')  }}"/>
        @endif

        @yield('content')

        @if (isset($page))
            <x-containers-list :containers="$page->containers"></x-containers-list>
        @endif

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

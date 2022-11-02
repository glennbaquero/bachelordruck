@extends('layouts.base')

@section('title')
    @if (isset($page)) {{ $page->name }} @endif
@endsection

@section('body')
    <main class="flex flex-col min-h-screen mx-auto text-regular font-josefin_sans">
        @if(config('cms.header') && ! empty($mainNavigation))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation" block/>
        @endif

        @if(config('cms.banner') && ! empty($banner))
            <div class="relative">
                <x-dynamic-component component="{{  config('cms.banner')  }}" :banner="$banner"/>

                @if(config('cms.banner_overlay'))
                    <x-dynamic-component component="{{  config('cms.banner_overlay')  }}"/>
                @endif
            </div>
        @endif

        @if (isset($page))
            <x-containers-list :containers="$page->containers"></x-containers-list>
        @endif

       <div class="flex-1">
            @isset($livewireContent)
                {{ $livewireContent }}
            @endisset

            @yield('content')
            @yield('page_content')
       </div>

        @if(config('cms.featured'))
            <x-dynamic-component component="{{  config('cms.featured')  }}"/>
        @endif

        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

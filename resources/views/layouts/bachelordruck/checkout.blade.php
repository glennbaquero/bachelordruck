@extends('layouts.base')

@section('body')


    <main class="flex flex-col min-h-screen mx-auto text-regular font-josefin_sans">
        @if(config('cms.header'))
            <x-dynamic-component component="{{  config('cms.header')  }}" :main-navigation="$mainNavigation"/>
        @endif



        {{-- Stepper --}}
        <livewire:bachelordruck.checkout></livewire:bachelordruck.checkout>
        @if(config('cms.footer'))
            <x-dynamic-component component="{{  config('cms.footer') }}" :footer-navigation="$footerNavigation"/>
        @endif
    </main>
@endsection

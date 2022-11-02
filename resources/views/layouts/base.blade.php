<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')"/>
    @endif

    @if(isset($robots))
        <meta name="robots" content="{{ $robots }}">
    @else
        <meta name="robots" content="all">
    @endif

    <link rel="icon" href="{{ url(asset('favicon.svg')) }}">

    @if(isset($canonical))
        <link rel="canonical" href="{{ $canonical }}"/>
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    <wireui:styles/>

    <livewire:styles/>

    <wireui:scripts/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('meta')
        @yield('meta')
    @endif

    @stack('styles')
</head>

<body class="relative">
{{--<x-loading-screen class="bg-black opacity-90">--}}
{{--    Loading--}}
{{--</x-loading-screen>--}}

@yield('body')
@if (session('message'))
    <x-notification
        :redirect="true"
        message-to-display="{{ (session('message')) }}"
    />
@endif
<livewire:scripts/>
</body>
@stack('scripts')
</html>

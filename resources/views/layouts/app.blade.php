@extends('layouts.base')
@section('body')
    <div>
        @include('includes.backend.header')
        <header class="bg-white shadow">
            <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{__('Admin Dashboard')}}
                </h1>
            </div>
        </header>
        <main>
            <div class="max-w-full mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </main>
    </div>
@endsection

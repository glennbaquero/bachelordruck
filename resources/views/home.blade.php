@extends('layouts.page')

@section('content')
    <div><img src="/img/x-head.jpg" class="w-full" alt=""></div>
    @include('frontend.partials.featured-nav', ['bg' => 'bg-gray-300'])

    <x-frontend.section-textcenter class="bg-gray-100">
        <x-slot name="title">
            Lorem ipsum dolor sit amet, consectetuer adipiscing dolor sit amet, consectetuer adipiscing
        </x-slot>
        <p>orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
            fringilla vel, aliquet nec, vulputate eget, arc</p>
    </x-frontend.section-textcenter>

    <x-frontend.section-imagetext class="bg-gray-300" imgurl="/img/x-contentimg.jpg">
        <x-slot name="title">
            Lorem ipsum dolor sit amet, consectetuer adipiscing dolor sit amet, consectetuer
            adipiscing
        </x-slot>
        <p>orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
            massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
            quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
            Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arc</p>
    </x-frontend.section-imagetext>
@endsection

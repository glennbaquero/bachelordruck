@extends('layouts.app')

@section('content')

<div class="flex items-center">
    <div class="bg-gray-500 h-8 w-96"></div>
    <div class="bg-blue-500 h-16 w-96"></div>
    <div class="bg-green-500 h-4 w-96"></div>
</div>

<h1>Test View</h1>

    <x-element.avatar
        name="Michael Schmidt"
        abbrev="MS"
        color="#990000"
        :short="false">
    </x-element.avatar>


<x-element.avatar
    name="Michael Schmidt"
    abbrev="MS"
    color="#990000"
    :short="true">
</x-element.avatar>

    <x-value.team value="128"></x-value.team>

@endsection

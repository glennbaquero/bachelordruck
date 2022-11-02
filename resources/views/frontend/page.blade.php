@extends('layouts.'.$layout)

@section('title')
    {{ $page->name }}
@endsection

@section('content')
    <div class="flex-grow">
        @foreach($page->containers as $container)
            <x-dynamic-component component="{{  $container->type->getFrontendComponent() }}" :container="$container"
                class="{{ ($loop->index % 2 === 0) ? config('cms.container_bg_even') : config('cms.container_bg_odd')}}"/>
        @endforeach
    </div>
@endsection

@extends('layouts.page')

@section('content')
    <div
        class="
    flex
    items-center
    justify-center
    w-screen
    h-screen
  "
    >
        <x-dynamic-component component="{{  config('cms.404')  }}"/>
    </div>
@endsection

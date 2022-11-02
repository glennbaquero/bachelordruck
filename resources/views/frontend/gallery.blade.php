@extends('layouts.page')
@section('title')
    {{ $page->name }}
@endsection
@section('content')
    @include('frontend.partials.galleries')
@endsection

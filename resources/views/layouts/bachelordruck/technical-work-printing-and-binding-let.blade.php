@php
    config()->set('cms.featured', false);
@endphp

@extends('layouts.bachelordruck.page')

@section('content')
    <section class="w-full header-margin-top">
        <livewire:freitag.form-inquiries product="{{ request()->get('type', 'contact') }}"></livewire:freitag.form-inquiries>
    </section>
{{--    <livewire:freitag.form-inquiries form-type="{{ request()->get('type', 'contact') }}"></livewire:freitag.form-inquiries>--}}
@endsection

@component('mail::message')
# {{ $title }}

@component('mail::table')
|          |         |
| ------------- |---------------|
@foreach($tableData as $data)
| {{$data['label']}}      | **{{$data['value']}}**      |
@endforeach
@endcomponent

## Orders

<a href="{{url('')}}">{{ config('app.name') }}</a>
@endcomponent


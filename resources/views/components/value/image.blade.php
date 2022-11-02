@props([
'url' => '',
])
@if ($url !== '')
    <div class="flex -space-x-2">
        <img class="inline-block h-12 w-12" src="{{ $url }}" alt="" style="box-shadow: 0 0 0 1px">
    </div>
@endif

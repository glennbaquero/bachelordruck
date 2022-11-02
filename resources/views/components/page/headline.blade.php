@props([
'model' => ''
'placeholder' => ''
])

<div {{ $attributes }}>
    <x-input wire:model="$model" label="{{ __('page.headline') }}" placeholder="{{ $placeholder }}"></x-input>
</div>
